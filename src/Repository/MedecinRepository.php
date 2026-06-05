<?php

namespace App\Repository;

use PDO;

/**
 * Repository pour la table 'medecins'
 * Toutes les requêtes SQL liées aux médecins sont ici
 */
class MedecinRepository
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * Récupérer tous les médecins avec leurs informations utilisateur et spécialité
     */
    public function findAll(): array
    {
        $sql = "SELECT m.id as id_medecin, m.actif, m.id_specialite,
                       u.id as id_user, u.nom, u.prenom, u.email,
                       s.nom as specialite_nom
                FROM medecins m
                JOIN users u ON m.id_user = u.id
                JOIN specialites s ON m.id_specialite = s.id
                ORDER BY u.nom ASC";
        return $this->pdo->query($sql)->fetchAll();
    }

    /**
     * Trouver un médecin par son ID (table medecins)
     */
    public function findById(int $idMedecin): ?array
    {
        $sql = "SELECT m.id as id_medecin, m.actif, m.id_specialite,
                       u.id as id_user, u.nom, u.prenom, u.email,
                       s.nom as specialite_nom
                FROM medecins m
                JOIN users u ON m.id_user = u.id
                JOIN specialites s ON m.id_specialite = s.id
                WHERE m.id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $idMedecin]);
        $result = $stmt->fetch();
        return $result ?: null;
    }

    /**
     * Trouver un médecin par son id_user
     */
    public function findByUserId(int $idUser): ?array
    {
        $sql = "SELECT m.id as id_medecin, m.actif, m.id_specialite,
                       u.id as id_user, u.nom, u.prenom, u.email,
                       s.nom as specialite_nom
                FROM medecins m
                JOIN users u ON m.id_user = u.id
                JOIN specialites s ON m.id_specialite = s.id
                WHERE m.id_user = :id_user";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id_user' => $idUser]);
        $result = $stmt->fetch();
        return $result ?: null;
    }

    /**
     * Créer un médecin (après avoir créé l'utilisateur)
     */
    public function create(int $idUser, int $idSpecialite): int
    {
        $sql = "INSERT INTO medecins (id_user, id_specialite, actif) 
                VALUES (:id_user, :id_specialite, TRUE)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'id_user' => $idUser,
            'id_specialite' => $idSpecialite,
        ]);
        return (int) $this->pdo->lastInsertId();
    }

    /**
     * Modifier la spécialité d'un médecin
     */
    public function updateSpecialite(int $idMedecin, int $idSpecialite): bool
    {
        $sql = "UPDATE medecins SET id_specialite = :id_specialite WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            'id_specialite' => $idSpecialite,
            'id' => $idMedecin,
        ]);
    }

    /**
     * Activer ou désactiver un médecin
     */
    public function toggleActif(int $idMedecin, bool $actif): bool
    {
        $sql = "UPDATE medecins SET actif = :actif WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            'actif' => $actif ? 1 : 0,
            'id' => $idMedecin,
        ]);
    }

    /**
     * Récupérer les médecins actifs avec leurs créneaux disponibles
     */
    public function findActifsAvecCreneaux(): array
    {
        // Récupérer les médecins actifs
        $sql = "SELECT m.id as id_medecin, m.id_specialite,
                       u.nom, u.prenom,
                       s.nom as specialite_nom
                FROM medecins m
                JOIN users u ON m.id_user = u.id
                JOIN specialites s ON m.id_specialite = s.id
                WHERE m.actif = TRUE
                ORDER BY u.nom ASC";
        $medecins = $this->pdo->query($sql)->fetchAll();

        // Pour chaque médecin, récupérer ses créneaux disponibles
        foreach ($medecins as &$medecin) {
            $sqlCreneaux = "SELECT c.id, c.heure_debut, c.heure_fin
                            FROM creneaux c
                            WHERE c.id_medecin = :id_medecin
                            AND c.disponible = TRUE
                            AND c.heure_debut >= NOW()
                            ORDER BY c.heure_debut ASC";
            $stmt = $this->pdo->prepare($sqlCreneaux);
            $stmt->execute(['id_medecin' => $medecin['id_medecin']]);
            $medecin['creneaux'] = $stmt->fetchAll();
        }

        return $medecins;
    }

    /**
     * Compter le nombre total de médecins actifs
     */
    public function countActifs(): int
    {
        $sql = "SELECT COUNT(*) as total FROM medecins WHERE actif = TRUE";
        return (int) $this->pdo->query($sql)->fetch()['total'];
    }
}
