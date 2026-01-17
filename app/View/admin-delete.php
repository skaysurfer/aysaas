<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo htmlspecialchars($config['label'], ENT_QUOTES, 'UTF-8'); ?> löschen</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>
<?php require __DIR__ . '/partials/nav.php'; ?>
<main class="container py-4">
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <div class="d-flex flex-wrap align-items-center justify-content-between mb-3 gap-3">
                <div>
                    <h1 class="h4 mb-1"><?php echo htmlspecialchars($config['label'], ENT_QUOTES, 'UTF-8'); ?> löschen</h1>
                    <p class="text-muted mb-0">Sicherheitsabfrage vor dem Löschen</p>
                </div>
                <a class="btn btn-outline-secondary" href="/admin/<?php echo $table; ?>">Zurück zur Übersicht</a>
            </div>
            <?php if (!empty($success)) : ?>
                <div class="alert alert-success"><?php echo htmlspecialchars((string) $success, ENT_QUOTES, 'UTF-8'); ?></div>
                <a class="btn btn-primary" href="/admin/<?php echo $table; ?>">Zur Übersicht</a>
            <?php elseif ($record !== null) : ?>
                <div class="alert alert-warning">
                    Möchten Sie den Datensatz <strong><?php echo htmlspecialchars((string) $record[$config['primary']], ENT_QUOTES, 'UTF-8'); ?></strong> wirklich löschen?
                </div>
                <form method="post" action="/admin/<?php echo $table; ?>/delete/<?php echo (int) $record[$config['primary']]; ?>" class="d-flex gap-2">
                    <button class="btn btn-danger" type="submit">Ja, löschen</button>
                    <a class="btn btn-outline-secondary" href="/admin/<?php echo $table; ?>/edit/<?php echo (int) $record[$config['primary']]; ?>">
                        Abbrechen
                    </a>
                </form>
            <?php endif; ?>
        </div>
    </div>
</main>
</body>
</html>
