<?php

declare(strict_types=1);

require_once __DIR__ . '/../Model/Database.php';

class AdminController
{
    private PDO $connection;

    /** @var array<string, array{primary:string, label:string, columns:string[], editable:string[]}> */
    private array $tables = [
        'tenants' => [
            'primary' => 'id',
            'label' => 'Mandanten',
            'columns' => ['id', 'name', 'slug', 'status', 'plan', 'created_at'],
            'editable' => ['name', 'slug', 'status', 'plan'],
        ],
        'roles' => [
            'primary' => 'id',
            'label' => 'Rollen',
            'columns' => ['id', 'name', 'description'],
            'editable' => ['name', 'description'],
        ],
        'users' => [
            'primary' => 'id',
            'label' => 'Benutzer',
            'columns' => ['id', 'tenant_id', 'role_id', 'email', 'display_name', 'status', 'created_at'],
            'editable' => ['tenant_id', 'role_id', 'email', 'display_name', 'status'],
        ],
        'applications' => [
            'primary' => 'id',
            'label' => 'Applikationen',
            'columns' => ['id', 'app_key', 'name', 'status', 'created_at'],
            'editable' => ['app_key', 'name', 'status', 'description'],
        ],
        'tenant_applications' => [
            'primary' => 'id',
            'label' => 'Mandanten-Applikationen',
            'columns' => ['id', 'tenant_id', 'application_id', 'enabled', 'created_at'],
            'editable' => ['tenant_id', 'application_id', 'enabled', 'configuration'],
        ],
        'tenant_settings' => [
            'primary' => 'tenant_id',
            'label' => 'Mandanten-Einstellungen',
            'columns' => ['tenant_id', 'messaging_scope', 'created_at'],
            'editable' => ['messaging_scope'],
        ],
        'messages' => [
            'primary' => 'id',
            'label' => 'Nachrichten',
            'columns' => ['id', 'tenant_id', 'sender_user_id', 'recipient_user_id', 'scope', 'subject', 'created_at'],
            'editable' => ['tenant_id', 'sender_user_id', 'recipient_user_id', 'scope', 'subject', 'body'],
        ],
        'addressbook_entries' => [
            'primary' => 'id',
            'label' => 'Adressbuch',
            'columns' => ['id', 'tenant_id', 'owner_user_id', 'first_name', 'last_name', 'email', 'phone', 'city'],
            'editable' => ['tenant_id', 'owner_user_id', 'first_name', 'last_name', 'company', 'email', 'phone', 'mobile', 'street', 'city', 'postal_code', 'country', 'notes'],
        ],
        'invoices' => [
            'primary' => 'id',
            'label' => 'Rechnungen',
            'columns' => ['id', 'tenant_id', 'period_start', 'period_end', 'total_amount', 'currency', 'created_at'],
            'editable' => ['tenant_id', 'period_start', 'period_end', 'total_amount', 'currency'],
        ],
        'invoice_line_items' => [
            'primary' => 'id',
            'label' => 'Rechnungspositionen',
            'columns' => ['id', 'invoice_id', 'description', 'quantity', 'unit_price', 'total'],
            'editable' => ['invoice_id', 'description', 'quantity', 'unit_price', 'total'],
        ],
    ];

    public function __construct(?PDO $connection = null)
    {
        $this->connection = $connection ?? Database::getConnection();
    }

    public function index(string $table): void
    {
        $config = $this->getTableConfig($table);
        if ($config === null) {
            http_response_code(404);
            $this->render('tenant-not-found');
            return;
        }

        $columns = implode(', ', $config['columns']);
        $statement = $this->connection->query(sprintf('SELECT %s FROM %s', $columns, $table));
        $rows = $statement->fetchAll();

        $this->render('admin-list', [
            'table' => $table,
            'config' => $config,
            'rows' => $rows,
        ]);
    }

    public function overview(): void
    {
        $this->render('admin-index', [
            'tables' => $this->tables,
        ]);
    }

    public function editForm(string $table, int $id): void
    {
        $config = $this->getTableConfig($table);
        if ($config === null) {
            http_response_code(404);
            $this->render('tenant-not-found');
            return;
        }

        $record = $this->findRecord($table, $config, $id);
        if ($record === null) {
            http_response_code(404);
            $this->render('tenant-not-found');
            return;
        }

        $this->render('admin-edit', [
            'table' => $table,
            'config' => $config,
            'record' => $record,
        ]);
    }

    public function update(string $table, int $id): void
    {
        $config = $this->getTableConfig($table);
        if ($config === null) {
            http_response_code(404);
            $this->render('tenant-not-found');
            return;
        }

        $record = $this->findRecord($table, $config, $id);
        if ($record === null) {
            http_response_code(404);
            $this->render('tenant-not-found');
            return;
        }

        $data = [];
        foreach ($config['editable'] as $field) {
            $data[$field] = trim((string)($_POST[$field] ?? ''));
        }

        $set = implode(', ', array_map(static fn (string $field): string => sprintf('%s = :%s', $field, $field), array_keys($data)));
        $statement = $this->connection->prepare(sprintf(
            'UPDATE %s SET %s WHERE %s = :primary_id',
            $table,
            $set,
            $config['primary']
        ));
        $statement->execute(array_merge($data, ['primary_id' => $id]));

        $record = $this->findRecord($table, $config, $id);

        $this->render('admin-edit', [
            'table' => $table,
            'config' => $config,
            'record' => $record,
            'success' => 'Datensatz wurde aktualisiert.',
        ]);
    }

    public function deleteConfirm(string $table, int $id): void
    {
        $config = $this->getTableConfig($table);
        if ($config === null) {
            http_response_code(404);
            $this->render('tenant-not-found');
            return;
        }

        $record = $this->findRecord($table, $config, $id);
        if ($record === null) {
            http_response_code(404);
            $this->render('tenant-not-found');
            return;
        }

        $this->render('admin-delete', [
            'table' => $table,
            'config' => $config,
            'record' => $record,
        ]);
    }

    public function delete(string $table, int $id): void
    {
        $config = $this->getTableConfig($table);
        if ($config === null) {
            http_response_code(404);
            $this->render('tenant-not-found');
            return;
        }

        $statement = $this->connection->prepare(sprintf(
            'DELETE FROM %s WHERE %s = :primary_id',
            $table,
            $config['primary']
        ));
        $statement->execute(['primary_id' => $id]);

        $this->render('admin-delete', [
            'table' => $table,
            'config' => $config,
            'record' => null,
            'success' => 'Datensatz wurde gelöscht.',
        ]);
    }

    private function getTableConfig(string $table): ?array
    {
        return $this->tables[$table] ?? null;
    }

    private function findRecord(string $table, array $config, int $id): ?array
    {
        $statement = $this->connection->prepare(sprintf(
            'SELECT %s FROM %s WHERE %s = :primary_id',
            implode(', ', $config['columns']),
            $table,
            $config['primary']
        ));
        $statement->execute(['primary_id' => $id]);
        $record = $statement->fetch();

        return $record ?: null;
    }

    private function render(string $view, array $data = []): void
    {
        extract($data, EXTR_SKIP);

        require __DIR__ . '/../View/' . $view . '.php';
    }
}
