<?php

namespace App\Repository;

use PDO;

class DoctorRepository {

    public function __construct(private PDO $pdo) {}

    /**
     * Récupérer tous les rendez-vous d'un médecin spécifique
     */
    public function getDoctorRendezVous(int $idMedecin): array {
        $sql = "SELECT r.id as id_rdv, r.statut, c.heure_debut, u.nom as patient_nom, u.prenom as patient_prenom, u.email as patient_email
                FROM rendez_vous r
                JOIN creneaux c ON r.id_creneau = c.id
                JOIN users u ON r.id_patient = u.id
                WHERE r.id_medecin = :id_medecin
                ORDER BY c.heure_debut ASC";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id_medecin' => $idMedecin]);
        return $stmt->fetchAll();
    }

    /**
     * Mettre à jour le statut d'un rendez-vous (Confirmer / Annuler)
     */
    public function updateRendezVousStatut(int $idRdv, string $statut): bool {
        $sql = "UPDATE rendez_vous SET statut = :statut WHERE id = :id_rdv";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute(['statut' => $statut, 'id_rdv' => $idRdv]);
    }

    /**
     * Créer une consultation et l'ordonnance associée (Clôture)
     */
    public function clôturerConsultation(int $idRdv, string $ordonnanceContenu): bool {
        try {
            $this->pdo->beginTransaction();

            // 1. Insérer l'ordonnance directement liée au Rendez-vous
            $sqlOrdo = "INSERT INTO ordonnances (id_rendez_vous, description) VALUES (:id_rdv, :description)";
            $stmtOrdo = $this->pdo->prepare($sqlOrdo);
            $stmtOrdo->execute([
                'id_rdv' => $idRdv,
                'description' => $ordonnanceContenu
            ]);

            // 2. Passer le rendez-vous à 'Terminé'
            $sqlUpdate = "UPDATE rendez_vous SET statut = 'Terminé' WHERE id = :id_rdv";
            $stmtUpdate = $this->pdo->prepare($sqlUpdate);
            $stmtUpdate->execute(['id_rdv' => $idRdv]);

            $this->pdo->commit();
            return true;
        } catch (\Exception $e) {
            $this->pdo->rollBack();
            return false;
        }
    }
}