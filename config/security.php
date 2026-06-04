<?php
/**
 * Configuration de sécurité
 * Contient les fonctions utilitaires pour la sécurité de l'application
 */

/**
 * Hacher un mot de passe avec bcrypt
 */
function hashPassword(string $password): string
{
    return password_hash($password, PASSWORD_BCRYPT);
}

/**
 * Vérifier un mot de passe contre son hash
 */
function verifyPassword(string $password, string $hash): bool
{
    return password_verify($password, $hash);
}

/**
 * Nettoyer une entrée utilisateur (protection XSS)
 */
function cleanInput(string $data): string
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
    return $data;
}

/**
 * Vérifier si l'utilisateur est connecté
 */
function isLoggedIn(): bool
{
    return isset($_SESSION['user']);
}

/**
 * Récupérer le rôle de l'utilisateur connecté
 */
function getUserRole(): string
{
    return $_SESSION['user']['role'] ?? '';
}

/**
 * Rediriger vers une page
 */
function redirect(string $action): void
{
    header("Location: index.php?action=" . $action);
    exit();
}
