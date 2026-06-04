<?php

namespace App\Controller;

use App\Helpers\SessionHelper;
use App\Repository\PatientRepository;
use PDO;

class PatientController {
    private PatientRepository $patientRepository;

    public function __construct(PDO $pdo) {
        $this->patientRepository = new PatientRepository($pdo);
    }

    public function dashboard(): void {
        SessionHelper::requireRole('patient');

        $idPatient = $_SESSION['user']['id'];

        $specialites = $this->patientRepository->getAllSpecialites();
        $medecinsList = $this->patientRepository->getMedecinsWithCreneaux();
        $myAppointments = $this->patientRepository->getPatientRendezVous($idPatient);
        $myOrdonnances = $this->patientRepository->getPatientOrdonnances($idPatient);

        include __DIR__ . '/../../templates/patient/dashboard.php';
    }
}
