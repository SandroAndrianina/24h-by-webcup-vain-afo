<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Dashboard Agent</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 30px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .stats {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 15px;
            margin-top: 30px;
        }

        .card {
            border: 1px solid #ddd;
            padding: 20px;
            border-radius: 10px;
        }

        .card h3 {
            margin-top: 0;
        }

        .number {
            font-size: 30px;
            font-weight: bold;
        }

        .chart-container {
            margin-top: 40px;
            border: 1px solid #ddd;
            padding: 20px;
            border-radius: 10px;
        }

        .chart {
            width: 100%;
            height: 250px;
        }

        .chart-line {
            fill: none;
            stroke-width: 3;
        }

        .chart-labels {
            display: flex;
            justify-content: space-between;
            margin-top: 10px;
        }

        .legend {
            display: flex;
            gap: 20px;
            margin-top: 15px;
        }

        .legend span {
            font-size: 14px;
        }

        .navigation {
            margin-top: 30px;
        }
    </style>
</head>

<body>

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