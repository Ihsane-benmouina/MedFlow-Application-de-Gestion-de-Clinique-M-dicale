<?php

namespace App\Repository;

use PDO;

class DoctorRepository extends BaseRepository {

    public function getDoctorRendezVous(int $idMedecin): array {
        $sql = "SELECT r.id as id_rdv, r.statut, c.heure_debut, u.nom as patient_nom, u.prenom as patient_prenom, u.email as patient_email
                FROM rendez_vous r
                JOIN creneaux c ON r.id_creneau = c.id
                JOIN users u ON r.id_patient = u.id
                WHERE r.id_medecin = :id_medecin
                ORDER BY c.heure_debut ASC";

        return $this->fetchAll($sql, ['id_medecin' => $idMedecin]);
    }

    public function updateRendezVousStatut(int $idRdv, string $statut): bool {
        $sql = "UPDATE rendez_vous SET statut = :statut WHERE id = :id_rdv";
        return $this->execute($sql, ['statut' => $statut, 'id_rdv' => $idRdv]);
    }

    public function clôturerConsultation(int $idRdv, string $ordonnanceContenu): bool {
        return $this->transaction(function (PDO $pdo) use ($idRdv, $ordonnanceContenu) {
            $sqlOrdo = "INSERT INTO ordonnances (id_rendez_vous, description) VALUES (:id_rdv, :description)";
            $stmtOrdo = $pdo->prepare($sqlOrdo);
            $stmtOrdo->execute([
                'id_rdv' => $idRdv,
                'description' => $ordonnanceContenu
            ]);

            $sqlUpdate = "UPDATE rendez_vous SET statut = 'Terminé' WHERE id = :id_rdv";
            $stmtUpdate = $pdo->prepare($sqlUpdate);
            $stmtUpdate->execute(['id_rdv' => $idRdv]);
        });
    }
}
