<?php

namespace App\Controller;

use App\Helpers\SessionHelper;
use PDO;

class AuthController {
    public function __construct(private PDO $pdo) {}

    public function loginAction(): void {
        SessionHelper::ensureStarted();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';

            $sql = "SELECT * FROM users WHERE email = :email";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute(['email' => $email]);
            $user = $stmt->fetch();

            if ($user && $password === $user['password']) {

                $_SESSION['user'] = [
                    'id' => $user['id'],
                    'nom' => $user['nom'],
                    'prenom' => $user['prenom'],
                    'email' => $user['email'],
                    'role' => $user['role']
                ];

                if ($user['role'] === 'medecin') {
                    $sqlMed = "SELECT id FROM medecins WHERE id_user = :id_user";
                    $stmtMed = $this->pdo->prepare($sqlMed);
                    $stmtMed->execute(['id_user' => $user['id']]);
                    $medecin = $stmtMed->fetch();

                    if ($medecin) {
                        $_SESSION['user']['id_medecin'] = $medecin['id'];
                    }

                    SessionHelper::redirect('doctor_dashboard');
                }

                if ($user['role'] === 'patient') {
                    SessionHelper::redirect('patient_dashboard');
                }

                if ($user['role'] === 'admin') {
                    SessionHelper::redirect('admin_dashboard');
                }

            } else {
                SessionHelper::setError("Email ou mot de passe incorrect.");
                SessionHelper::redirect('login');
            }
        }

        include __DIR__ . '/../../templates/auth/login_register.php';
    }

    public function logoutAction(): void {
        SessionHelper::ensureStarted();
        session_destroy();
        SessionHelper::redirect('login');
    }
}
