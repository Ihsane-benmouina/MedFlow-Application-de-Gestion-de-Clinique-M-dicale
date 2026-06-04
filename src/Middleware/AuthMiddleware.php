<?php

namespace App\Middleware;

/**
 * Middleware d'authentification
 * Vérifie que l'utilisateur est connecté et a le bon rôle
 */
class AuthMiddleware
{
    /**
     * Vérifier que l'utilisateur est connecté
     * Redirige vers la page de login sinon
     */
    public static function requireLogin(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['user'])) {
            header('Location: index.php?action=login');
            exit();
        }
    }

    /**
     * Vérifier que l'utilisateur a le rôle requis
     * Redirige vers la page de login si le rôle ne correspond pas
     */
    public static function requireRole(string $role): void
    {
        // D'abord vérifier la connexion
        self::requireLogin();

        // Ensuite vérifier le rôle
        if ($_SESSION['user']['role'] !== $role) {
            header('Location: index.php?action=login');
            exit();
        }
    }

    /**
     * Vérifier si l'utilisateur est connecté (sans redirection)
     */
    public static function isLoggedIn(): bool
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        return isset($_SESSION['user']);
    }

    /**
     * Récupérer le rôle de l'utilisateur connecté
     */
    public static function getRole(): string
    {
        return $_SESSION['user']['role'] ?? '';
    }

    /**
     * Récupérer l'ID de l'utilisateur connecté
     */
    public static function getUserId(): int
    {
        return (int) ($_SESSION['user']['id'] ?? 0);
    }
}
