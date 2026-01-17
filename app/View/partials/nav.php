<nav class="top-nav">
    <div class="container nav-inner">
        <a class="nav-brand" href="/dashboard">aySaaS</a>
        <?php
        $currentUser = $_SESSION['user'] ?? null;
        $role = $currentUser['role'] ?? null;
        $displayName = $currentUser['display_name'] ?? 'Gast';
        ?>
        <div class="nav-links">
            <a href="/dashboard">Dashboard</a>
            <?php if ($role === 'admin') : ?>
                <a href="/admin">Admin-Übersicht</a>
                <a href="/admin/applications">Applikationen</a>
                <a href="/admin/users">Benutzer</a>
                <a href="/admin/invoices">Abrechnung</a>
            <?php elseif ($role === 'mandant-admin') : ?>
                <a href="/admin/applications">Applikationen</a>
                <a href="/admin/users">Benutzer</a>
                <a href="/admin/messages">Nachrichten</a>
            <?php elseif ($role === 'kunde') : ?>
                <a href="/admin/addressbook_entries">Adressbuch</a>
                <a href="/admin/messages">Nachrichten</a>
            <?php elseif ($role === 'dienstleister') : ?>
                <a href="/admin/messages">Nachrichten</a>
            <?php endif; ?>
        </div>
        <?php if ($currentUser !== null) : ?>
            <div class="nav-user" data-user-menu>
                <button class="nav-user-trigger" type="button" aria-haspopup="true" aria-expanded="false">
                    <?php echo htmlspecialchars($displayName, ENT_QUOTES, 'UTF-8'); ?> ▾
                </button>
                <div class="nav-user-menu" role="menu">
                    <a href="/profile">Profil</a>
                    <a href="/settings">Einstellungen</a>
                    <a href="/logout">Logout</a>
                </div>
            </div>
        <?php endif; ?>
    </div>
</nav>
<script>
    (function () {
        const menu = document.querySelector('[data-user-menu]');
        if (!menu) {
            return;
        }
        const trigger = menu.querySelector('.nav-user-trigger');
        const dropdown = menu.querySelector('.nav-user-menu');
        if (!trigger || !dropdown) {
            return;
        }
        const toggleMenu = (event) => {
            event.stopPropagation();
            const isOpen = dropdown.classList.toggle('is-open');
            trigger.setAttribute('aria-expanded', String(isOpen));
        };
        trigger.addEventListener('click', toggleMenu);
        document.addEventListener('click', () => {
            if (dropdown.classList.contains('is-open')) {
                dropdown.classList.remove('is-open');
                trigger.setAttribute('aria-expanded', 'false');
            }
        });
    })();
</script>
