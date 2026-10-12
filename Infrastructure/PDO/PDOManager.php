<?php

namespace Src\Infrastructure\PDO;

use PDO;

readonly class PDOManager
{
    private PDO $client;

    public function __construct()
    {
        $client = new PDOClient();

        $this->client = $client->connect();
    }

    protected function lastInsertId(): string
    {
        return $this->client->lastInsertId();
    }

//----------------------------------------------//
//-----------------TRANSACTION-----------------//
    public function beginTransaction(): void
    {
        $this->client->beginTransaction();
    }
    public function inTransaction(): bool
    {
        return $this->client->inTransaction();
    }
    public function commit(): void
    {
        $this->client->commit();
    }

    public function rollBack(): void
    {
        $this->client->rollBack();
    }
//----------------------------------------------//

    public function execute(
        string $query,
        array $parameters = []
    ): array
    {
        $stmt = $this->client->prepare($query);

        $stmt->execute($parameters);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}