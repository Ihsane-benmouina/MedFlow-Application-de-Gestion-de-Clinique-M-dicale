<?php

namespace App\Repository;

use PDO;

class PatientRepository extends BaseRepository {

    public function getAllSpecialites(): array {
        $sql = "SELECT * FROM specialites ORDER BY nom ASC";
        return $this->fetchAll($sql);
    }

    public function getMedecinsWithCreneaux(): array {
        $sql = "SELECT m.id as id_medecin, m.id_specialite, u.nom, u.prenom, s.nom as specialite_nom 
                FROM medecins m
                JOIN users u ON m.id_user = u.id
                JOIN specialites s ON m.id_specialite = s.id";
        $medecins = $this->fetchAll($sql);

        foreach ($medecins as &$medecin) {
            $sqlCreneaux = "SELECT id, heure_debut 
                            FROM creneaux 
                            WHERE id_medecin = :id_medecin 
                            AND heure_debut >= NOW() 
                            ORDER BY heure_debut ASC";
            $medecin['creneaux'] = $this->fetchAll($sqlCreneaux, ['id_medecin' => $medecin['id_medecin']]);
        }

        return $medecins;
    }

    public function getPatientRendezVous(int $idPatient): array {
        $sql = "SELECT r.id as id_rdv, r.statut, c.heure_debut, u.nom as medecin_nom, u.prenom as medecin_prenom
                FROM rendez_vous r
                JOIN creneaux c ON r.id_creneau = c.id
                JOIN medecins m ON r.id_medecin = m.id
                JOIN users u ON m.id_user = u.id
                WHERE r.id_patient = :id_patient
                ORDER BY c.heure_debut DESC";

        return $this->fetchAll($sql, ['id_patient' => $idPatient]);
    }

    public function getPatientOrdonnances(int $idPatient): array {
        $sql = "SELECT o.id, o.contenu, o.date_creation, u.nom as medecin_nom, u.prenom as medecin_prenom
                FROM ordonnances o
                JOIN consultations c ON o.id_consultation = c.id
                JOIN rendez_vous r ON c.id_rendez_vous = r.id
                JOIN medecins m ON r.id_medecin = m.id
                JOIN users u ON m.id_user = u.id
                WHERE r.id_patient = :id_patient
                ORDER BY o.date_creation DESC";

        return $this->fetchAll($sql, ['id_patient' => $idPatient]);
    }
}
