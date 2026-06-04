<?php

namespace Tests\Entities;

use App\Entities\Doctor;
use PHPUnit\Framework\TestCase;

class DoctorTest extends TestCase
{
    public function testConstructorDefaults(): void
    {
        $doctor = new Doctor();

        $this->assertNull($doctor->getId());
        $this->assertSame(0, $doctor->getIdUser());
        $this->assertSame(0, $doctor->getIdSpeciality());
        $this->assertTrue($doctor->getIsActive());
    }

    public function testConstructorWithValues(): void
    {
        $doctor = new Doctor(
            id: 5,
            id_user: 10,
            id_speciality: 3,
            is_active: false
        );

        $this->assertSame(5, $doctor->getId());
        $this->assertSame(10, $doctor->getIdUser());
        $this->assertSame(3, $doctor->getIdSpeciality());
        $this->assertFalse($doctor->getIsActive());
    }

    public function testSetId(): void
    {
        $doctor = new Doctor();
        $doctor->setId(7);
        $this->assertSame(7, $doctor->getId());
    }

    public function testSetIdUser(): void
    {
        $doctor = new Doctor();
        $doctor->setIdUser(15);
        $this->assertSame(15, $doctor->getIdUser());
    }

    public function testSetIdSpeciality(): void
    {
        $doctor = new Doctor();
        $doctor->setIdSpeciality(4);
        $this->assertSame(4, $doctor->getIdSpeciality());
    }

    public function testSetIsActive(): void
    {
        $doctor = new Doctor();
        $this->assertTrue($doctor->getIsActive());

        $doctor->setIsActive(false);
        $this->assertFalse($doctor->getIsActive());

        $doctor->setIsActive(true);
        $this->assertTrue($doctor->getIsActive());
    }
}
