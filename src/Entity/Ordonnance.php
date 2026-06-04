<?php

namespace App\Entity;

/**
 * Classe Ordonnance
 * Correspond à la table 'ordonnances' dans la base de données
 * Une ordonnance est liée à un rendez-vous terminé
 */
class Ordonnance
{
    // Propriétés
    private ?int $id;
    private string $contenu;
    private string $dateCreation;
    private ?int $idRendezVous;

    /**
     * Constructeur
     */
    public function __construct(
        ?int $id = null,
        string $contenu = '',
        string $dateCreation = '',
        ?int $idRendezVous = null
    ) {
        $this->id = $id;
        $this->contenu = $contenu;
        $this->dateCreation = $dateCreation;
        $this->idRendezVous = $idRendezVous;
    }

    // --- Getters ---

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContenu(): string
    {
        return $this->contenu;
    }

    public function getDateCreation(): string
    {
        return $this->dateCreation;
    }

    public function getIdRendezVous(): ?int
    {
        return $this->idRendezVous;
    }

    // --- Setters ---

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function setContenu(string $contenu): void
    {
        $this->contenu = $contenu;
    }

    public function setIdRendezVous(int $idRendezVous): void
    {
        $this->idRendezVous = $idRendezVous;
    }

    // --- Méthodes métier ---

    /**
     * Modifier le contenu de l'ordonnance
     */
    public function modifierContenu(string $nouveauContenu): void
    {
        $this->contenu = $nouveauContenu;
    }
}
