<?php

declare(strict_types=1);

require_once __DIR__ . '/Database.php';

class ApplicationModel
{
    private PDO $connection;

    public function __construct(?PDO $connection = null)
    {
        $this->connection = $connection ?? Database::getConnection();
    }

    /**
     * @return array<int, array<string, string|int>>
     */
    public function getAppsForTenant(int $tenantId): array
    {
        $statement = $this->connection->prepare(
            'SELECT applications.name, applications.app_key, tenant_applications.enabled
             FROM tenant_applications
             JOIN applications ON applications.id = tenant_applications.application_id
             WHERE tenant_applications.tenant_id = :tenant_id
             ORDER BY applications.name ASC'
        );
        $statement->execute(['tenant_id' => $tenantId]);

        return $statement->fetchAll();
    }
}
