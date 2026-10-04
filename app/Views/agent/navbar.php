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
    :root {
        --agent-bg: #f3efe9;
        --agent-surface: rgba(255, 255, 255, 0.9);
        --agent-panel: #f8f4f1;
        --agent-ink: #211d1c;
        --agent-muted: #5c5756;
        --agent-line: rgba(33, 29, 28, 0.12);
        --agent-accent: #df9830;
        --agent-accent-soft: rgba(223, 152, 48, 0.14);
        --agent-blue: #3b82f6;
        --agent-green: #10b981;
        --agent-shadow: 0 18px 38px rgba(33, 29, 28, 0.08);
    }

    * { box-sizing: border-box; }

    body {
        margin: 0;
        min-height: 100vh;
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
        background: linear-gradient(180deg, #efe7dc 0%, #f5f2ee 100%);
        color: var(--agent-ink);
    }

    .agent-page-shell {
        max-width: 1200px;
        margin: 36px auto 56px;
        padding: 0 24px;
    }

    .agent-page-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        margin-bottom: 22px;
    }

    .agent-page-header h1 {
        margin: 0;
        font-size: clamp(2rem, 2vw + 1rem, 3rem);
        line-height: 1.1;
    }

    .agent-page-header h1::after {
        display: block;
        width: 68px;
        height: 5px;
        margin-top: 10px;
        border-radius: 999px;
        background: var(--agent-accent);
        content: '';
    }

    .agent-page-header p {
        margin: 0;
        color: var(--agent-muted);
    }

    .agent-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 7px 12px;
        border-radius: 999px;
        background: rgba(223, 152, 48, 0.14);
        color: #684111;
        font-size: 0.72rem;
        font-weight: 700;
        letter-spacing: 0.08em;
        text-transform: uppercase;
    }

    .agent-box {
        background: var(--agent-surface);
        border: 1px solid var(--agent-line);
        border-radius: 24px;
        box-shadow: var(--agent-shadow);
        backdrop-filter: blur(8px);
    }

    .agent-navbar {
        width: 100%;
        box-sizing: border-box;
        padding: 18px 26px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 20px;
        background: rgba(255,255,255,0.86);
        border-bottom: 1px solid var(--agent-line);
        backdrop-filter: blur(6px);
        position: sticky;
        top: 0;
        z-index: 10;
    }

    .agent-navbar-brand a {
        text-decoration: none;
        color: var(--agent-ink);
        font-size: 1.1rem;
        font-weight: 800;
        letter-spacing: 0.02em;
    }

    .agent-navbar-links {
        display: flex;
        align-items: center;
        gap: 18px;
        flex-wrap: wrap;
    }

    .agent-navbar-links a {
        text-decoration: none;
        color: var(--agent-muted);
        font-size: 0.82rem;
        font-weight: 600;
        padding: 8px 12px;
        border-radius: 999px;
        transition: 0.2s ease;
    }

    .agent-navbar-links a:hover {
        color: var(--agent-ink);
        background: rgba(33, 29, 28, 0.05);
    }

    .agent-navbar-links a:nth-child(5) {
        background: var(--agent-accent);
        color: var(--agent-ink);
    }

    .agent-navbar-links a:nth-child(5):hover {
        background: var(--agent-ink);
        color: #fff;
    }

    .agent-navbar-links a:last-child {
        border: 1px solid var(--agent-line);
        color: var(--agent-ink);
    }

    .agent-list {
        display: grid;
        gap: 18px;
        margin-top: 18px;
    }

    .agent-card {
        background: var(--agent-surface);
        border: 1px solid var(--agent-line);
        border-left: 5px solid var(--agent-accent);
        border-radius: 20px;
        box-shadow: var(--agent-shadow);
        padding: 22px 24px;
    }

    .agent-list .agent-card:nth-child(3n + 2) { border-left-color: var(--agent-blue); }
    .agent-list .agent-card:nth-child(3n) { border-left-color: var(--agent-green); }

    .agent-card--alert {
        border-left-color: #c84c3a;
        background: linear-gradient(110deg, rgba(200, 76, 58, 0.08), var(--agent-surface) 38%);
    }

    .agent-card--alert .agent-badge {
        background: #c84c3a;
        color: #fff;
    }

    .agent-card h2,
    .agent-card h3 {
        margin-top: 0;
    }

    .agent-meta {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 10px;
        margin: 0 0 12px;
        color: var(--agent-muted);
        font-size: 0.75rem;
    }

    .status-pill {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 6px 10px;
        border-radius: 999px;
        font-size: 0.7rem;
        font-weight: 700;
        letter-spacing: 0.02em;
        background: rgba(16, 185, 129, 0.12);
        color: #0c7b59;
    }

    .status-pill--new {
        background: rgba(223, 152, 48, 0.14);
        color: #684111;
    }

    .status-pill--progress {
        background: rgba(59, 130, 246, 0.12);
        color: #2459a8;
    }

    .status-pill--done {
        background: rgba(16, 185, 129, 0.12);
        color: #0c7b59;
    }

    .agent-actions {
        display: flex;
        align-items: center;
        gap: 12px;
        flex-wrap: wrap;
        margin-top: 18px;
    }

    .agent-btn,
    .agent-link,
    button,
    input,
    select,
    textarea {
        font: inherit;
    }

    .agent-btn,
    .agent-link,
    button[type="submit"] {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: none;
        border-radius: 12px;
        padding: 11px 18px;
        text-decoration: none;
        font-weight: 700;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        cursor: pointer;
    }

    .agent-btn,
    button[type="submit"] {
        background: var(--agent-ink);
        color: #fff;
        box-shadow: 0 10px 20px rgba(33, 29, 28, 0.18);
    }

    .agent-btn:hover,
    .agent-link:hover,
    button[type="submit"]:hover {
        transform: translateY(-1px);
    }

    .agent-link {
        background: rgba(223, 152, 48, 0.12);
        color: #684111;
    }

    .agent-form {
        display: grid;
        gap: 18px;
        margin-top: 18px;
    }

    .field {
        display: grid;
        gap: 8px;
    }

    .field label {
        font-weight: 700;
        color: var(--agent-ink);
    }

    .field input,
    .field select,
    .field textarea {
        width: 100%;
        border: 1px solid rgba(33, 29, 28, 0.14);
        border-radius: 12px;
        background: rgba(255,255,255,0.8);
        padding: 12px 14px;
        color: var(--agent-ink);
    }

    .field textarea {
        min-height: 150px;
        resize: vertical;
    }

    .field input[type="checkbox"] {
        width: 18px;
        height: 18px;
        accent-color: var(--agent-accent);
        vertical-align: middle;
    }

    .agent-empty {
        background: rgba(255,255,255,0.8);
        border: 1px dashed rgba(33,29,28,0.18);
        border-radius: 18px;
        padding: 28px 20px;
        text-align: center;
        color: var(--agent-muted);
    }

    .agent-alert {
        margin: 0 0 18px;
        padding: 12px 14px;
        border-radius: 12px;
        background: rgba(223, 152, 48, 0.12);
        color: #684111;
        border: 1px solid rgba(223, 152, 48, 0.2);
    }

    .agent-info {
        margin: 0 0 18px;
        padding: 14px 16px;
        border-radius: 14px;
        background: rgba(59, 130, 246, 0.08);
        color: #234f90;
        border: 1px solid rgba(59, 130, 246, 0.12);
    }

    .agent-card p + p { margin-top: 10px; }

    .agent-stack {
        display: grid;
        gap: 18px;
    }

    @media (max-width: 700px) {
        .agent-page-shell {
            padding: 0 16px;
        }

        .agent-navbar {
            padding: 16px 18px;
            flex-direction: column;
            align-items: flex-start;
        }

        .agent-navbar-links {
            gap: 8px;
        }

        .agent-page-header {
            flex-direction: column;
            align-items: flex-start;
        }

        .agent-card {
            padding: 18px 16px;
        }
    }
</style>