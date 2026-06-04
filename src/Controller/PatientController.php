<?php

namespace App\Controller;

use App\Repository\PatientRepository;
use PDO;

class PatientController {
    private PatientRepository $patientRepository;

    public function __construct(PDO $pdo) {
        $this->patientRepository = new PatientRepository($pdo);
    }

    /**
     * Render du Dashboard Patient complet
     */
    public function dashboard(): void {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Sécurité d'accès
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'patient') {
            header('Location: index.php?action=login');
            exit();
        }

        $idPatient = $_SESSION['user']['id'];

        // Extraction de toutes les données nécessaires via Repository
        $specialites = $this->patientRepository->getAllSpecialites();
        $medecinsList = $this->patientRepository->getMedecinsWithCreneaux();
        $myAppointments = $this->patientRepository->getPatientRendezVous($idPatient);
        $myOrdonnances = $this->patientRepository->getPatientOrdonnances($idPatient);

        // Inclure la vue en lui passant automatiquement ces variables
        include __DIR__ . '/../../templates/patient/dashboard.php';
    }
}