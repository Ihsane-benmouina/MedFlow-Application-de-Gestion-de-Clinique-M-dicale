<?php

namespace Tests\Repository;

use App\Repository\DoctorRepository;
use PDO;
use PDOStatement;
use PHPUnit\Framework\TestCase;

class DoctorRepositoryTest extends TestCase
{
    private PDO $pdo;
    private DoctorRepository $repo;

    protected function setUp(): void
    {
        $this->pdo = $this->createMock(PDO::class);
        $this->repo = new DoctorRepository($this->pdo);
    }

    public function testGetDoctorRendezVousReturnsList(): void
    {
        $expected = [
            [
                'id_rdv' => 1,
                'statut' => 'Confirmé',
                'heure_debut' => '2025-06-01 09:00:00',
                'patient_nom' => 'Alami',
                'patient_prenom' => 'Ahmed',
                'patient_email' => 'ahmed@test.com',
            ],
        ];

        $stmt = $this->createMock(PDOStatement::class);
        $stmt->expects($this->once())
            ->method('execute')
            ->with(['id_medecin' => 5]);
        $stmt->expects($this->once())
            ->method('fetchAll')
            ->willReturn($expected);

        $this->pdo->expects($this->once())
            ->method('prepare')
            ->willReturn($stmt);

        $result = $this->repo->getDoctorRendezVous(5);

        $this->assertSame($expected, $result);
    }

    public function testGetDoctorRendezVousReturnsEmptyForUnknownDoctor(): void
    {
        $stmt = $this->createMock(PDOStatement::class);
        $stmt->method('execute');
        $stmt->method('fetchAll')->willReturn([]);

        $this->pdo->method('prepare')->willReturn($stmt);

        $result = $this->repo->getDoctorRendezVous(999);

        $this->assertSame([], $result);
    }

    public function testUpdateRendezVousStatutReturnsTrue(): void
    {
        $stmt = $this->createMock(PDOStatement::class);
        $stmt->expects($this->once())
            ->method('execute')
            ->with(['statut' => 'Confirmé', 'id_rdv' => 10])
            ->willReturn(true);

        $this->pdo->expects($this->once())
            ->method('prepare')
            ->willReturn($stmt);

        $result = $this->repo->updateRendezVousStatut(10, 'Confirmé');

        $this->assertTrue($result);
    }

    public function testUpdateRendezVousStatutAnnule(): void
    {
        $stmt = $this->createMock(PDOStatement::class);
        $stmt->expects($this->once())
            ->method('execute')
            ->with(['statut' => 'Annulé', 'id_rdv' => 7])
            ->willReturn(true);

        $this->pdo->method('prepare')->willReturn($stmt);

        $result = $this->repo->updateRendezVousStatut(7, 'Annulé');

        $this->assertTrue($result);
    }

    public function testCloturerConsultationSuccess(): void
    {
        $stmtOrdo = $this->createMock(PDOStatement::class);
        $stmtOrdo->expects($this->once())
            ->method('execute')
            ->with(['id_rdv' => 1, 'description' => 'Prescription test']);

        $stmtUpdate = $this->createMock(PDOStatement::class);
        $stmtUpdate->expects($this->once())
            ->method('execute')
            ->with(['id_rdv' => 1]);

        $this->pdo->expects($this->once())->method('beginTransaction');
        $this->pdo->expects($this->exactly(2))
            ->method('prepare')
            ->willReturnOnConsecutiveCalls($stmtOrdo, $stmtUpdate);
        $this->pdo->expects($this->once())->method('commit');

        $result = $this->repo->clôturerConsultation(1, 'Prescription test');

        $this->assertTrue($result);
    }

    public function testCloturerConsultationRollbackOnFailure(): void
    {
        $stmtOrdo = $this->createMock(PDOStatement::class);
        $stmtOrdo->method('execute')
            ->willThrowException(new \Exception('DB error'));

        $this->pdo->method('beginTransaction');
        $this->pdo->method('prepare')->willReturn($stmtOrdo);
        $this->pdo->expects($this->once())->method('rollBack');

        $result = $this->repo->clôturerConsultation(1, 'bad data');

        $this->assertFalse($result);
    }
}
