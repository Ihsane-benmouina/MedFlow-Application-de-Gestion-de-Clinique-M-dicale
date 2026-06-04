<?php
// Démarrer la session en premier lieu
ob_start();

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


// 1. Récupérer l'objet PDO de la base de données (Fichier dyalk li fih return $pdo)
$pdo = require_once __DIR__ . '/../config/database.php';

// 2. Inclure les Controllers (Manuellement ou via Autoload)
require_once __DIR__ . '/../src/Controller/DoctorController.php';
require_once __DIR__ . '/../src/Controller/PatientController.php';
require_once __DIR__ . '/../src/Controller/AuthController.php';

use App\Controller\AuthController;

$authController = new AuthController($pdo);

use App\Controller\DoctorController;
use App\Controller\PatientController;

// 3. Instancier les Controllers en leur passant la connexion $pdo
$doctorController = new DoctorController($pdo);
$patientController = new PatientController($pdo);

// 4. Déterminer l'action demandée (Par défaut 'home')
$action = $_GET['action'] ?? 'home';

// 5. Le Switch Central (Routing)
// 5. Le Switch Central (Routing Corrigé)
switch ($action) {

    // ----- CLIENT / PATIENT -----
    case 'home':
        $patientController->index();
        break;

    case 'reserver_rdv':
        $patientController->reserver();
        break;

    case 'patient_dashboard':
        $patientController->dashboard();
        break;

    // ----- MÉDECIN (DOCTOR) -----
    case 'doctor_dashboard':
        $doctorController->dashboard();
        break;

    case 'doctor_update_statut':
        $doctorController->updateStatutAction();
        break;

    case 'finaliser_consultation':
        $doctorController->finaliserConsultationAction();
        break;

    // ----- AUTHENTIFICATION (L-FIX HNA) -----
    case 'login':
        // Hada hwa li ghadi i-akhod l-POST wlla i-affichi l-view 3la 7sab chno jây
        $authController->loginAction();
        break;

    case 'logout':
        $authController->logoutAction();
        break;

    case 'admin_dashboard':
        include __DIR__ . '/../templates/admin/dashboard.php';
        break;

    // ----- DEFAULT DE SÉCURITÉ -----
    default:
        $patientController->index();
        break;
}