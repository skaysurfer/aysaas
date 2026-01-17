<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SaaS Basisframework</title>
    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>
<header>
    <div class="container hero">
        <div>
            <span class="badge">🚀 Basisframework für SaaS</span>
            <h1>Alles, was Sie für einen mandantenfähigen SaaS-Start benötigen.</h1>
            <p>
                Starten Sie mit einer soliden Datenbasis, Rollenlogik und einem modularen App-Bereich.
                Admins wählen Apps pro Mandant, Nutzer kommunizieren per Nachrichtensystem und die
                Abrechnung basiert auf Mandant, App und Nutzeranzahl.
            </p>
            <a class="button" href="/dashboard">Zum Mandantendashboard</a>
        </div>
        <div class="card">
            <h2 class="section-title">Login</h2>
            <form method="post" action="/login">
                <div class="form-grid">
                    <div>
                        <label for="login-email">E-Mail</label>
                        <input id="login-email" name="email" type="email" placeholder="name@firma.de" required>
                    </div>
                    <div>
                        <label for="login-password">Passwort</label>
                        <input id="login-password" name="password" type="password" placeholder="••••••••" required>
                    </div>
                </div>
                <div class="button-group">
                    <button type="submit">Einloggen</button>
                    <button type="button" class="button-secondary">Passwort vergessen</button>
                </div>
            </form>
            <hr class="divider">
            <h2 class="section-title">Registrieren</h2>
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
                    <button type="submit">Account anlegen</button>
                </div>
            </form>
        </div>
    </div>
</header>

<main class="container">
    <div class="card">
        <h2 class="section-title">Kernbausteine der Plattform</h2>
        <ul class="feature-list">
            <?php foreach ($features as $index => $feature) : ?>
                <li>
                    <span><?php echo $index + 1; ?></span>
                    <div><?php echo htmlspecialchars($feature, ENT_QUOTES, 'UTF-8'); ?></div>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</main>

<footer>
    <div class="container">SaaS Basisframework &middot; Demo-Startseite</div>
</footer>
</body>
</html>
