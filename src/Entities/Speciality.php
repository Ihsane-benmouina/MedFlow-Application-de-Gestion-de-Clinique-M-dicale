<?php

namespace App\Entities;

class Speciality {
    public function __construct(
        private ?int $id = null,
        private string $name = '',
        private string $description = ''
    ) {}

    // Getters & Setters
    public function getId(): ?int { return $this->id; }
    public function setId(int $id): void { $this->id = $id; }

    public function getName(): string { return $this->name; }
    public function setName(string $name): void { $this->name = $name; }

    public function getDescription(): string { return $this->description; }
    public function setDescription(string $description): void { $this->description = $description; }
}