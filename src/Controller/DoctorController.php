<?php

namespace App\Controller;

use App\Helpers\SessionHelper;
use App\Repository\DoctorRepository;
use PDO;

class DoctorController {
    private DoctorRepository $doctorRepository;

    public function __construct(PDO $pdo) {
        $this->doctorRepository = new DoctorRepository($pdo);
    }

    public function dashboard(): void {
        SessionHelper::requireRole('medecin');

        $idMedecin = $_SESSION['user']['id_medecin'] ?? 0;
        $appointments = $this->doctorRepository->getDoctorRendezVous($idMedecin);

        include __DIR__ . '/../../templates/doctor/dashboard.php';
    }

    public function updateStatutAction(): void {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $idRdv = (int)($_POST['id_rdv'] ?? 0);
            $actionStatut = $_POST['statut_action'] ?? '';

            if ($idRdv > 0 && in_array($actionStatut, ['Confirmé', 'Annulé'])) {
                $this->doctorRepository->updateRendezVousStatut($idRdv, $actionStatut);
            }
        }
        SessionHelper::redirect('doctor_dashboard');
    }

    public function finaliserConsultationAction(): void {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $idRdv = (int)($_POST['id_rdv'] ?? 0);
            $diagnostic = trim($_POST['diagnostic'] ?? '');
            $ordonnance = trim($_POST['ordonnance'] ?? '');

            if ($idRdv > 0) {
                $this->doctorRepository->clôturerConsultation($idRdv, $ordonnance);
            }
        }
        SessionHelper::redirect('doctor_dashboard');
    }
}
