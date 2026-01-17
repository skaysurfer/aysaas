<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Mandant anlegen</title>
    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>
<?php require __DIR__ . '/partials/nav.php'; ?>
<header>
    <div class="container hero">
        <div>
            <span class="badge">Neuer Mandant</span>
            <h1>Mandant anlegen</h1>
            <p>Erfassen Sie die Stammdaten für einen neuen Mandanten.</p>
            <a href="/dashboard" class="button button-secondary">Zur Übersicht</a>
        </div>
        <div class="card">
            <h2 class="section-title">Mandantendaten</h2>
            <form method="post" action="/register">
                <div class="form-grid">
                    <div>
                        <label for="register-company">Unternehmen</label>
                        <input id="register-company" name="company" type="text" placeholder="Muster GmbH" required>
                    </div>
                    <div>
                        <label for="register-name">Ansprechperson</label>
                        <input id="register-name" name="contact_name" type="text" placeholder="Max Mustermann" required>
                    </div>
                    <div>
                        <label for="register-email">E-Mail</label>
                        <input id="register-email" name="email" type="email" placeholder="admin@muster.de" required>
                    </div>
                    <div>
                        <label for="register-role">Rolle</label>
                        <select id="register-role" name="role">
                            <option>Admin</option>
                            <option>Kunde</option>
                            <option>Dienstleister</option>
                        </select>
                    </div>
                </div>
                <div class="button-group">
                    <button type="submit">Mandant anlegen</button>
                </div>
            </form>
        </div>
    </div>
</header>
</body>
</html>
