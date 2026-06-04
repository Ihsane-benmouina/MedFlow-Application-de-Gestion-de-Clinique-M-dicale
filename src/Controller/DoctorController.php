<?php

namespace App\Controller;

use App\Repository\RendezVousRepository;
use App\Repository\OrdonnanceRepository;
use App\Repository\CreneauRepository;
use App\Middleware\AuthMiddleware;
use PDO;

/**
 * Contrôleur Médecin
 * Gère le planning, la validation des RDV et les consultations
 */
class DoctorController
{
    private RendezVousRepository $rendezVousRepository;
    private OrdonnanceRepository $ordonnanceRepository;
    private CreneauRepository $creneauRepository;

    public function __construct(PDO $pdo)
    {
        $this->rendezVousRepository = new RendezVousRepository($pdo);
        $this->ordonnanceRepository = new OrdonnanceRepository($pdo);
        $this->creneauRepository = new CreneauRepository($pdo);
    }

    /**
     * Afficher le tableau de bord du médecin
     */
    public function dashboard(): void
    {
        // Vérifier que l'utilisateur est un médecin
        AuthMiddleware::requireRole('medecin');

        $idMedecin = $_SESSION['user']['id_medecin'] ?? 0;

        // Récupérer les rendez-vous du médecin
        $appointments = $this->rendezVousRepository->findByMedecin($idMedecin);

        // Récupérer les créneaux du médecin
        $creneaux = $this->creneauRepository->findByMedecin($idMedecin);

        // Afficher la vue
        include __DIR__ . '/../../templates/doctor/dashboard.php';
    }

    /**
     * Confirmer ou annuler un rendez-vous
     */
    public function updateStatutAction(): void
    {
        AuthMiddleware::requireRole('medecin');

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $idRdv = (int) ($_POST['id_rdv'] ?? 0);
            $statut = $_POST['statut_action'] ?? '';

            // Vérifier que le statut est valide
            if ($idRdv > 0 && in_array($statut, ['Confirmé', 'Annulé'])) {
                $this->rendezVousRepository->updateStatut($idRdv, $statut);

                // Si annulé, rendre le créneau disponible
                if ($statut === 'Annulé') {
                    $rdv = $this->rendezVousRepository->findById($idRdv);
                    if ($rdv) {
                        $this->creneauRepository->marquerDisponible($rdv['id_creneau']);
                    }
                }
            }
        }

        header('Location: index.php?action=doctor_dashboard');
        exit();
    }

    /**
     * Terminer une consultation et créer l'ordonnance
     */
    public function terminerConsultation(): void
    {
        AuthMiddleware::requireRole('medecin');

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $idRdv = (int) ($_POST['id_rdv'] ?? 0);
            $ordonnanceContenu = trim($_POST['ordonnance'] ?? '');

            if ($idRdv > 0 && !empty($ordonnanceContenu)) {
                // Créer l'ordonnance
                $this->ordonnanceRepository->create($idRdv, $ordonnanceContenu);

                // Mettre le rendez-vous en "Terminé"
                $this->rendezVousRepository->updateStatut($idRdv, 'Terminé');

                $_SESSION['success_msg'] = "Consultation terminée et ordonnance créée.";
            }
        }

        header('Location: index.php?action=doctor_dashboard');
        exit();
    }

    /**
     * Ajouter un créneau
     */
    public function ajouterCreneau(): void
    {
        AuthMiddleware::requireRole('medecin');

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $idMedecin = $_SESSION['user']['id_medecin'] ?? 0;
            $heureDebut = $_POST['heure_debut'] ?? '';
            $heureFin = $_POST['heure_fin'] ?? '';

            if ($idMedecin > 0 && !empty($heureDebut) && !empty($heureFin)) {
                $this->creneauRepository->create($heureDebut, $heureFin, $idMedecin);
                $_SESSION['success_msg'] = "Créneau ajouté avec succès.";
            }
        }

        header('Location: index.php?action=doctor_dashboard');
        exit();
    }
}
