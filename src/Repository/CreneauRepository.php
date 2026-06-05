<?php

namespace App\Repository;

use PDO;

/**
 * Repository pour la table 'creneaux'
 * Toutes les requêtes SQL liées aux créneaux sont ici
 */
class CreneauRepository
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * Récupérer les créneaux d'un médecin
     */
    public function findByMedecin(int $idMedecin): array
    {
        $sql = "SELECT * FROM creneaux 
                WHERE id_medecin = :id_medecin 
                ORDER BY heure_debut ASC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id_medecin' => $idMedecin]);
        return $stmt->fetchAll();
    }

    /**
     * Récupérer les créneaux disponibles d'un médecin (futurs uniquement)
     */
    public function findDisponiblesByMedecin(int $idMedecin): array
    {
        $sql = "SELECT * FROM creneaux 
                WHERE id_medecin = :id_medecin 
                AND disponible = TRUE
                AND heure_debut >= NOW()
                ORDER BY heure_debut ASC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id_medecin' => $idMedecin]);
        return $stmt->fetchAll();
    }

    /**
     * Trouver un créneau par son ID
     */
    public function findById(int $id): ?array
    {
        $sql = "SELECT * FROM creneaux WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
        $result = $stmt->fetch();
        return $result ?: null;
    }

    /**
     * Créer un nouveau créneau
     */
    public function create(string $heureDebut, string $heureFin, int $idMedecin): int
    {
        $sql = "INSERT INTO creneaux (heure_debut, heure_fin, disponible, id_medecin) 
                VALUES (:heure_debut, :heure_fin, TRUE, :id_medecin)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'heure_debut' => $heureDebut,
            'heure_fin' => $heureFin,
            'id_medecin' => $idMedecin,
        ]);
        return (int) $this->pdo->lastInsertId();
    }

    /**
     * Marquer un créneau comme indisponible
     */
    public function marquerIndisponible(int $id): bool
    {
        $sql = "UPDATE creneaux SET disponible = FALSE WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }

    /**
     * Marquer un créneau comme disponible
     */
    public function marquerDisponible(int $id): bool
    {
        $sql = "UPDATE creneaux SET disponible = TRUE WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }
}
