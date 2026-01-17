<?php

declare(strict_types=1);

require __DIR__ . '/../app/Router.php';
require __DIR__ . '/../app/Controller/HomeController.php';
require __DIR__ . '/../app/Controller/AuthController.php';
require __DIR__ . '/../app/Controller/DashboardController.php';
require __DIR__ . '/../app/Controller/TenantController.php';
require __DIR__ . '/../app/Controller/AdminController.php';
require __DIR__ . '/../app/Controller/UserController.php';

$path = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?? '/';
$method = strtoupper($_SERVER['REQUEST_METHOD'] ?? 'GET');

$router = new Router();

$router->get('#^/$#', function (): void {
    $controller = new HomeController();
    $controller->index();
});

$router->get('#^/dashboard$#', function (): void {
    $controller = new DashboardController();
    $controller->index();
});

$router->get('#^/admin$#', function (): void {
    $controller = new AdminController();
    $controller->overview();
});

$router->get('#^/profile$#', function (): void {
    $controller = new UserController();
    $controller->profile();
});

$router->get('#^/settings$#', function (): void {
    $controller = new UserController();
    $controller->settings();
});

$router->get('#^/register$#', function (): void {
    $controller = new TenantController();
    $controller->createForm();
});

$router->post('#^/login$#', function (): void {
    $controller = new AuthController();
    $controller->login();
});

$router->post('#^/register$#', function (): void {
    $controller = new AuthController();
    $controller->register();
});

$router->get('#^/tenants/(\d+)/edit$#', function (string $id): void {
    $controller = new TenantController();
    $controller->editForm((int) $id);
});

$router->post('#^/tenants/(\d+)/edit$#', function (string $id): void {
    $controller = new TenantController();
    $controller->update((int) $id);
});

$router->get('#^/tenants/(\d+)$#', function (string $id): void {
    $controller = new TenantController();
    $controller->show((int) $id);
});

$router->get('#^/admin/([a-z_]+)$#', function (string $table): void {
    $controller = new AdminController();
    $controller->index($table);
});

$router->get('#^/admin/([a-z_]+)/edit/(\d+)$#', function (string $table, string $id): void {
    $controller = new AdminController();
    $controller->editForm($table, (int) $id);
});

$router->post('#^/admin/([a-z_]+)/edit/(\d+)$#', function (string $table, string $id): void {
    $controller = new AdminController();
    $controller->update($table, (int) $id);
});

$router->get('#^/admin/([a-z_]+)/delete/(\d+)$#', function (string $table, string $id): void {
    $controller = new AdminController();
    $controller->deleteConfirm($table, (int) $id);
});

$router->post('#^/admin/([a-z_]+)/delete/(\d+)$#', function (string $table, string $id): void {
    $controller = new AdminController();
    $controller->delete($table, (int) $id);
});

if ($router->dispatch($method, $path)) {
    return;
}

http_response_code(404);
?><!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>404 - Seite nicht gefunden</title>
    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body class="not-found">
    <div class="card not-found-card">
        <h1>404</h1>
        <p>Die angeforderte Seite wurde nicht gefunden.</p>
        <a href="/" class="button">Zur Startseite</a>
    </div>
</body>
</html>
