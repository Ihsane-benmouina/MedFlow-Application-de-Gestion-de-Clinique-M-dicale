<?php
ob_start();

// Load shared helpers and base classes
require_once __DIR__ . '/../src/Helpers/SessionHelper.php';
require_once __DIR__ . '/../src/Helpers/ViewHelper.php';
require_once __DIR__ . '/../src/Repository/BaseRepository.php';

use App\Helpers\SessionHelper;

SessionHelper::ensureStarted();

// 1. Récupérer l'objet PDO de la base de données
$pdo = require_once __DIR__ . '/../config/database.php';

// 2. Inclure les Controllers et Repositories
require_once __DIR__ . '/../src/Repository/DoctorRepository.php';
require_once __DIR__ . '/../src/Repository/PatientRepository.php';
require_once __DIR__ . '/../src/Controller/DoctorController.php';
require_once __DIR__ . '/../src/Controller/PatientController.php';
require_once __DIR__ . '/../src/Controller/AuthController.php';

use App\Controller\AuthController;
use App\Controller\DoctorController;
use App\Controller\PatientController;

// 3. Instancier les Controllers
$authController = new AuthController($pdo);
$doctorController = new DoctorController($pdo);
$patientController = new PatientController($pdo);

// 4. Déterminer l'action demandée
$action = $_GET['action'] ?? 'home';

// 5. Routing
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

    // ----- AUTHENTIFICATION -----
    case 'login':
        $authController->loginAction();
        break;

    case 'logout':
        $authController->logoutAction();
        break;

    case 'admin_dashboard':
        include __DIR__ . '/../templates/admin/dashboard.php';
        break;

    // ----- DEFAULT -----
    default:
        $patientController->index();
        break;
}
