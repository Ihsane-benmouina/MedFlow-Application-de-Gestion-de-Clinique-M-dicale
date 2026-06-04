<?php

namespace Tests\Entities;

use App\Entities\Speciality;
use PHPUnit\Framework\TestCase;

class SpecialityTest extends TestCase
{
    public function testConstructorDefaults(): void
    {
        $spec = new Speciality();

        $this->assertNull($spec->getId());
        $this->assertSame('', $spec->getName());
        $this->assertSame('', $spec->getDescription());
    }

    public function testConstructorWithValues(): void
    {
        $spec = new Speciality(
            id: 1,
            name: 'Cardiologie',
            description: 'Spécialité du cœur et des vaisseaux sanguins'
        );

        $this->assertSame(1, $spec->getId());
        $this->assertSame('Cardiologie', $spec->getName());
        $this->assertSame('Spécialité du cœur et des vaisseaux sanguins', $spec->getDescription());
    }

    public function testSetId(): void
    {
        $spec = new Speciality();
        $spec->setId(3);
        $this->assertSame(3, $spec->getId());
    }

    public function testSetName(): void
    {
        $spec = new Speciality();
        $spec->setName('Dermatologie');
        $this->assertSame('Dermatologie', $spec->getName());
    }

    public function testSetDescription(): void
    {
        $spec = new Speciality();
        $spec->setDescription('Maladies de la peau');
        $this->assertSame('Maladies de la peau', $spec->getDescription());
    }

    public function testMultipleSpecialities(): void
    {
        $specs = [
            new Speciality(id: 1, name: 'Cardiologie', description: 'Cœur'),
            new Speciality(id: 2, name: 'Neurologie', description: 'Cerveau'),
            new Speciality(id: 3, name: 'Pédiatrie', description: 'Enfants'),
        ];

        $this->assertCount(3, $specs);
        $this->assertSame('Neurologie', $specs[1]->getName());
    }
}
