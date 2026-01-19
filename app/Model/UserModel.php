<?php

declare(strict_types=1);

require_once __DIR__ . '/Database.php';

class UserModel
{
    private PDO $connection;

    public function __construct(?PDO $connection = null)
    {
        $this->connection = $connection ?? Database::getConnection();
    }

    public function findByEmail(string $email): ?array
    {
        $statement = $this->connection->prepare(
            'SELECT users.*, roles.name AS role_name FROM users JOIN roles ON roles.id = users.role_id WHERE users.email = :email'
        );
        $statement->execute(['email' => $email]);
        $user = $statement->fetch();

        return $user ?: null;
    }

    /**
     * @return array<int, array<string, string|int>>
     */
    public function getUsersForTenant(int $tenantId): array
    {
        $statement = $this->connection->prepare(
            'SELECT users.id, users.display_name, users.email, users.status, roles.name AS role_name
             FROM users
             JOIN roles ON roles.id = users.role_id
             WHERE users.tenant_id = :tenant_id
             ORDER BY users.created_at DESC'
        );
        $statement->execute(['tenant_id' => $tenantId]);

        return $statement->fetchAll();
    }
}
