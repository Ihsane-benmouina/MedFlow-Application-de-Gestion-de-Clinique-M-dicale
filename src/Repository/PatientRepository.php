<?php

namespace App\Repository;

use PDO;

class PatientRepository {

    public function __construct(private PDO $pdo) {}

    /**
     * Récupérer toutes les spécialités pour les boutons
     */
    public function getAllSpecialites(): array {
        $sql = "SELECT * FROM specialites ORDER BY nom ASC";
        return $this->pdo->query($sql)->fetchAll();
    }

    /**
     * Récupérer les médecins avec leurs créneaux disponibles
     */
    public function getMedecinsWithCreneaux(): array {
        // 1. Jbed les médecins
        $sql = "SELECT m.id as id_medecin, m.id_specialite, u.nom, u.prenom, s.nom as specialite_nom 
                FROM medecins m
                JOIN users u ON m.id_user = u.id
                JOIN specialites s ON m.id_specialite = s.id";
        $medecins = $this->pdo->query($sql)->fetchAll();

        // 2. Lsa9 m3ahom les créneaux libres (statut = 'disponible' ou non réservés)
        foreach ($medecins as &$medecin) {
            $sqlCreneaux = "SELECT id, heure_debut 
                            FROM creneaux 
                            WHERE id_medecin = :id_medecin 
                            AND heure_debut >= NOW() 
                            ORDER BY heure_debut ASC";
            $stmt = $this->pdo->prepare($sqlCreneaux);
            $stmt->execute(['id_medecin' => $medecin['id_medecin']]);
            $medecin['creneaux'] = $stmt->fetchAll();
        }

        return $medecins;
    }

    /**
     * Récupérer l'historique des rendez-vous d'un patient
     */
    public function getPatientRendezVous(int $idPatient): array {
        $sql = "SELECT r.id as id_rdv, r.statut, c.heure_debut, u.nom as medecin_nom, u.prenom as medecin_prenom
                FROM rendez_vous r
                JOIN creneaux c ON r.id_creneau = c.id
                JOIN medecins m ON r.id_medecin = m.id
                JOIN users u ON m.id_user = u.id
                WHERE r.id_patient = :id_patient
                ORDER BY c.heure_debut DESC";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id_patient' => $idPatient]);
        return $stmt->fetchAll();
    }

    /**
     * Récupérer les ordonnances du patient
     */
    public function getPatientOrdonnances(int $idPatient): array {
        $sql = "SELECT o.id, o.contenu, o.date_creation, u.nom as medecin_nom, u.prenom as medecin_prenom
                FROM ordonnances o
                JOIN consultations c ON o.id_consultation = c.id
                JOIN rendez_vous r ON c.id_rendez_vous = r.id
                JOIN medecins m ON r.id_medecin = m.id
                JOIN users u ON m.id_user = u.id
                WHERE r.id_patient = :id_patient
                ORDER BY o.date_creation DESC";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id_patient' => $idPatient]);
        return $stmt->fetchAll();
    }
}