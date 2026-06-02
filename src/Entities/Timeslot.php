<?php

namespace App\Entities;

class Timeslot {
    public function __construct(
        private ?int $id = null,
        private string $start_time = '',
        private string $end_time = '',
        private bool $is_available = true,
        private int $id_doctor = 0
    ) {}

    // Getters & Setters
    public function getId(): ?int { return $this->id; }
    public function setId(int $id): void { $this->id = $id; }

    public function getStartTime(): string { return $this->start_time; }
    public function setStartTime(string $start_time): void { $this->start_time = $start_time; }

    public function getEndTime(): string { return $this->end_time; }
    public function setEndTime(string $end_time): void { $this->end_time = $end_time; }

    public function getIsAvailable(): bool { return $this->is_available; }
    public function setIsAvailable(bool $is_available): void { $this->is_available = $is_available; }

    public function getIdDoctor(): int { return $this->id_doctor; }
    public function setIdDoctor(int $id_doctor): void { $this->id_doctor = $id_doctor; }
}