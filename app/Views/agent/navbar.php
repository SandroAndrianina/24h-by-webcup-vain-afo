<nav class="agent-navbar">

    <div class="agent-navbar-brand">
        <a href="<?= site_url('agent') ?>">
            Espace agent
        </a>
    </div>

    <div class="agent-navbar-links">

        <a href="<?= site_url('agent') ?>">
            Dashboard
        </a>

        <a href="<?= site_url('agent/requests') ?>">
            Demandes
        </a>

        <a href="<?= site_url('agent/messages') ?>">
            Messages
        </a>

        <a href="<?= site_url('agent/announcements') ?>">
            Annonces
        </a>

        <a href="<?= site_url('agent/announcements/new') ?>">
            Nouvelle annonce
        </a>

        <a href="<?= site_url('logout') ?>">
            Déconnexion
        </a>

    </div>

</nav>

<style>

.agent-navbar {
    width: 100%;
    box-sizing: border-box;
    padding: 16px 24px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 20px;
    background: #ffffff;
    border-bottom: 1px solid #e5e7eb;
}

.agent-navbar-brand a {
    text-decoration: none;
    color: #111827;
    font-size: 20px;
    font-weight: 700;
}

.agent-navbar-links {
    display: flex;
    align-items: center;
    gap: 20px;
    flex-wrap: wrap;
}

.agent-navbar-links a {
    text-decoration: none;
    color: #374151;
    font-size: 14px;
}

.agent-navbar-links a:hover {
    color: #111827;
}

</style>