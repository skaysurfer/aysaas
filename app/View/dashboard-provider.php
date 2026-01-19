<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dienstleister-Dashboard</title>
    <link rel="stylesheet" href="/assets/css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body>
<?php require __DIR__ . '/partials/nav.php'; ?>
<main class="container py-4">
    <div class="card border-0 shadow-sm">
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
</main>
</body>
</html>
