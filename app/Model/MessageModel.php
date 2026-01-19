<?php

declare(strict_types=1);

require_once __DIR__ . '/Database.php';

class MessageModel
{
    private PDO $connection;

    public function __construct(?PDO $connection = null)
    {
        $this->connection = $connection ?? Database::getConnection();
    }

    /**
     * @return array<int, array<string, string|int|null>>
     */
    public function getMessagesForTenant(int $tenantId): array
    {
        $statement = $this->connection->prepare(
            'SELECT messages.id, messages.subject, messages.scope, messages.created_at,
                    sender.display_name AS sender_name,
                    recipient.display_name AS recipient_name
             FROM messages
             JOIN users AS sender ON sender.id = messages.sender_user_id
             LEFT JOIN users AS recipient ON recipient.id = messages.recipient_user_id
             WHERE messages.tenant_id = :tenant_id
             ORDER BY messages.created_at DESC'
        );
        $statement->execute(['tenant_id' => $tenantId]);

        return $statement->fetchAll();
    }
}
