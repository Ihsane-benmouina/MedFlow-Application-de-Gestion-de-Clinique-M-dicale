<?php

namespace Tests\Entities;

use App\Entities\Timeslot;
use PHPUnit\Framework\TestCase;

class TimeslotTest extends TestCase
{
    public function testConstructorDefaults(): void
    {
        $ts = new Timeslot();

        $this->assertNull($ts->getId());
        $this->assertSame('', $ts->getStartTime());
        $this->assertSame('', $ts->getEndTime());
        $this->assertTrue($ts->getIsAvailable());
        $this->assertSame(0, $ts->getIdDoctor());
    }

    public function testConstructorWithValues(): void
    {
        $ts = new Timeslot(
            id: 1,
            start_time: '2025-06-01 09:00:00',
            end_time: '2025-06-01 09:30:00',
            is_available: false,
            id_doctor: 5
        );

        $this->assertSame(1, $ts->getId());
        $this->assertSame('2025-06-01 09:00:00', $ts->getStartTime());
        $this->assertSame('2025-06-01 09:30:00', $ts->getEndTime());
        $this->assertFalse($ts->getIsAvailable());
        $this->assertSame(5, $ts->getIdDoctor());
    }

    public function testSetId(): void
    {
        $ts = new Timeslot();
        $ts->setId(33);
        $this->assertSame(33, $ts->getId());
    }

    public function testSetStartTime(): void
    {
        $ts = new Timeslot();
        $ts->setStartTime('2025-07-15 14:00:00');
        $this->assertSame('2025-07-15 14:00:00', $ts->getStartTime());
    }

    public function testSetEndTime(): void
    {
        $ts = new Timeslot();
        $ts->setEndTime('2025-07-15 14:30:00');
        $this->assertSame('2025-07-15 14:30:00', $ts->getEndTime());
    }

    public function testSetIsAvailable(): void
    {
        $ts = new Timeslot();
        $this->assertTrue($ts->getIsAvailable());

        $ts->setIsAvailable(false);
        $this->assertFalse($ts->getIsAvailable());

        $ts->setIsAvailable(true);
        $this->assertTrue($ts->getIsAvailable());
    }

    public function testSetIdDoctor(): void
    {
        $ts = new Timeslot();
        $ts->setIdDoctor(8);
        $this->assertSame(8, $ts->getIdDoctor());
    }
}
