<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kunden-Dashboard</title>
    <link rel="stylesheet" href="/assets/css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body>
<?php require __DIR__ . '/partials/nav.php'; ?>
<main class="container py-4">
    <div class="row g-4">
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <h2 class="h5 mb-3">Adressbuch</h2>
                    <div class="table-responsive">
                        <table class="table table-striped align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Name</th>
                                    <th>Firma</th>
                                    <th>E-Mail</th>
                                    <th>Telefon</th>
                                    <th>Ort</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($entries)) : ?>
                                    <tr>
                                        <td colspan="5" class="text-muted">Keine Kontakte vorhanden.</td>
                                    </tr>
                                <?php else : ?>
                                    <?php foreach ($entries as $entry) : ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars((string) ($entry['first_name'] . ' ' . $entry['last_name']), ENT_QUOTES, 'UTF-8'); ?></td>
                                            <td><?php echo htmlspecialchars((string) $entry['company'], ENT_QUOTES, 'UTF-8'); ?></td>
                                            <td><?php echo htmlspecialchars((string) $entry['email'], ENT_QUOTES, 'UTF-8'); ?></td>
                                            <td><?php echo htmlspecialchars((string) $entry['phone'], ENT_QUOTES, 'UTF-8'); ?></td>
                                            <td><?php echo htmlspecialchars((string) $entry['city'], ENT_QUOTES, 'UTF-8'); ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-5">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <h2 class="h5 mb-3">Nachrichten</h2>
                    <ul class="list-group">
                        <?php if (empty($messages)) : ?>
                            <li class="list-group-item text-muted">Keine Nachrichten vorhanden.</li>
                        <?php else : ?>
                            <?php foreach ($messages as $message) : ?>
                                <li class="list-group-item">
                                    <div class="fw-semibold"><?php echo htmlspecialchars((string) $message['subject'], ENT_QUOTES, 'UTF-8'); ?></div>
                                    <div class="small text-muted">Von <?php echo htmlspecialchars((string) $message['sender_name'], ENT_QUOTES, 'UTF-8'); ?> · <?php echo htmlspecialchars((string) $message['created_at'], ENT_QUOTES, 'UTF-8'); ?></div>
                                </li>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</main>
</body>
</html>
