<?php

namespace Tests\Entities;

use App\Entities\Prescription;
use PHPUnit\Framework\TestCase;

class PrescriptionTest extends TestCase
{
    public function testConstructorDefaults(): void
    {
        $rx = new Prescription();

        $this->assertNull($rx->getId());
        $this->assertSame('', $rx->getDescription());
        $this->assertSame(0, $rx->getIdAppointment());
    }

    public function testConstructorWithValues(): void
    {
        $rx = new Prescription(
            id: 1,
            description: 'Amoxicilline 500mg x3/jour pendant 7 jours',
            id_appointment: 42
        );

        $this->assertSame(1, $rx->getId());
        $this->assertSame('Amoxicilline 500mg x3/jour pendant 7 jours', $rx->getDescription());
        $this->assertSame(42, $rx->getIdAppointment());
    }

    public function testSetId(): void
    {
        $rx = new Prescription();
        $rx->setId(10);
        $this->assertSame(10, $rx->getId());
    }

    public function testSetDescription(): void
    {
        $rx = new Prescription();
        $rx->setDescription('Paracétamol 1g si douleur');
        $this->assertSame('Paracétamol 1g si douleur', $rx->getDescription());
    }

    public function testSetIdAppointment(): void
    {
        $rx = new Prescription();
        $rx->setIdAppointment(99);
        $this->assertSame(99, $rx->getIdAppointment());
    }

    public function testEmptyDescription(): void
    {
        $rx = new Prescription(description: '');
        $this->assertSame('', $rx->getDescription());
    }
}
