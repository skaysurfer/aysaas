<?php

declare(strict_types=1);

require_once __DIR__ . '/../Model/TenantModel.php';
require_once __DIR__ . '/../Model/UserModel.php';
require_once __DIR__ . '/../Model/ApplicationModel.php';
require_once __DIR__ . '/../Model/MessageModel.php';
require_once __DIR__ . '/../Model/AddressbookModel.php';

class DashboardController
{
    private TenantModel $tenantModel;
    private UserModel $userModel;
    private ApplicationModel $applicationModel;
    private MessageModel $messageModel;
    private AddressbookModel $addressbookModel;

    public function __construct(
        ?TenantModel $tenantModel = null,
        ?UserModel $userModel = null,
        ?ApplicationModel $applicationModel = null,
        ?MessageModel $messageModel = null,
        ?AddressbookModel $addressbookModel = null
    ) {
        $this->tenantModel = $tenantModel ?? new TenantModel();
        $this->userModel = $userModel ?? new UserModel();
        $this->applicationModel = $applicationModel ?? new ApplicationModel();
        $this->messageModel = $messageModel ?? new MessageModel();
        $this->addressbookModel = $addressbookModel ?? new AddressbookModel();
    }

    public function index(): void
    {
        $user = $_SESSION['user'] ?? null;
        if ($user === null) {
            header('Location: /');
            exit;
        }

        $role = $user['role'] ?? '';
        $tenantId = (int) ($user['tenant_id'] ?? 0);

        if ($role === 'admin') {
            $apps = ['Adressbuch', 'Nachrichten', 'Abrechnung'];
            $tenants = $this->tenantModel->getTenants();

            $this->render('dashboard', [
                'apps' => $apps,
                'tenants' => $tenants,
            ]);
            return;
        }

        if ($role === 'mandant-admin') {
            $apps = $this->applicationModel->getAppsForTenant($tenantId);
            $users = $this->userModel->getUsersForTenant($tenantId);

            $this->render('dashboard-tenant-admin', [
                'apps' => $apps,
                'users' => $users,
            ]);
            return;
        }

        if ($role === 'kunde') {
            $entries = $this->addressbookModel->getEntriesForTenant($tenantId);
            $messages = $this->messageModel->getMessagesForTenant($tenantId);

            $this->render('dashboard-customer', [
                'entries' => $entries,
                'messages' => $messages,
            ]);
            return;
        }

        if ($role === 'dienstleister') {
            $messages = $this->messageModel->getMessagesForTenant($tenantId);

            $this->render('dashboard-provider', [
                'messages' => $messages,
            ]);
            return;
        }

        http_response_code(403);
        $this->render('tenant-not-found');
    }

    private function render(string $view, array $data = []): void
    {
        extract($data, EXTR_SKIP);

        require __DIR__ . '/../View/' . $view . '.php';
    }
}
