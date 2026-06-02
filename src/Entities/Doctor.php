<?php

namespace App\Entities;

class Doctor {
    public function __construct(
        private ?int $id = null,
        private int $id_user = 0,
        private int $id_speciality = 0,
        private bool $is_active = true
    ) {}

    // Getters & Setters
    public function getId(): ?int { return $this->id; }
    public function setId(int $id): void { $this->id = $id; }

    public function getIdUser(): int { return $this->id_user; }
    public function setIdUser(int $id_user): void { $this->id_user = $id_user; }

    public function getIdSpeciality(): int { return $this->id_speciality; }
    public function setIdSpeciality(int $id_speciality): void { $this->id_speciality = $id_speciality; }

    public function getIsActive(): bool { return $this->is_active; }
    public function setIsActive(bool $is_active): void { $this->is_active = $is_active; }
}