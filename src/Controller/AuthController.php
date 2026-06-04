<?php

namespace App\Controller;

use PDO;

class AuthController {
    public function __construct(private PDO $pdo) {}

    public function loginAction(): void {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Had l-bloc kay-khdem mlli l-patient/tbib/admin kay-cliqui 3la "Se connecter" (POST)
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';

            // 1. Récupérer l'utilisateur depuis la table 'users'
            $sql = "SELECT * FROM users WHERE email = :email";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute(['email' => $email]);
            $user = $stmt->fetch();

            // 2. Vérification brute dial l-password (b7al l-data d demo li insertina l-bare7)
            if ($user && $password === $user['password']) {

                // Khbi3 l-data f s-session
                $_SESSION['user'] = [
                    'id' => $user['id'],
                    'nom' => $user['nom'],
                    'prenom' => $user['prenom'],
                    'email' => $user['email'],
                    'role' => $user['role']
                ];

                // 🔴 CAS 1: MÉDECIN
                if ($user['role'] === 'medecin') {
                    // Darori n-jbdou l'ID unique mn table 'medecins' bach l-agenda d tbib t-3rfou chkon
                    $sqlMed = "SELECT id FROM medecins WHERE id_user = :id_user";
                    $stmtMed = $this->pdo->prepare($sqlMed);
                    $stmtMed->execute(['id_user' => $user['id']]);
                    $medecin = $stmtMed->fetch();

                    if ($medecin) {
                        $_SESSION['user']['id_medecin'] = $medecin['id'];
                    }

                    header('Location: index.php?action=doctor_dashboard');
                    exit();
                }

                // 🔵 CAS 2: PATIENT
                if ($user['role'] === 'patient') {
                    header('Location: index.php?action=patient_dashboard');
                    exit();
                }

                // 🟢 CAS 3: ADMIN
                if ($user['role'] === 'admin') {
                    header('Location: index.php?action=admin_dashboard');
                    exit();
                }

            } else {
                // Ila dkhl l-data ghalta, khbi l-erreur f s-session o rj3o l l-login
                $_SESSION['error_msg'] = "Email ou mot de passe incorrect.";
                header('Location: index.php?action=login');
                exit();
            }
        }

        // Ila dkhl l-page 3adi (GET), affichi lih l-formulaire direct
        include __DIR__ . '/../../templates/auth/login_register.php';
    }

    public function logoutAction(): void {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        session_destroy();
        header('Location: index.php?action=login');
        exit();
    }
}