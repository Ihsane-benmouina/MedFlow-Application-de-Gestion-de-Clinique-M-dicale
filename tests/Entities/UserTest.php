<?php

namespace Tests\Entities;

use App\Entities\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    public function testConstructorDefaults(): void
    {
        $user = new User();

        $this->assertNull($user->getId());
        $this->assertSame('', $user->getFirstname());
        $this->assertSame('', $user->getLastname());
        $this->assertSame('', $user->getEmail());
        $this->assertSame('', $user->getPassword());
        $this->assertSame('', $user->getPhone());
        $this->assertSame('patient', $user->getRole());
    }

    public function testConstructorWithValues(): void
    {
        $user = new User(
            id: 1,
            firstname: 'Ihsane',
            lastname: 'Benmouina',
            email: 'ihsane@example.com',
            password: 'secret123',
            phone: '+212600000000',
            role: 'medecin'
        );

        $this->assertSame(1, $user->getId());
        $this->assertSame('Ihsane', $user->getFirstname());
        $this->assertSame('Benmouina', $user->getLastname());
        $this->assertSame('ihsane@example.com', $user->getEmail());
        $this->assertSame('secret123', $user->getPassword());
        $this->assertSame('+212600000000', $user->getPhone());
        $this->assertSame('medecin', $user->getRole());
    }

    public function testSetId(): void
    {
        $user = new User();
        $user->setId(42);
        $this->assertSame(42, $user->getId());
    }

    public function testSetFirstname(): void
    {
        $user = new User();
        $user->setFirstname('Ahmed');
        $this->assertSame('Ahmed', $user->getFirstname());
    }

    public function testSetLastname(): void
    {
        $user = new User();
        $user->setLastname('Alami');
        $this->assertSame('Alami', $user->getLastname());
    }

    public function testSetEmail(): void
    {
        $user = new User();
        $user->setEmail('ahmed@clinic.ma');
        $this->assertSame('ahmed@clinic.ma', $user->getEmail());
    }

    public function testSetPassword(): void
    {
        $user = new User();
        $user->setPassword('newpass');
        $this->assertSame('newpass', $user->getPassword());
    }

    public function testSetPhone(): void
    {
        $user = new User();
        $user->setPhone('+212611223344');
        $this->assertSame('+212611223344', $user->getPhone());
    }

    public function testSetRole(): void
    {
        $user = new User();
        $this->assertSame('patient', $user->getRole());

        $user->setRole('admin');
        $this->assertSame('admin', $user->getRole());

        $user->setRole('medecin');
        $this->assertSame('medecin', $user->getRole());
    }
}
