<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Mandantendashboard</title>
    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>
<?php require __DIR__ . '/partials/nav.php'; ?>
<header>
    <div class="container hero">
        <div>
            <span class="badge">Mandantendashboard</span>
            <h1>Willkommen im Demo-Dashboard</h1>
            <p>Hier können Admins Anwendungen aktivieren und die Abrechnung einsehen.</p>
            <a href="/" class="button button-secondary">Zur Startseite</a>
        </div>
        <div class="card">
            <h2 class="section-title">Aktive Applikationen</h2>
            <ul class="feature-list">
                <?php foreach ($apps as $index => $app) : ?>
                    <li>
                        <span><?php echo $index + 1; ?></span>
                        <div><?php echo htmlspecialchars($app, ENT_QUOTES, 'UTF-8'); ?></div>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</header>

<main class="container">
    <div class="card">
        <div class="card-header">
            <div>
                <h2 class="section-title">Mandantenübersicht</h2>
                <p class="subtle">Verwalten Sie Ihre Mandanten, Pläne und Status.</p>
            </div>
            <a href="/register" class="button">Neuen Mandanten anlegen</a>
        </div>
        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Mandant</th>
                        <th>Status</th>
                        <th>Plan</th>
                        <th>Aktionen</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($tenants)) : ?>
                        <tr>
                            <td colspan="5">Noch keine Mandanten vorhanden.</td>
                        </tr>
                    <?php else : ?>
                        <?php foreach ($tenants as $tenant) : ?>
                            <tr>
                                <td><?php echo (int) $tenant['id']; ?></td>
                                <td><?php echo htmlspecialchars((string) $tenant['name'], ENT_QUOTES, 'UTF-8'); ?></td>
                                <td><?php echo htmlspecialchars((string) $tenant['status'], ENT_QUOTES, 'UTF-8'); ?></td>
                                <td><?php echo htmlspecialchars((string) $tenant['plan'], ENT_QUOTES, 'UTF-8'); ?></td>
                                <td class="table-actions">
                                    <a class="button button-secondary" href="/tenants/<?php echo (int) $tenant['id']; ?>">Details</a>
                                    <a class="button" href="/tenants/<?php echo (int) $tenant['id']; ?>/edit">Bearbeiten</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</main>

<footer>
    <div class="container">SaaS Basisframework &middot; Demo-Dashboard</div>
</footer>
</body>
</html>
