<?php

namespace Tests\Repository;

use App\Repository\PatientRepository;
use PDO;
use PDOStatement;
use PHPUnit\Framework\TestCase;

class PatientRepositoryTest extends TestCase
{
    private PDO $pdo;
    private PatientRepository $repo;

    protected function setUp(): void
    {
        $this->pdo = $this->createMock(PDO::class);
        $this->repo = new PatientRepository($this->pdo);
    }

    public function testGetAllSpecialites(): void
    {
        $expected = [
            ['id' => 1, 'nom' => 'Cardiologie'],
            ['id' => 2, 'nom' => 'Dermatologie'],
        ];

        $stmt = $this->createMock(PDOStatement::class);
        $stmt->method('fetchAll')->willReturn($expected);

        $this->pdo->expects($this->once())
            ->method('query')
            ->willReturn($stmt);

        $result = $this->repo->getAllSpecialites();

        $this->assertCount(2, $result);
        $this->assertSame('Cardiologie', $result[0]['nom']);
    }

    public function testGetAllSpecialitesEmpty(): void
    {
        $stmt = $this->createMock(PDOStatement::class);
        $stmt->method('fetchAll')->willReturn([]);

        $this->pdo->method('query')->willReturn($stmt);

        $result = $this->repo->getAllSpecialites();

        $this->assertSame([], $result);
    }

    public function testGetMedecinsWithCreneaux(): void
    {
        $medecins = [
            [
                'id_medecin' => 1,
                'id_specialite' => 1,
                'nom' => 'Bennani',
                'prenom' => 'Youssef',
                'specialite_nom' => 'Cardiologie',
            ],
        ];

        $creneaux = [
            ['id' => 10, 'heure_debut' => '2025-06-01 10:00:00'],
        ];

        $stmtMedecins = $this->createMock(PDOStatement::class);
        $stmtMedecins->method('fetchAll')->willReturn($medecins);

        $stmtCreneaux = $this->createMock(PDOStatement::class);
        $stmtCreneaux->method('execute');
        $stmtCreneaux->method('fetchAll')->willReturn($creneaux);

        $this->pdo->expects($this->once())
            ->method('query')
            ->willReturn($stmtMedecins);

        $this->pdo->expects($this->once())
            ->method('prepare')
            ->willReturn($stmtCreneaux);

        $result = $this->repo->getMedecinsWithCreneaux();

        $this->assertCount(1, $result);
        $this->assertSame('Bennani', $result[0]['nom']);
        $this->assertArrayHasKey('creneaux', $result[0]);
        $this->assertCount(1, $result[0]['creneaux']);
    }

    public function testGetPatientRendezVous(): void
    {
        $expected = [
            [
                'id_rdv' => 1,
                'statut' => 'Confirmé',
                'heure_debut' => '2025-06-01 09:00:00',
                'medecin_nom' => 'Bennani',
                'medecin_prenom' => 'Youssef',
            ],
        ];

        $stmt = $this->createMock(PDOStatement::class);
        $stmt->expects($this->once())
            ->method('execute')
            ->with(['id_patient' => 3]);
        $stmt->method('fetchAll')->willReturn($expected);

        $this->pdo->method('prepare')->willReturn($stmt);

        $result = $this->repo->getPatientRendezVous(3);

        $this->assertCount(1, $result);
        $this->assertSame('Confirmé', $result[0]['statut']);
    }

    public function testGetPatientRendezVousEmpty(): void
    {
        $stmt = $this->createMock(PDOStatement::class);
        $stmt->method('execute');
        $stmt->method('fetchAll')->willReturn([]);

        $this->pdo->method('prepare')->willReturn($stmt);

        $result = $this->repo->getPatientRendezVous(999);

        $this->assertSame([], $result);
    }

    public function testGetPatientOrdonnances(): void
    {
        $expected = [
            [
                'id' => 1,
                'contenu' => 'Amoxicilline 500mg',
                'date_creation' => '2025-06-01',
                'medecin_nom' => 'Bennani',
                'medecin_prenom' => 'Youssef',
            ],
        ];

        $stmt = $this->createMock(PDOStatement::class);
        $stmt->expects($this->once())
            ->method('execute')
            ->with(['id_patient' => 3]);
        $stmt->method('fetchAll')->willReturn($expected);

        $this->pdo->method('prepare')->willReturn($stmt);

        $result = $this->repo->getPatientOrdonnances(3);

        $this->assertCount(1, $result);
        $this->assertSame('Amoxicilline 500mg', $result[0]['contenu']);
    }

    public function testGetPatientOrdonnancesEmpty(): void
    {
        $stmt = $this->createMock(PDOStatement::class);
        $stmt->method('execute');
        $stmt->method('fetchAll')->willReturn([]);

        $this->pdo->method('prepare')->willReturn($stmt);

        $result = $this->repo->getPatientOrdonnances(999);

        $this->assertSame([], $result);
    }
}
