<?php
class DoctorRepository
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function findAll():array{

        $sql="
       
            m.id,
            u.nom,
            u.prenom,
            u.email,
            s.nom AS specialite,
            m.actif
           FROM medecins m
           JOIN users u
           ON m.id_user = u.id
           JOIN specialites s
           ON m.id_specialite = s.id";

        return $this->pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function findById(int $id): ?array
    {
    $sql = "
        SELECT
            m.id,
            u.nom,
            u.prenom,
            u.email,
            s.nom AS specialite,
            m.actif
        FROM medecins m
        JOIN users u
            ON m.id_user = u.id
        JOIN specialites s
            ON m.id_specialite = s.id
        WHERE m.id = :id
    ";

    $stmt = $this->pdo->prepare($sql);
    $stmt->execute(['id' => $id]);

    $doctor = $stmt->fetch(PDO::FETCH_ASSOC);

    return $doctor ?: null;
}
}