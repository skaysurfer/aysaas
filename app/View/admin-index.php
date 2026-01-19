<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin-Übersicht</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>
<?php require __DIR__ . '/partials/nav.php'; ?>
<main class="container py-4">
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <h1 class="h4 mb-3">Admin-Übersicht</h1>
            <div class="list-group">
                <?php foreach ($tables as $key => $config) : ?>
                    <a class="list-group-item list-group-item-action d-flex justify-content-between align-items-center"
                       href="/admin/<?php echo htmlspecialchars($key, ENT_QUOTES, 'UTF-8'); ?>">
                        <span><?php echo htmlspecialchars($config['label'], ENT_QUOTES, 'UTF-8'); ?></span>
                        <span class="badge bg-primary rounded-pill">Tabelle</span>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</main>
</body>
</html>
