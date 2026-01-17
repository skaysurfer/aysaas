<?php

declare(strict_types=1);

require_once __DIR__ . '/../Model/TenantModel.php';

class DashboardController
{
    private TenantModel $tenantModel;

    public function __construct(?TenantModel $tenantModel = null)
    {
        $this->tenantModel = $tenantModel ?? new TenantModel();
    }

    public function index(): void
    {
        $apps = [
            'Adressbuch',
            'Nachrichten',
            'Abrechnung',
        ];

        $tenants = $this->tenantModel->getTenants();

        $this->render('dashboard', [
            'apps' => $apps,
            'tenants' => $tenants,
        ]);
    }

    private function render(string $view, array $data = []): void
    {
        extract($data, EXTR_SKIP);

        require __DIR__ . '/../View/' . $view . '.php';
    }
}
