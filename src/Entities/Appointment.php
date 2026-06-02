<?php

namespace App\Entities;

class Appointment {
    public function __construct(
        private ?int $id = null,
        private int $id_patient = 0,
        private int $id_doctor = 0,
        private string $status = 'confirmed',
        private int $id_timeslot = 0
    ) {}

    // Getters & Setters
    public function getId(): ?int { return $this->id; }
    public function setId(int $id): void { $this->id = $id; }

    public function getIdPatient(): int { return $this->id_patient; }
    public function setIdPatient(int $id_patient): void { $this->id_patient = $id_patient; }

    public function getIdDoctor(): int { return $this->id_doctor; }
    public function setIdDoctor(int $id_doctor): void { $this->id_doctor = $id_doctor; }

    public function getStatus(): string { return $this->status; }
    public function setStatus(string $status): void { $this->status = $status; }

    public function getIdTimeslot(): int { return $this->id_timeslot; }
    public function setIdTimeslot(int $id_timeslot): void { $this->id_timeslot = $id_timeslot; }
}