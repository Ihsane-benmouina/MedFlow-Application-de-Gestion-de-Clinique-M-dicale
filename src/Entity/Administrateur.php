<?php

namespace App\Entity;

/**
 * Classe Administrateur - hérite de Utilisateur
 * Gère les médecins de la clinique
 */
class Administrateur extends Utilisateur
{
    /**
     * Constructeur - appelle le constructeur parent
     */
    public function __construct(
        ?int $id = null,
        string $nom = '',
        string $prenom = '',
        string $email = '',
        string $password = ''
    ) {
        parent::__construct($id, $nom, $prenom, $email, $password, 'admin');
    }

    /**
     * Créer un nouveau médecin (logique dans le Controller/Repository)
     */
    public function creerMedecin(): void
    {
        // La logique est dans AdminController et MedecinRepository
    }

    /**
     * Modifier un médecin existant
     */
    public function modifierMedecin(): void
    {
        // La logique est dans AdminController et MedecinRepository
    }

    /**
     * Désactiver un médecin
     */
    public function desactiverMedecin(): void
    {
        // La logique est dans AdminController et MedecinRepository
    }
}
