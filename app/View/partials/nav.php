<nav class="top-nav">
    <div class="container nav-inner">
        <a class="nav-brand" href="/dashboard">aySaaS</a>
        <div class="nav-links">
            <a href="/dashboard">Admin-Dashboard</a>
            <a href="/admin/applications">Applikationen</a>
            <a href="/admin/users">Benutzer</a>
            <a href="/admin/invoices">Abrechnung</a>
            <a href="/admin">Admin-Übersicht</a>
        </div>
        <div class="nav-user" data-user-menu>
            <button class="nav-user-trigger" type="button" aria-haspopup="true" aria-expanded="false">
                Anna Admin ▾
            </button>
            <div class="nav-user-menu" role="menu">
                <a href="/profile">Profil</a>
                <a href="/settings">Einstellungen</a>
                <a href="/logout">Logout</a>
            </div>
        </div>
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
