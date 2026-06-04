<?php

namespace App\Controller;

require_once __DIR__ . '/../Repository/DoctorRepository.php';

use App\Repository\DoctorRepository;
use PDO;

class DoctorController {
    private DoctorRepository $doctorRepository;

    public function __construct(PDO $pdo) {
        $this->doctorRepository = new DoctorRepository($pdo);
    }

    /**
     * Render du Dashboard Médecin
     */
    public function dashboard(): void {
        if (session_status() === PHP_SESSION_NONE) { session_start(); }

        // Sécurité Médecin
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'medecin') {
            header('Location: index.php?action=login');
            exit();
        }

        // Récupérer l'id_medecin stocké en session lors du login
        $idMedecin = $_SESSION['user']['id_medecin'] ?? 0;

        // Récupérer les rendez-vous via le Repository
        $appointments = $this->doctorRepository->getDoctorRendezVous($idMedecin);

        include __DIR__ . '/../../templates/doctor/dashboard.php';
    }

    /**
     * Action de modification de statut (Confirmer/Annuler) via POST
     */
    public function updateStatutAction(): void {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $idRdv = (int)($_POST['id_rdv'] ?? 0);
            $actionStatut = $_POST['statut_action'] ?? '';

            if ($idRdv > 0 && in_array($actionStatut, ['Confirmé', 'Annulé'])) {
                $this->doctorRepository->updateRendezVousStatut($idRdv, $actionStatut);
            }
        }
        header('Location: index.php?action=doctor_dashboard');
        exit();
    }

    /**
     * Action pour clôturer et ajouter l'ordonnance
     */
    public function finaliserConsultationAction(): void {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $idRdv = (int)($_POST['id_rdv'] ?? 0);
            $diagnostic = trim($_POST['diagnostic'] ?? '');
            $ordonnance = trim($_POST['ordonnance'] ?? '');

            if ($idRdv > 0) {
                $content = trim($diagnostic . "\n" . $ordonnance);
                $this->doctorRepository->clôturerConsultation($idRdv, $content);
            }
        }
        header('Location: index.php?action=doctor_dashboard');
        exit();
    }
}