<?php
/**
 * Configuration de sécurité
 * Contient les fonctions utilitaires pour la sécurité de l'application
 */

// --- Security Headers ---
header('X-Content-Type-Options: nosniff');
header('X-Frame-Options: DENY');
header('X-XSS-Protection: 1; mode=block');
header('Referrer-Policy: strict-origin-when-cross-origin');
header('Permissions-Policy: camera=(), microphone=(), geolocation=()');

// --- Session Hardening ---
ini_set('session.cookie_httponly', '1');
ini_set('session.cookie_samesite', 'Strict');
ini_set('session.use_strict_mode', '1');

if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
    ini_set('session.cookie_secure', '1');
}

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

// --- CSRF Token Helpers ---

function generateCsrfToken(): string
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function csrfTokenField(): string
{
    return '<input type="hidden" name="csrf_token" value="' . htmlspecialchars(generateCsrfToken()) . '">';
}

function validateCsrfToken(): bool
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    $token = $_POST['csrf_token'] ?? '';
    if (empty($token) || empty($_SESSION['csrf_token'])) {
        return false;
    }
    return hash_equals($_SESSION['csrf_token'], $token);
}
