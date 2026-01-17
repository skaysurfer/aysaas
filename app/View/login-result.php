<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login Ergebnis</title>
    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>
<?php require __DIR__ . '/partials/nav.php'; ?>
<main class="container">
    <div class="card">
        <h1>Login</h1>
        <p><?php echo $message; ?></p>
        <div class="button-group">
            <a href="/" class="button button-secondary">Zur Startseite</a>
            <a href="/dashboard" class="button">Zum Dashboard</a>
        </div>
    </div>
</main>
</body>
</html>
