<?php

namespace App\Enum;

/**
 * Enum pour les statuts des rendez-vous
 * Correspond à la colonne 'statut' de la table 'rendez_vous'
 */
class StatutRendezVousEnum
{
    const EN_ATTENTE = 'En attente';
    const CONFIRME = 'Confirmé';
    const ANNULE = 'Annulé';
    const TERMINE = 'Terminé';
}
