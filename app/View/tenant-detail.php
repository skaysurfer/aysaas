<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Mandantendetails</title>
    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>
<?php require __DIR__ . '/partials/nav.php'; ?>
<header>
    <div class="container hero">
        <div>
            <span class="badge">Mandantendetails</span>
            <h1><?php echo htmlspecialchars((string) $tenant['name'], ENT_QUOTES, 'UTF-8'); ?></h1>
            <p>Plan: <?php echo htmlspecialchars((string) $tenant['plan'], ENT_QUOTES, 'UTF-8'); ?></p>
            <a href="/dashboard" class="button button-secondary">Zur Übersicht</a>
        </div>
        <div class="card">
            <h2 class="section-title">Status &amp; Informationen</h2>
            <ul class="feature-list">
                <li>
                    <span>1</span>
                    <div>Status: <?php echo htmlspecialchars((string) $tenant['status'], ENT_QUOTES, 'UTF-8'); ?></div>
                </li>
                <li>
                    <span>2</span>
                    <div>Slug: <?php echo htmlspecialchars((string) $tenant['slug'], ENT_QUOTES, 'UTF-8'); ?></div>
                </li>
                <li>
                    <span>3</span>
                    <div>Erstellt am: <?php echo htmlspecialchars((string) $tenant['created_at'], ENT_QUOTES, 'UTF-8'); ?></div>
                </li>
            </ul>
        </div>
    </div>
</header>
</body>
</html>
