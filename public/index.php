<?php
/**
 * Point d'entrée principal de l'application MedFlow
 * Toutes les requêtes passent par ce fichier (routing)
 */

// Démarrer le buffer de sortie
ob_start();

// 1. Charger les fonctions de sécurité (headers + session hardening before session_start)
require_once __DIR__ . '/../config/security.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 2. Charger la connexion à la base de données
$pdo = require_once __DIR__ . '/../config/database.php';

// 3. Charger le Middleware
require_once __DIR__ . '/../src/Middleware/AuthMiddleware.php';

// 4. Charger les Repositories
require_once __DIR__ . '/../src/Repository/UtilisateurRepository.php';
require_once __DIR__ . '/../src/Repository/SpecialiteRepository.php';
require_once __DIR__ . '/../src/Repository/MedecinRepository.php';
require_once __DIR__ . '/../src/Repository/CreneauRepository.php';
require_once __DIR__ . '/../src/Repository/RendezVousRepository.php';
require_once __DIR__ . '/../src/Repository/OrdonnanceRepository.php';

// 5. Charger les Controllers
require_once __DIR__ . '/../src/Controller/AuthController.php';
require_once __DIR__ . '/../src/Controller/AdminController.php';
require_once __DIR__ . '/../src/Controller/DoctorController.php';
require_once __DIR__ . '/../src/Controller/PatientController.php';

// 6. Importer les classes
use App\Controller\AuthController;
use App\Controller\AdminController;
use App\Controller\DoctorController;
use App\Controller\PatientController;

// 7. Instancier les contrôleurs
$authController = new AuthController($pdo);
$adminController = new AdminController($pdo);
$doctorController = new DoctorController($pdo);
$patientController = new PatientController($pdo);

// 8. Déterminer l'action demandée (par défaut : page d'accueil)
$action = $_GET['action'] ?? 'home';

// 9. Routing - diriger vers la bonne action
switch ($action) {

    // ===== PAGE D'ACCUEIL =====
    case 'home':
        $patientController->index();
        break;

    // ===== AUTHENTIFICATION =====
    case 'login':
        $authController->loginAction();
        break;

    case 'register':
        $authController->registerAction();
        break;

    case 'logout':
        $authController->logoutAction();
        break;

    // ===== PATIENT =====
    case 'patient_dashboard':
        $patientController->dashboard();
        break;

    case 'reserver_rdv':
        $patientController->reserver();
        break;

    case 'telecharger_ordonnance':
        $patientController->telechargerOrdonnance();
        break;

    // ===== MÉDECIN =====
    case 'doctor_dashboard':
        $doctorController->dashboard();
        break;

    case 'doctor_update_statut':
        $doctorController->updateStatutAction();
        break;

    case 'terminer_consultation':
        $doctorController->terminerConsultation();
        break;

    case 'ajouter_creneau':
        $doctorController->ajouterCreneau();
        break;

    // ===== ADMIN =====
    case 'admin_dashboard':
        $adminController->dashboard();
        break;

    case 'admin_creer_medecin':
        $adminController->creerMedecin();
        break;

    case 'admin_modifier_medecin':
        $adminController->modifierMedecin();
        break;

    case 'admin_toggle_medecin':
        $adminController->toggleMedecin();
        break;

    // ===== DEFAULT =====
    default:
        $patientController->index();
        break;
}

ob_end_flush();
