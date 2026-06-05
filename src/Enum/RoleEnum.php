<?php

namespace App\Enum;

/**
 * Enum pour les rôles des utilisateurs
 * Correspond à la colonne 'role' de la table 'users'
 */
class RoleEnum
{
    const ADMIN = 'admin';
    const MEDECIN = 'medecin';
    const PATIENT = 'patient';
}
