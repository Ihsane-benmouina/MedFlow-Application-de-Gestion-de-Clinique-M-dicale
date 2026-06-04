<?php

namespace App\Helpers;

class SessionHelper
{
    /**
     * Ensure the session is started (safe to call multiple times).
     */
    public static function ensureStarted(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    /**
     * Require a specific role to access the page.
     * Redirects to login if the user is not authenticated or does not have the required role.
     */
    public static function requireRole(string $role): void
    {
        self::ensureStarted();

        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== $role) {
            header('Location: index.php?action=login');
            exit();
        }
    }

    /**
     * Get the current authenticated user data from session, or null if not logged in.
     */
    public static function getUser(): ?array
    {
        self::ensureStarted();
        return $_SESSION['user'] ?? null;
    }

    /**
     * Set a flash error message in the session.
     */
    public static function setError(string $message): void
    {
        self::ensureStarted();
        $_SESSION['error_msg'] = $message;
    }

    /**
     * Get and clear the flash error message.
     */
    public static function getError(): ?string
    {
        self::ensureStarted();
        $error = $_SESSION['error_msg'] ?? null;
        unset($_SESSION['error_msg']);
        return $error;
    }

    /**
     * Redirect to a given action and stop execution.
     */
    public static function redirect(string $action): void
    {
        header("Location: index.php?action=$action");
        exit();
    }
}
