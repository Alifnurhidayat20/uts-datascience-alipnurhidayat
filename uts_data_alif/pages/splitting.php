<?php
require '../includes/layout.php';

function train_test_split(array $data, float $test_size = 0.2): array {
    $n = count($data);
    $nTest = (int) round($n * $test_size);
    $nTrain = $n - $nTest;
    $indices = range(0, $n - 1);
    
    for ($i = $n - 1; $i > 0; $i--) {
        $j = random_int(0, $i);
        [$indices[$i], $indices[$j]] = [$indices[$j], $indices[$i]];
    }
    return [
        'train' => array_map(fn($i) => $data[$i], array_slice($indices, 0, $nTrain)),
        'test'  => array_map(fn($i) => $data[$i], array_slice($indices, $nTrain, $nTest)),
    ];
}

$dataset = [];
for ($i = 1; $i <= 50; $i++) $dataset[] = ['id' => $i, 'x' => rand(10, 90), 'y' => rand(100, 500), 'label' => rand(0, 1)];
$result = train_test_split($dataset, 0.2);
?>

<div class="hero-card">
    <div>
        <h2>Pembagian Dataset (Train-Test Split)</h2>
        <p>Membagi dataset secara acak (*Shuffle*) menjadi 80% Data Latih dan 20% Data Uji</p>
    </div>
    <div class="badge-active">Rasio Split: 80 : 20</div>
</div>

<div class="panel" style="margin-bottom: 24px; padding: 24px;">
    <div style="display: flex; justify-content: space-between; margin-bottom: 12px; font-weight: 600;">
        <span style="color: #059669;">Data Latih: <?= count($result['train']) ?> sampel (80%)</span>
        <span style="color: #d97706;">Data Uji: <?= count($result['test']) ?> sampel (20%)</span>
    </div>
    <div class="split-container">
        <div class="split-train" style="width: 80%;">Train</div>
        <div class="split-test" style="width: 20%;">Test</div>
    </div>
</div>

<div class="data-grid-equal">
    <div class="panel" style="border-top: 4px solid #10b981;">
        <div class="panel-header">
            <h3>Data Latih (Train Set - Top 5)</h3>
            <span class="badge badge-ok"><?= count($result['train']) ?> Rows</span>
        </div>
        <table>
            <thead><tr><th>ID</th><th>FITUR X</th><th>FITUR Y</th><th>LABEL TARGET</th></tr></thead>
            <tbody>
                <?php foreach (array_slice($result['train'], 0, 5) as $r): ?>
                <tr>
                    <td class="bold">ID-<?= str_pad($r['id'], 3, '0', STR_PAD_LEFT) ?></td>
                    <td><?= $r['x'] ?></td>
                    <td><?= $r['y'] ?></td>
                    <td><span class="badge <?= $r['label'] == 1 ? 'badge-ok' : 'badge-warn' ?>"><?= $r['label'] == 1 ? 'Positif' : 'Negatif' ?></span></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div class="panel" style="border-top: 4px solid #f59e0b;">
        <div class="panel-header">
            <h3>Data Uji (Test Set - Top 5)</h3>
            <span class="badge badge-warn"><?= count($result['test']) ?> Rows</span>
        </div>
        <table>
            <thead><tr><th>ID</th><th>FITUR X</th><th>FITUR Y</th><th>LABEL TARGET</th></tr></thead>
            <tbody>
                <?php foreach (array_slice($result['test'], 0, 5) as $r): ?>
                <tr>
                    <td class="bold">ID-<?= str_pad($r['id'], 3, '0', STR_PAD_LEFT) ?></td>
                    <td><?= $r['x'] ?></td>
                    <td><?= $r['y'] ?></td>
                    <td><span class="badge <?= $r['label'] == 1 ? 'badge-ok' : 'badge-warn' ?>"><?= $r['label'] == 1 ? 'Positif' : 'Negatif' ?></span></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

</main></body></html>