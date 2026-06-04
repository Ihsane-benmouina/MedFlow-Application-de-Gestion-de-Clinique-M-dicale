<?php
// Simulation simple de routage pour la démo d'UI (En attendant la logique métier)
$action = $_GET['action'] ?? 'home';

switch ($action) {
    case 'login':
        include __DIR__ . '/../templates/auth/login_register.php';
        break;

    case 'patient-dashboard':
        include __DIR__ . '/../templates/patient/dashboard.php';
        break;
    case 'doctor-dashboard':
        include __DIR__ . '/../templates/doctor/dashboard.php';
        break;
    case 'admin-dashboard':
        include __DIR__ . '/../templates/admin/dashboard.php';
        break;
    case 'home':
    default:
        include __DIR__ . '/../templates/patient/recherche.php';
        break;
}

