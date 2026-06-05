<?php
/**
 * Configuration de la connexion à la base de données
 * Ce fichier lit les paramètres depuis le fichier .env
 * et crée une connexion PDO à MySQL
 */

// Chemin vers le fichier .env
$envPath = __DIR__ . '/../.env';

// Lire le fichier .env et charger les variables
if (file_exists($envPath)) {
    $lines = file($envPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        // Ignorer les commentaires
        if (strpos(trim($line), '#') === 0) continue;
        // Séparer nom=valeur
        list($name, $value) = explode('=', $line, 2);
        $name = trim($name);
        $value = trim($value);
        // Mettre dans l'environnement
        putenv("{$name}={$value}");
    }
} else {
    die("Erreur : Le fichier .env est introuvable.");
}

// Définir les constantes de connexion
define('DB_HOST', getenv('DB_HOST') ?: 'localhost');
define('DB_NAME', getenv('DB_NAME') ?: 'medflow_db');
define('DB_USER', getenv('DB_USER') ?: 'root');
define('DB_PASS', getenv('DB_PASS') !== false ? getenv('DB_PASS') : '');

try {
    // Créer la connexion PDO
    $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4";

    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];

    $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);

} catch (PDOException $e) {
    error_log("Database connection error: " . $e->getMessage());
    die("Erreur de connexion à la base de données. Veuillez contacter l'administrateur.");
}

// Retourner l'objet PDO
return $pdo;
