<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Mandanten-Dashboard</title>
    <link rel="stylesheet" href="/assets/css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body>
<?php require __DIR__ . '/partials/nav.php'; ?>
<main class="container py-4">
    <div class="row g-4">
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <h2 class="h5 mb-3">Aktive Applikationen</h2>
                    <ul class="list-group">
                        <?php if (empty($apps)) : ?>
                            <li class="list-group-item text-muted">Keine Applikationen aktiv.</li>
                        <?php else : ?>
                            <?php foreach ($apps as $app) : ?>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span><?php echo htmlspecialchars((string) $app['name'], ENT_QUOTES, 'UTF-8'); ?></span>
                                    <span class="badge bg-<?php echo $app['enabled'] ? 'success' : 'secondary'; ?>">
                                        <?php echo $app['enabled'] ? 'Aktiv' : 'Inaktiv'; ?>
                                    </span>
                                </li>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <h2 class="h5 mb-3">Benutzer im Mandanten</h2>
                    <div class="table-responsive">
                        <table class="table table-striped align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Name</th>
                                    <th>E-Mail</th>
                                    <th>Rolle</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($users)) : ?>
                                    <tr>
                                        <td colspan="4" class="text-muted">Keine Benutzer vorhanden.</td>
                                    </tr>
                                <?php else : ?>
                                    <?php foreach ($users as $user) : ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars((string) $user['display_name'], ENT_QUOTES, 'UTF-8'); ?></td>
                                            <td><?php echo htmlspecialchars((string) $user['email'], ENT_QUOTES, 'UTF-8'); ?></td>
                                            <td><?php echo htmlspecialchars((string) $user['role_name'], ENT_QUOTES, 'UTF-8'); ?></td>
                                            <td><?php echo htmlspecialchars((string) $user['status'], ENT_QUOTES, 'UTF-8'); ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
</body>
</html>
