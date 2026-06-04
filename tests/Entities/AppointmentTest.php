<?php

namespace Tests\Entities;

use App\Entities\Appointment;
use PHPUnit\Framework\TestCase;

class AppointmentTest extends TestCase
{
    public function testConstructorDefaults(): void
    {
        $appt = new Appointment();

        $this->assertNull($appt->getId());
        $this->assertSame(0, $appt->getIdPatient());
        $this->assertSame(0, $appt->getIdDoctor());
        $this->assertSame('confirmed', $appt->getStatus());
        $this->assertSame(0, $appt->getIdTimeslot());
    }

    public function testConstructorWithValues(): void
    {
        $appt = new Appointment(
            id: 10,
            id_patient: 5,
            id_doctor: 3,
            status: 'cancelled',
            id_timeslot: 20
        );

        $this->assertSame(10, $appt->getId());
        $this->assertSame(5, $appt->getIdPatient());
        $this->assertSame(3, $appt->getIdDoctor());
        $this->assertSame('cancelled', $appt->getStatus());
        $this->assertSame(20, $appt->getIdTimeslot());
    }

    public function testSetId(): void
    {
        $appt = new Appointment();
        $appt->setId(99);
        $this->assertSame(99, $appt->getId());
    }

    public function testSetIdPatient(): void
    {
        $appt = new Appointment();
        $appt->setIdPatient(12);
        $this->assertSame(12, $appt->getIdPatient());
    }

    public function testSetIdDoctor(): void
    {
        $appt = new Appointment();
        $appt->setIdDoctor(7);
        $this->assertSame(7, $appt->getIdDoctor());
    }

    public function testSetStatus(): void
    {
        $appt = new Appointment();
        $this->assertSame('confirmed', $appt->getStatus());

        $appt->setStatus('cancelled');
        $this->assertSame('cancelled', $appt->getStatus());

        $appt->setStatus('Terminé');
        $this->assertSame('Terminé', $appt->getStatus());
    }

    public function testSetIdTimeslot(): void
    {
        $appt = new Appointment();
        $appt->setIdTimeslot(55);
        $this->assertSame(55, $appt->getIdTimeslot());
    }
}
