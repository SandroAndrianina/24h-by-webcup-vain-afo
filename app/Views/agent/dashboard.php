<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Dashboard Agent</title>

    <style>
        :root {
            --paper: #f3efe9;
            --panel: rgba(255, 255, 255, 0.88);
            --ink: #211d1c;
            --muted: #5c5756;
            --line: rgba(33, 29, 28, 0.12);
            --accent: #df9830;
            --accent-ink: #684111;
            --blue: #3b82f6;
            --green: #10b981;
            --shadow: 0 16px 36px rgba(33, 29, 28, 0.08);
        }

        * { box-sizing: border-box; }

        body {
            margin: 0;
            min-height: 100vh;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background: linear-gradient(180deg, #efe7dc 0%, #f5f2ee 100%);
            color: var(--ink);
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 20px;
            max-width: 1280px;
            margin: 0 auto;
            padding: 30px 32px 12px;
        }

        .header h1 {
            margin: 0 0 8px;
            font-size: 2.6rem;
            line-height: 1.1;
        }

        .header p {
            margin: 0;
            color: var(--muted);
            font-size: 0.95rem;
        }

        .stats {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 18px;
            max-width: 1280px;
            margin: 20px auto 0;
            padding: 0 32px;
        }

        .card {
            background: var(--panel);
            border: 1px solid var(--line);
            border-radius: 18px;
            padding: 22px 20px 18px;
            box-shadow: var(--shadow);
            backdrop-filter: blur(6px);
        }

        .card:nth-child(1) { background: #d9d5cc; }
        .card:nth-child(2) { background: #df9830; }
        .card:nth-child(3) { background: #dce7f2; }
        .card:nth-child(4) { background: #dce8df; }

        .card:nth-child(2) h3,
        .card:nth-child(2) p { color: #684111; }

        .card h3 {
            margin: 0 0 14px;
            font-size: 0.76rem;
            font-weight: 700;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: var(--muted);
        }

        .number {
            font-size: 2.5rem;
            font-weight: 800;
            line-height: 1.1;
            margin-bottom: 8px;
        }

        .card p {
            margin: 0;
            color: var(--muted);
            font-size: 0.8rem;
        }

        .chart-container {
            max-width: 1280px;
            margin: 26px auto 0;
            padding: 24px 24px 18px;
            border: 1px solid var(--line);
            border-radius: 22px;
            background: #d9d5cc;
            box-shadow: var(--shadow);
        }

        .chart-container h2 {
            margin: 0 0 14px;
            font-size: 1.55rem;
        }

        .chart-container h2::before {
            display: inline-block;
            width: 10px;
            height: 10px;
            margin: 0 10px 2px 0;
            border-radius: 50%;
            background: var(--accent);
            content: '';
        }

        .chart {
            display: block;
            width: 100%;
            height: 260px;
            background: linear-gradient(180deg, rgba(223, 152, 48, 0.12), rgba(59, 130, 246, 0.05));
            border-radius: 12px;
            border: 1px solid rgba(33, 29, 28, 0.05);
        }

        .chart-line {
            fill: none;
            stroke-width: 3;
            stroke-linecap: round;
            stroke-linejoin: round;
        }

        .chart-labels {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(60px, 1fr));
            gap: 10px;
            margin-top: 12px;
            color: var(--muted);
            font-size: 0.72rem;
            text-align: center;
        }

        .legend {
            display: flex;
            flex-wrap: wrap;
            gap: 18px;
            margin-top: 18px;
            padding-top: 10px;
            border-top: 1px solid var(--line);
        }

        .legend span {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-size: 0.8rem;
            color: var(--muted);
        }

        .legend span::before {
            content: '';
            display: inline-block;
            width: 12px;
            height: 3px;
            border-radius: 999px;
            background: currentColor;
        }

        .legend span:nth-child(1) { color: #111827; }
        .legend span:nth-child(2) { color: var(--accent); }
        .legend span:nth-child(3) { color: var(--blue); }
        .legend span:nth-child(4) { color: var(--green); }

        .navigation {
            max-width: 1280px;
            margin: 24px auto 40px;
            padding: 0 32px;
        }

        .navigation a {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 42px;
            padding: 0 18px;
            border-radius: 12px;
            background: var(--ink);
            color: #fff;
            text-decoration: none;
            font-weight: 700;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            box-shadow: 0 10px 20px rgba(33, 29, 28, 0.2);
        }

        .navigation a:hover {
            transform: translateY(-1px);
            box-shadow: 0 14px 24px rgba(33, 29, 28, 0.24);
        }

        @media (max-width: 900px) {
            .stats {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 560px) {
            .header,
            .stats,
            .navigation {
                padding-left: 18px;
                padding-right: 18px;
            }

            .stats {
                grid-template-columns: 1fr;
            }

            .chart-container {
                padding: 18px 14px 14px;
            }
        }
    </style>
</head>

<body>

    <?= $this->include('agent/navbar') ?>

    <div class="header">

        <div>
            <h1>Dashboard Agent</h1>

            <p>
                Agent : <?= esc($agent['name']) ?>
            </p>

            <p>
                Service : <?= esc($service['name']) ?>
            </p>
        </div>

    </div>

    <div class="stats">

        <div class="card">
            <h3>Total</h3>
            <div class="number">
                <?= $stats['total'] ?>
            </div>
            <p>Toutes les demandes</p>
        </div>

        <div class="card">
            <h3>Nouvelles</h3>
            <div class="number">
                <?= $stats['nouveau'] ?>
            </div>
            <p>Pas encore traitées</p>
        </div>

        <div class="card">
            <h3>En cours</h3>
            <div class="number">
                <?= $stats['en_cours'] ?>
            </div>
            <p>Demandes en traitement</p>
        </div>

        <div class="card">
            <h3>Résolues</h3>
            <div class="number">
                <?= $stats['resolu'] ?>
            </div>
            <p>Demandes terminées</p>
        </div>

    </div>

    <div class="chart-container">

        <h2>Évolution des demandes</h2>

        <svg
            class="chart"
            viewBox="0 0 700 250"
            preserveAspectRatio="none"
        >

            <?php
                $max = 1;

                foreach ($chart as $day) {
                    $max = max(
                        $max,
                        $day['total'],
                        $day['nouveau'],
                        $day['en_cours'],
                        $day['resolu']
                    );
                }

                $width = 700;
                $height = 220;

                $pointsTotal = [];
                $pointsNouveau = [];
                $pointsEnCours = [];
                $pointsResolu = [];

                foreach ($chart as $index => $day) {

                    $x = count($chart) > 1
                        ? ($index / (count($chart) - 1)) * $width
                        : 0;

                    $yTotal = $height - ($day['total'] / $max) * $height;
                    $yNouveau = $height - ($day['nouveau'] / $max) * $height;
                    $yEnCours = $height - ($day['en_cours'] / $max) * $height;
                    $yResolu = $height - ($day['resolu'] / $max) * $height;

                    $pointsTotal[] = $x . ',' . $yTotal;
                    $pointsNouveau[] = $x . ',' . $yNouveau;
                    $pointsEnCours[] = $x . ',' . $yEnCours;
                    $pointsResolu[] = $x . ',' . $yResolu;
                }
            ?>

            <polyline
                points="<?= implode(' ', $pointsTotal) ?>"
                class="chart-line"
                stroke="#111827"
            />

            <polyline
                points="<?= implode(' ', $pointsNouveau) ?>"
                class="chart-line"
                stroke="#df9830"
            />

            <polyline
                points="<?= implode(' ', $pointsEnCours) ?>"
                class="chart-line"
                stroke="#3b82f6"
            />

            <polyline
                points="<?= implode(' ', $pointsResolu) ?>"
                class="chart-line"
                stroke="#10b981"
            />

        </svg>

        <div class="chart-labels">

            <?php foreach ($chart as $day): ?>

                <span>
                    <?= esc($day['date']) ?>
                </span>

            <?php endforeach; ?>

        </div>

        <div class="legend">

            <span>
                Total
            </span>

            <span>
                Nouvelles
            </span>

            <span>
                En cours
            </span>

            <span>
                Résolues
            </span>

        </div>

    </div>

    <div class="navigation">

        <a href="<?= site_url('agent/requests') ?>">
            Voir les demandes
        </a>

    </div>

</body>
</html>