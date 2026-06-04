<?php

namespace App\Repository;

use PDO;

class PatientRepository
{
    public function __construct(private PDO $pdo)
    {
    }

    public function getAllSpecialites(): array
    {
        $sql = "SELECT * FROM specialities ORDER BY name";

        return $this->pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getDoctorsWithSlots(): array
    {
        $sql = "
            SELECT
                d.id AS id_doctor,
                d.id_speciality,
                u.firstname,
                u.lastname,
                s.name AS speciality_name
            FROM doctors d
            JOIN users u ON d.id_user = u.id
            JOIN specialities s ON d.id_speciality = s.id
            WHERE 1 = 1
        ";

        $doctors = $this->pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);

        foreach ($doctors as &$doctor) {

            $sqlSlots = "
                SELECT
                    id,
                    start_time
                FROM timeslots
                WHERE id_doctor = :id_doctor
                AND is_available = 1
                AND start_time >= NOW()
                ORDER BY start_time
            ";

            $stmt = $this->pdo->prepare($sqlSlots);
            $stmt->execute([
                'id_doctor' => $doctor['id_doctor']
            ]);

            $doctor['creneaux'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        return $doctors;
    }

    public function searchDoctors(string $search, string $specialite = 'all'): array
    {
        $needle = mb_strtolower(trim($search), 'UTF-8');
        $allDoctors = $this->getDoctorsWithSlots();

        return array_values(array_filter($allDoctors, function ($doctor) use ($needle, $specialite) {
            $fullName = mb_strtolower(trim(($doctor['firstname'] ?? '') . ' ' . ($doctor['lastname'] ?? '')), 'UTF-8');
            $reverseName = mb_strtolower(trim(($doctor['lastname'] ?? '') . ' ' . ($doctor['firstname'] ?? '')), 'UTF-8');
            $specialityId = (string) ($doctor['id_speciality'] ?? '');

            $matchesSearch = $needle === ''
                || str_contains($fullName, $needle)
                || str_contains($reverseName, $needle)
                || str_contains(mb_strtolower($doctor['speciality_name'] ?? '', 'UTF-8'), $needle);

            $matchesSpecialite = $specialite === 'all' || $specialityId === (string) $specialite;

            return $matchesSearch && $matchesSpecialite;
        }));
    }
}