<?php

declare(strict_types=1);

require_once __DIR__ . '/Database.php';

class AddressbookModel
{
    private PDO $connection;

    public function __construct(?PDO $connection = null)
    {
        $this->connection = $connection ?? Database::getConnection();
    }

    /**
     * @return array<int, array<string, string|int|null>>
     */
    public function getEntriesForTenant(int $tenantId): array
    {
        $statement = $this->connection->prepare(
            'SELECT id, first_name, last_name, company, email, phone, city
             FROM addressbook_entries
             WHERE tenant_id = :tenant_id
             ORDER BY last_name ASC'
        );
        $statement->execute(['tenant_id' => $tenantId]);

        return $statement->fetchAll();
    }
}
