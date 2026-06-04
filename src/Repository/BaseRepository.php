<?php

namespace App\Repository;

use PDO;

abstract class BaseRepository
{
    public function __construct(protected PDO $pdo) {}

    /**
     * Execute a prepared query and return all results.
     */
    protected function fetchAll(string $sql, array $params = []): array
    {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    /**
     * Execute a prepared query and return a single row.
     */
    protected function fetchOne(string $sql, array $params = []): array|false
    {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetch();
    }

    /**
     * Execute a prepared statement (INSERT, UPDATE, DELETE) and return success status.
     */
    protected function execute(string $sql, array $params = []): bool
    {
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($params);
    }

    /**
     * Execute multiple statements within a transaction.
     *
     * @param callable $callback Receives the PDO instance, should throw on failure.
     * @return bool
     */
    protected function transaction(callable $callback): bool
    {
        try {
            $this->pdo->beginTransaction();
            $callback($this->pdo);
            $this->pdo->commit();
            return true;
        } catch (\Exception $e) {
            $this->pdo->rollBack();
            return false;
        }
    }
}
