<?php

declare(strict_types=1);

require_once __DIR__ . '/../Model/TenantModel.php';

class TenantController
{
    private TenantModel $tenantModel;

    public function __construct(?TenantModel $tenantModel = null)
    {
        $this->tenantModel = $tenantModel ?? new TenantModel();
    }

    public function show(int $id): void
    {
        $tenant = $this->tenantModel->getTenantById($id);

        if ($tenant === null) {
            http_response_code(404);
            $this->render('tenant-not-found');
            return;
        }

        $this->render('tenant-detail', [
            'tenant' => $tenant,
        ]);
    }

    public function createForm(): void
    {
        $this->render('tenant-create');
    }

    public function editForm(int $id): void
    {
        $tenant = $this->tenantModel->getTenantById($id);

        if ($tenant === null) {
            http_response_code(404);
            $this->render('tenant-not-found');
            return;
        }

        $this->render('tenant-edit', [
            'tenant' => $tenant,
        ]);
    }

    public function update(int $id): void
    {
        $tenant = $this->tenantModel->getTenantById($id);

        if ($tenant === null) {
            http_response_code(404);
            $this->render('tenant-not-found');
            return;
        }

        $payload = [
            'name' => trim((string)($_POST['name'] ?? '')),
            'slug' => trim((string)($_POST['slug'] ?? '')),
            'status' => trim((string)($_POST['status'] ?? '')),
            'plan' => trim((string)($_POST['plan'] ?? '')),
        ];

        $errors = [];
        if ($payload['name'] === '' || $payload['slug'] === '') {
            $errors[] = 'Name und Slug sind Pflichtfelder.';
        }

        if (!in_array($payload['status'], ['active', 'inactive', 'trial'], true)) {
            $errors[] = 'Bitte wählen Sie einen gültigen Status.';
        }

        if ($errors !== []) {
            $this->render('tenant-edit', [
                'tenant' => array_merge($tenant, $payload),
                'errors' => $errors,
            ]);
            return;
        }

        $this->tenantModel->updateTenant($id, $payload);
        $tenant = $this->tenantModel->getTenantById($id);

        $this->render('tenant-edit', [
            'tenant' => $tenant,
            'success' => 'Mandant wurde aktualisiert.',
        ]);
    }

    private function render(string $view, array $data = []): void
    {
        extract($data, EXTR_SKIP);

        require __DIR__ . '/../View/' . $view . '.php';
    }
}
