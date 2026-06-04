<?php

namespace App\Controller;

use App\Repository\UtilisateurRepository;
use App\Repository\MedecinRepository;
use App\Middleware\AuthMiddleware;
use PDO;

/**
 * Contrôleur d'authentification
 * Gère le login, le logout et l'inscription
 */
class AuthController
{
    private UtilisateurRepository $utilisateurRepository;
    private MedecinRepository $medecinRepository;

    public function __construct(PDO $pdo)
    {
        $this->utilisateurRepository = new UtilisateurRepository($pdo);
        $this->medecinRepository = new MedecinRepository($pdo);
    }

    /**
     * Afficher le formulaire de login ou traiter la connexion
     */
    public function loginAction(): void
    {
        // Si déjà connecté, rediriger vers le bon dashboard
        if (AuthMiddleware::isLoggedIn()) {
            $this->redirectByRole($_SESSION['user']['role']);
            return;
        }

        // Traiter le formulaire de connexion (POST)
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';

            // Chercher l'utilisateur par email
            $user = $this->utilisateurRepository->findByEmail($email);

            // Vérifier le mot de passe
            if ($user && password_verify($password, $user['password'])) {
                // Stocker les infos en session
                $_SESSION['user'] = [
                    'id'     => $user['id'],
                    'nom'    => $user['nom'],
                    'prenom' => $user['prenom'],
                    'email'  => $user['email'],
                    'role'   => $user['role'],
                ];

                // Si c'est un médecin, stocker aussi son id_medecin
                if ($user['role'] === 'medecin') {
                    $medecin = $this->medecinRepository->findByUserId($user['id']);
                    if ($medecin) {
                        $_SESSION['user']['id_medecin'] = $medecin['id_medecin'];
                    }
                }

                // Rediriger vers le bon dashboard
                $this->redirectByRole($user['role']);
                return;
            } else {
                // Erreur de connexion
                $_SESSION['error_msg'] = "Email ou mot de passe incorrect.";
                header('Location: index.php?action=login');
                exit();
            }
        }

        // Afficher le formulaire de login (GET)
        include __DIR__ . '/../../templates/auth/login.php';
    }

    /**
     * Afficher le formulaire d'inscription ou traiter l'inscription
     */
    public function registerAction(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nom = trim($_POST['nom'] ?? '');
            $prenom = trim($_POST['prenom'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';

            // Vérifier que l'email n'existe pas déjà
            $existing = $this->utilisateurRepository->findByEmail($email);
            if ($existing) {
                $_SESSION['error_msg'] = "Cet email est déjà utilisé.";
                header('Location: index.php?action=register');
                exit();
            }

            // Hacher le mot de passe
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

            // Créer le patient
            $this->utilisateurRepository->create($nom, $prenom, $email, $hashedPassword, 'patient');

            $_SESSION['success_msg'] = "Compte créé avec succès ! Connectez-vous.";
            header('Location: index.php?action=login');
            exit();
        }

        // Afficher le formulaire d'inscription (GET)
        include __DIR__ . '/../../templates/auth/login.php';
    }

    /**
     * Déconnecter l'utilisateur
     */
    public function logoutAction(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        session_destroy();
        header('Location: index.php?action=login');
        exit();
    }

    /**
     * Rediriger vers le dashboard selon le rôle
     */
    private function redirectByRole(string $role): void
    {
        switch ($role) {
            case 'admin':
                header('Location: index.php?action=admin_dashboard');
                break;
            case 'medecin':
                header('Location: index.php?action=doctor_dashboard');
                break;
            case 'patient':
                header('Location: index.php?action=patient_dashboard');
                break;
            default:
                header('Location: index.php?action=login');
        }
        exit();
    }
}
