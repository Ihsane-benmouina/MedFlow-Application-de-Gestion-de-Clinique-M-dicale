<?php

namespace App\Repository;

use PDO;

/**
 * Repository pour la table 'specialites'
 * Toutes les requêtes SQL liées aux spécialités sont ici
 */
class SpecialiteRepository
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * Récupérer toutes les spécialités
     */
    public function findAll(): array
    {
        $sql = "SELECT * FROM specialites ORDER BY nom ASC";
        return $this->pdo->query($sql)->fetchAll();
    }

    /**
     * Trouver une spécialité par son ID
     */
    public function findById(int $id): ?array
    {
        $sql = "SELECT * FROM specialites WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
        $result = $stmt->fetch();
        return $result ?: null;
    }

    /**
     * Créer une nouvelle spécialité
     */
    public function create(string $nom, string $description): int
    {
        $sql = "INSERT INTO specialites (nom, description) VALUES (:nom, :description)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'nom' => $nom,
            'description' => $description,
        ]);
        return (int) $this->pdo->lastInsertId();
    }

    /**
     * Compter les médecins par spécialité
     */
    public function countMedecinsParSpecialite(): array
    {
        $sql = "SELECT s.id, s.nom, COUNT(m.id) as total_medecins
                FROM specialites s
                LEFT JOIN medecins m ON s.id = m.id_specialite AND m.actif = TRUE
                GROUP BY s.id, s.nom
                ORDER BY s.nom ASC";
        return $this->pdo->query($sql)->fetchAll();
    }
}
