<?php

namespace App\Entity;

/**
 * Classe Creneau
 * Correspond à la table 'creneaux' dans la base de données
 * Représente un créneau horaire d'un médecin
 */
class Creneau
{
    // Propriétés
    private ?int $id;
    private string $heureDebut;
    private string $heureFin;
    private bool $disponible;
    private ?int $idMedecin;

    /**
     * Constructeur
     */
    public function __construct(
        ?int $id = null,
        string $heureDebut = '',
        string $heureFin = '',
        bool $disponible = true,
        ?int $idMedecin = null
    ) {
        $this->id = $id;
        $this->heureDebut = $heureDebut;
        $this->heureFin = $heureFin;
        $this->disponible = $disponible;
        $this->idMedecin = $idMedecin;
    }

    // --- Getters ---

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getHeureDebut(): string
    {
        return $this->heureDebut;
    }

    public function getHeureFin(): string
    {
        return $this->heureFin;
    }

    public function isDisponible(): bool
    {
        return $this->disponible;
    }

    public function getIdMedecin(): ?int
    {
        return $this->idMedecin;
    }

    // --- Setters ---

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function setHeureDebut(string $heureDebut): void
    {
        $this->heureDebut = $heureDebut;
    }

    public function setHeureFin(string $heureFin): void
    {
        $this->heureFin = $heureFin;
    }

    public function setDisponible(bool $disponible): void
    {
        $this->disponible = $disponible;
    }

    public function setIdMedecin(int $idMedecin): void
    {
        $this->idMedecin = $idMedecin;
    }

    // --- Méthodes métier ---

    /**
     * Marquer ce créneau comme indisponible
     */
    public function marquerIndisponible(): void
    {
        $this->disponible = false;
    }
}
