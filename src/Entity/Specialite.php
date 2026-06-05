<?php

namespace App\Entity;

/**
 * Classe Specialite
 * Correspond à la table 'specialites' dans la base de données
 */
class Specialite
{
    // Propriétés
    private ?int $id;
    private string $nom;
    private string $description;

    /**
     * Constructeur
     */
    public function __construct(
        ?int $id = null,
        string $nom = '',
        string $description = ''
    ) {
        $this->id = $id;
        $this->nom = $nom;
        $this->description = $description;
    }

    // --- Getters ---

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): string
    {
        return $this->nom;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    // --- Setters ---

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function setNom(string $nom): void
    {
        $this->nom = $nom;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    // --- Méthodes métier ---

    /**
     * Ajouter un médecin à cette spécialité
     */
    public function ajouterMedecin(): void
    {
        // La logique est dans le Repository
    }

    /**
     * Retirer un médecin de cette spécialité
     */
    public function retirerMedecin(): void
    {
        // La logique est dans le Repository
    }
}
