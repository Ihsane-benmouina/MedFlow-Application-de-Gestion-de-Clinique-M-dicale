<?php

namespace App\Entity;

/**
 * Classe Medecin - hérite de Utilisateur
 * Représente un médecin avec sa spécialité et ses créneaux
 */
class Medecin extends Utilisateur
{
    // Propriétés spécifiques au médecin
    private ?int $idMedecin;
    private string $matricule;
    private string $telephone;
    private bool $actif;
    private ?int $idSpecialite;

    /**
     * Constructeur
     */
    public function __construct(
        ?int $id = null,
        string $nom = '',
        string $prenom = '',
        string $email = '',
        string $password = '',
        ?int $idMedecin = null,
        string $matricule = '',
        string $telephone = '',
        bool $actif = true,
        ?int $idSpecialite = null
    ) {
        parent::__construct($id, $nom, $prenom, $email, $password, 'medecin');
        $this->idMedecin = $idMedecin;
        $this->matricule = $matricule;
        $this->telephone = $telephone;
        $this->actif = $actif;
        $this->idSpecialite = $idSpecialite;
    }

    // --- Getters et Setters spécifiques ---

    public function getIdMedecin(): ?int
    {
        return $this->idMedecin;
    }

    public function setIdMedecin(int $idMedecin): void
    {
        $this->idMedecin = $idMedecin;
    }

    public function getMatricule(): string
    {
        return $this->matricule;
    }

    public function setMatricule(string $matricule): void
    {
        $this->matricule = $matricule;
    }

    public function getTelephone(): string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): void
    {
        $this->telephone = $telephone;
    }

    public function isActif(): bool
    {
        return $this->actif;
    }

    public function setActif(bool $actif): void
    {
        $this->actif = $actif;
    }

    public function getIdSpecialite(): ?int
    {
        return $this->idSpecialite;
    }

    public function setIdSpecialite(int $idSpecialite): void
    {
        $this->idSpecialite = $idSpecialite;
    }

    // --- Méthodes métier ---

    /**
     * Visualiser le planning du médecin
     */
    public function visualiserPlanning(): void
    {
        // La logique est dans DoctorController et Repository
    }

    /**
     * Valider (confirmer) un rendez-vous
     */
    public function validerRendezVous(): void
    {
        // La logique est dans DoctorController et Repository
    }

    /**
     * Annuler un rendez-vous
     */
    public function annulerRendezVous(): void
    {
        // La logique est dans DoctorController et Repository
    }

    /**
     * Terminer une consultation
     */
    public function terminerConsultation(): void
    {
        // La logique est dans DoctorController et Repository
    }
}
