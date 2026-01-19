<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo htmlspecialchars($config['label'], ENT_QUOTES, 'UTF-8'); ?> bearbeiten</title>
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
                    <h1 class="h4 mb-1"><?php echo htmlspecialchars($config['label'], ENT_QUOTES, 'UTF-8'); ?> bearbeiten</h1>
                    <p class="text-muted mb-0">Datensatz ID: <?php echo (int) $record[$config['primary']]; ?></p>
                </div>
                <a class="btn btn-outline-secondary" href="/admin/<?php echo $table; ?>">Zurück zur Übersicht</a>
            </div>
            <?php if (!empty($success)) : ?>
                <div class="alert alert-success"><?php echo htmlspecialchars((string) $success, ENT_QUOTES, 'UTF-8'); ?></div>
            <?php endif; ?>
            <form method="post" action="/admin/<?php echo $table; ?>/edit/<?php echo (int) $record[$config['primary']]; ?>" class="row g-3">
                <?php foreach ($config['editable'] as $field) : ?>
                    <div class="col-md-6">
                        <label class="form-label" for="field-<?php echo htmlspecialchars($field, ENT_QUOTES, 'UTF-8'); ?>">
                            <?php echo htmlspecialchars($field, ENT_QUOTES, 'UTF-8'); ?>
                        </label>
                        <input
                            id="field-<?php echo htmlspecialchars($field, ENT_QUOTES, 'UTF-8'); ?>"
                            name="<?php echo htmlspecialchars($field, ENT_QUOTES, 'UTF-8'); ?>"
                            class="form-control"
                            value="<?php echo htmlspecialchars((string) ($record[$field] ?? ''), ENT_QUOTES, 'UTF-8'); ?>"
                        >
                    </div>
                <?php endforeach; ?>
                <div class="col-12 d-flex gap-2">
                    <button class="btn btn-primary" type="submit">Speichern</button>
                    <a class="btn btn-outline-danger" href="/admin/<?php echo $table; ?>/delete/<?php echo (int) $record[$config['primary']]; ?>">
                        Löschen
                    </a>
                </div>
            </form>
        </div>
    </div>
</main>
</body>
</html>
