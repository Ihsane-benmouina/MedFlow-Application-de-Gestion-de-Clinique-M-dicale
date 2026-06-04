<?php

namespace App\Controller;

use App\Repository\PatientRepository;
use PDO;

class PatientController
{
    private PatientRepository $patientRepository;

    public function __construct(PDO $pdo)
    {
        $this->patientRepository = new PatientRepository($pdo);
    }

    public function dashboard()
    {
        $specialites = $this->patientRepository->getAllSpecialites();

        $medecinsList = $this->patientRepository->getDoctorsWithSlots();

        include __DIR__ . '/../../templates/patient/dashboard.php';
    }

    public function index()
    {
        $specialites = $this->patientRepository->getAllSpecialites();

        $searchQuery = trim($_GET['search'] ?? '');
        $selectedSpecialite = $_GET['specialite'] ?? 'all';

        if ($searchQuery !== '') {
            $medecinsList = $this->patientRepository->searchDoctors($searchQuery, $selectedSpecialite);
        } else {
            $medecinsList = $this->patientRepository->getDoctorsWithSlots();
            if ($selectedSpecialite !== 'all') {
                $medecinsList = array_values(array_filter($medecinsList, function ($m) use ($selectedSpecialite) {
                    return (string)($m['id_speciality'] ?? '') === (string)$selectedSpecialite;
                }));
            }
        }

        include __DIR__ . '/../../templates/patient/recherche.php';
    }

    public function reserver()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $idMedecin = (int)($_POST['id_medecin'] ?? 0);
            $idCreneau = (int)($_POST['id_creneau'] ?? 0);

            if ($idMedecin > 0 && $idCreneau > 0) {
                $_SESSION['success_msg'] = 'Réservation enregistrée (simulation).';
            } else {
                $_SESSION['error_msg'] = 'Données de réservation manquantes.';
            }
        }

        header('Location: index.php?action=home');
        exit();
    }
}