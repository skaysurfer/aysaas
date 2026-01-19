<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Mandant bearbeiten</title>
    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>
<?php require __DIR__ . '/partials/nav.php'; ?>
<header>
    <div class="container hero">
        <div>
            <span class="badge">Mandant bearbeiten</span>
            <h1><?php echo htmlspecialchars((string) $tenant['name'], ENT_QUOTES, 'UTF-8'); ?></h1>
            <p>Bearbeiten Sie Stammdaten und Status des Mandanten.</p>
            <a href="/tenants/<?php echo (int) $tenant['id']; ?>" class="button button-secondary">Zur Detailseite</a>
        </div>
        <div class="card">
            <h2 class="section-title">Mandantendaten</h2>
            <?php if (!empty($errors)) : ?>
                <div class="alert alert-error">
                    <?php foreach ($errors as $error) : ?>
                        <p><?php echo htmlspecialchars((string) $error, ENT_QUOTES, 'UTF-8'); ?></p>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
            <?php if (!empty($success)) : ?>
                <div class="alert alert-success">
                    <p><?php echo htmlspecialchars((string) $success, ENT_QUOTES, 'UTF-8'); ?></p>
                </div>
            <?php endif; ?>
            <form method="post" action="/tenants/<?php echo (int) $tenant['id']; ?>/edit">
                <div class="form-grid">
                    <div>
                        <label for="tenant-name">Name</label>
                        <input id="tenant-name" name="name" type="text" value="<?php echo htmlspecialchars((string) $tenant['name'], ENT_QUOTES, 'UTF-8'); ?>" required>
                    </div>
                    <div>
                        <label for="tenant-slug">Slug</label>
                        <input id="tenant-slug" name="slug" type="text" value="<?php echo htmlspecialchars((string) $tenant['slug'], ENT_QUOTES, 'UTF-8'); ?>" required>
                    </div>
                    <div>
                        <label for="tenant-status">Status</label>
                        <select id="tenant-status" name="status" required>
                            <?php foreach (['active' => 'Aktiv', 'trial' => 'Trial', 'inactive' => 'Inaktiv'] as $value => $label) : ?>
                                <option value="<?php echo $value; ?>" <?php echo $tenant['status'] === $value ? 'selected' : ''; ?>>
                                    <?php echo $label; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div>
                        <label for="tenant-plan">Plan</label>
                        <input id="tenant-plan" name="plan" type="text" value="<?php echo htmlspecialchars((string) $tenant['plan'], ENT_QUOTES, 'UTF-8'); ?>" required>
                    </div>
                </div>
                <div class="button-group">
                    <button type="submit">Änderungen speichern</button>
                    <a href="/dashboard" class="button button-secondary">Zur Übersicht</a>
                </div>
            </form>
        </div>
    </div>
</header>
</body>
</html>
