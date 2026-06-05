<?php

namespace App\Entity;

/**
 * Classe RendezVous
 * Correspond à la table 'rendez_vous' dans la base de données
 */
class RendezVous
{
    // Propriétés
    private ?int $id;
    private ?int $idPatient;
    private ?int $idMedecin;
    private ?int $idCreneau;
    private string $statut;
    private string $dateCreation;

    /**
     * Constructeur
     */
    public function __construct(
        ?int $id = null,
        ?int $idPatient = null,
        ?int $idMedecin = null,
        ?int $idCreneau = null,
        string $statut = 'En attente',
        string $dateCreation = ''
    ) {
        $this->id = $id;
        $this->idPatient = $idPatient;
        $this->idMedecin = $idMedecin;
        $this->idCreneau = $idCreneau;
        $this->statut = $statut;
        $this->dateCreation = $dateCreation;
    }

    // --- Getters ---

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdPatient(): ?int
    {
        return $this->idPatient;
    }

    public function getIdMedecin(): ?int
    {
        return $this->idMedecin;
    }

    public function getIdCreneau(): ?int
    {
        return $this->idCreneau;
    }

    public function getStatut(): string
    {
        return $this->statut;
    }

    public function getDateCreation(): string
    {
        return $this->dateCreation;
    }

    // --- Setters ---

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function setIdPatient(int $idPatient): void
    {
        $this->idPatient = $idPatient;
    }

    public function setIdMedecin(int $idMedecin): void
    {
        $this->idMedecin = $idMedecin;
    }

    public function setIdCreneau(int $idCreneau): void
    {
        $this->idCreneau = $idCreneau;
    }

    public function setStatut(string $statut): void
    {
        $this->statut = $statut;
    }

    // --- Méthodes métier ---

    /**
     * Confirmer le rendez-vous
     */
    public function confirmer(): void
    {
        $this->statut = 'Confirmé';
    }

    /**
     * Annuler le rendez-vous
     */
    public function annuler(): void
    {
        $this->statut = 'Annulé';
    }

    /**
     * Terminer le rendez-vous
     */
    public function terminer(): void
    {
        $this->statut = 'Terminé';
    }

    /**
     * Vérifier la disponibilité du créneau
     */
    public function verifierDisponibilite(): bool
    {
        // La vérification réelle se fait dans le Repository
        return true;
    }
}
