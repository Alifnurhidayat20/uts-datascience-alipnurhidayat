<?php
require '../includes/layout.php';

$data = [80, null, 75, "", 90, null, 65, 85, 100];
$total_sampel = count($data);
$nilai_kosong = 0;

$validValues = [];
foreach ($data as $v) {
    if ($v !== null && $v !== '' && is_numeric($v)) $validValues[] = $v;
    else $nilai_kosong++;
}

$mean = array_sum($validValues) / count($validValues);
$min = min($validValues); 
$max = max($validValues);
$range = $max - $min;

$imputed = [];
foreach ($data as $v) {
    $isKosong = ($v === null || $v === '');
    $val = $isKosong ? $mean : (float)$v;
    $norm = $range == 0 ? 0 : ($val - $min) / $range;
    
    $imputed[] = [
        'asli' => $v, 'is_kosong' => $isKosong, 'val' => $val, 'norm' => $norm
    ];
}
?>

<div class="hero-card">
    <div>
        <h2>Pembersihan Data & Normalisasi Min-Max</h2>
        <p>Imputasi nilai kosong menggunakan rata-rata (Mean), disusul transformasi skala [0, 1]</p>
    </div>
    <div class="badge-active">Metode: Min-Max Scaling</div>
</div>

<div class="stats-grid">
    <div class="stat-card blue">
        <div class="stat-label">TOTAL SAMPEL</div>
        <div class="stat-value"><?= $total_sampel ?></div>
    </div>
    <div class="stat-card orange">
        <div class="stat-label">NILAI KOSONG</div>
        <div class="stat-value" style="color: #d97706;"><?= $nilai_kosong ?></div>
    </div>
    <div class="stat-card blue">
        <div class="stat-label">MEAN (RATA-RATA)</div>
        <div class="stat-value" style="color: #2563eb;"><?= number_format($mean, 2, ',', '.') ?></div>
    </div>
    <div class="stat-card green">
        <div class="stat-label">RENTANG (MIN - MAX)</div>
        <div class="stat-value" style="color: #059669;"><?= $min ?> - <?= $max ?></div>
    </div>
</div>

<div class="panel">
    <div class="panel-header"><h3>Perbandingan Data Sebelum & Sesudah Preprocessing</h3></div>
    <table>
        <thead>
            <tr><th>NO</th><th>DATA MENTAH (AWAL)</th><th>SETELAH IMPUTASI</th><th>HASIL NORMALISASI (0-1)</th><th>VISUALISASI SKALA</th></tr>
        </thead>
        <tbody>
            <?php foreach ($imputed as $i => $row): ?>
            <tr>
                <td><?= $i + 1 ?></td>
                <td>
                    <?php if ($row['is_kosong']): ?>
                        <span class="badge badge-warn">kosong</span>
                    <?php else: ?>
                        <?= $row['asli'] ?>
                    <?php endif; ?>
                </td>
                <td>
                    <?= number_format($row['val'], 2, ',', '.') ?>
                    <?php if ($row['is_kosong']): ?>
                        <span style="color:#d97706; font-size:0.75rem; margin-left:4px;">(mean)</span>
                    <?php endif; ?>
                </td>
                <td class="bold"><?= number_format($row['norm'], 4, ',', '.') ?></td>
                <td>
                    <div class="progress-wrapper">
                        <div class="progress-fill <?= $row['is_kosong'] ? 'orange' : '' ?>" style="width: <?= $row['norm'] * 100 ?>%;"></div>
                    </div>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

</main></body></html>