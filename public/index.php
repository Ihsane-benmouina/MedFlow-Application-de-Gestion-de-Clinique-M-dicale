<?php
ob_start();

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}



$pdo = require_once __DIR__ . '/../config/database.php';

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

    case 'doctor_dashboard':
        $doctorController->dashboard();
        break;

    case 'doctor_update_statut':
        $doctorController->updateStatutAction();
        break;

    case 'finaliser_consultation':
        $doctorController->finaliserConsultationAction();
        break;

    case 'login':
        $authController->loginAction();
        break;

    case 'logout':
        $authController->logoutAction();
        break;

    case 'admin_dashboard':
        include __DIR__ . '/../templates/admin/dashboard.php';
        break;

    default:
        $patientController->index();
        break;
}