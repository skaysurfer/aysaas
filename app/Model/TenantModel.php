<?php

declare(strict_types=1);

require_once __DIR__ . '/Database.php';

class TenantModel
{
    private PDO $connection;

    public function __construct(?PDO $connection = null)
    {
        $this->connection = $connection ?? Database::getConnection();
    }

    /**
     * @return array<int, array<string, string|int>>
     */
    public function getTenants(): array
    {
        $statement = $this->connection->query(
            'SELECT id, name, status, plan FROM tenants ORDER BY created_at DESC'
        );

        return $statement->fetchAll();
    }

    /**
     * @return array<string, string|int>|null
     */
    public function getTenantById(int $id): ?array
    {
        $statement = $this->connection->prepare(
            'SELECT id, name, slug, status, plan, created_at FROM tenants WHERE id = :id'
        );
        $statement->execute(['id' => $id]);
        $tenant = $statement->fetch();

        return $tenant ?: null;
    }

    /**
     * @param array{name:string,slug:string,status:string,plan:string} $data
     */
    public function updateTenant(int $id, array $data): void
    {
        $statement = $this->connection->prepare(
            'UPDATE tenants SET name = :name, slug = :slug, status = :status, plan = :plan WHERE id = :id'
        );
        $statement->execute([
            'id' => $id,
            'name' => $data['name'],
            'slug' => $data['slug'],
            'status' => $data['status'],
            'plan' => $data['plan'],
        ]);
    }
}
