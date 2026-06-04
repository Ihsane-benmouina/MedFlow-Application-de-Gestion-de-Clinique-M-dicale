<?php

namespace App\Entity;

/**
 * Classe Patient - hérite de Utilisateur
 * Représente un patient qui peut prendre des rendez-vous
 */
class Patient extends Utilisateur
{
    // Propriétés spécifiques au patient
    private string $numeroDePatient;
    private string $dateNaissance;

    /**
     * Constructeur
     */
    public function __construct(
        ?int $id = null,
        string $nom = '',
        string $prenom = '',
        string $email = '',
        string $password = '',
        string $numeroDePatient = '',
        string $dateNaissance = ''
    ) {
        parent::__construct($id, $nom, $prenom, $email, $password, 'patient');
        $this->numeroDePatient = $numeroDePatient;
        $this->dateNaissance = $dateNaissance;
    }

    // --- Getters et Setters spécifiques ---

    public function getNumeroDePatient(): string
    {
        return $this->numeroDePatient;
    }

    public function setNumeroDePatient(string $numero): void
    {
        $this->numeroDePatient = $numero;
    }

    public function getDateNaissance(): string
    {
        return $this->dateNaissance;
    }

    public function setDateNaissance(string $date): void
    {
        $this->dateNaissance = $date;
    }

    // --- Méthodes métier ---

    /**
     * Rechercher un médecin
     */
    public function rechercherMedecin(): void
    {
        // La logique est dans PatientController et Repository
    }

    /**
     * Réserver un rendez-vous
     */
    public function reserverRendezVous(): void
    {
        // La logique est dans PatientController et Repository
    }

    /**
     * Consulter le tableau de bord
     */
    public function consulterTableauDeBord(): void
    {
        // La logique est dans PatientController
    }

    /**
     * Télécharger une ordonnance
     */
    public function telechargerOrdonnance(): void
    {
        // La logique est dans PatientController et OrdonnanceRepository
    }
}
