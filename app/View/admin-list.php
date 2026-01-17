<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo htmlspecialchars($config['label'], ENT_QUOTES, 'UTF-8'); ?></title>
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
                    <h1 class="h4 mb-1"><?php echo htmlspecialchars($config['label'], ENT_QUOTES, 'UTF-8'); ?></h1>
                    <p class="text-muted mb-0">Übersicht aller Datensätze</p>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-striped align-middle">
                    <thead class="table-light">
                        <tr>
                            <?php foreach ($config['columns'] as $column) : ?>
                                <th><?php echo htmlspecialchars($column, ENT_QUOTES, 'UTF-8'); ?></th>
                            <?php endforeach; ?>
                            <th>Aktionen</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($rows)) : ?>
                            <tr>
                                <td colspan="<?php echo count($config['columns']) + 1; ?>" class="text-muted">
                                    Keine Daten vorhanden.
                                </td>
                            </tr>
                        <?php else : ?>
                            <?php foreach ($rows as $row) : ?>
                                <tr>
                                    <?php foreach ($config['columns'] as $column) : ?>
                                        <td><?php echo htmlspecialchars((string) ($row[$column] ?? ''), ENT_QUOTES, 'UTF-8'); ?></td>
                                    <?php endforeach; ?>
                                    <td class="d-flex gap-2">
                                        <a class="btn btn-outline-primary btn-sm" href="/admin/<?php echo $table; ?>/edit/<?php echo (int) $row[$config['primary']]; ?>">
                                            Bearbeiten
                                        </a>
                                        <a class="btn btn-outline-danger btn-sm" href="/admin/<?php echo $table; ?>/delete/<?php echo (int) $row[$config['primary']]; ?>">
                                            Löschen
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>
</body>
</html>
