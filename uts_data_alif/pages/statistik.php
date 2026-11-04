<?php
require '../includes/layout.php';

$data = [60, 62, 65, 68, 72, 74, 75, 76, 78, 82, 85, 85, 85, 88, 89, 90, 91, 92, 95, 100];
$n = count($data);
sort($data);

$mean = array_sum($data) / $n;
$median = ($data[9] + $data[10]) / 2;
$freq = array_count_values($data);
$maxFreq = max($freq);
$modus = array_keys(array_filter($freq, fn($f) => $f === $maxFreq));

$sumSq = 0; foreach ($data as $v) $sumSq += ($v - $mean) ** 2;
$stdDev = sqrt($sumSq / $n);

$bins = ['< 60' => 0, '60-69' => 0, '70-79' => 0, '80-89' => 0, '90-100' => 0];
foreach ($data as $v) {
    if ($v < 60) $bins['< 60']++;
    elseif ($v <= 69) $bins['60-69']++;
    elseif ($v <= 79) $bins['70-79']++;
    elseif ($v <= 89) $bins['80-89']++;
    else $bins['90-100']++;
}
$maxBin = max($bins);
?>

<div class="hero-card">
    <div>
        <h2>Kalkulator & Distribusi Statistik Deskriptif</h2>
        <p>Analisis pemusatan data (Mean, Median, Modus) dan sebaran (Standar Deviasi)</p>
    </div>
    <div class="badge-active">n = <?= $n ?> Sampel</div>
</div>

<div class="stats-grid">
    <div class="stat-card blue">
        <div class="stat-label">MEAN (RATA-RATA)</div>
        <div class="stat-value"><?= number_format($mean, 2, ',', '.') ?></div>
    </div>
    <div class="stat-card green">
        <div class="stat-label">MEDIAN (NILAI TENGAH)</div>
        <div class="stat-value"><?= number_format($median, 2, ',', '.') ?></div>
    </div>
    <div class="stat-card orange">
        <div class="stat-label">MODUS (PALING SERING)</div>
        <div class="stat-value"><?= implode(', ', $modus) ?> <small>(<?= $maxFreq ?>x)</small></div>
    </div>
    <div class="stat-card red">
        <div class="stat-label">STANDAR DEVIASI (S)</div>
        <div class="stat-value"><?= number_format($stdDev, 2, ',', '.') ?></div>
    </div>
</div>

<div class="data-grid-equal">
    <div class="panel">
        <div class="panel-header"><h3>Distribusi Frekuensi (Histogram)</h3></div>
        <div style="padding: 24px;">
            <?php foreach ($bins as $range => $count): ?>
            <div class="bar-row">
                <div class="bar-label"><?= $range ?></div>
                <div class="bar-track">
                    <div class="bar-fill" style="width: <?= ($count / $maxBin) * 100 ?>%;"></div>
                </div>
                <div class="bar-value"><?= $count ?></div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>

    <div class="panel">
        <div class="panel-header"><h3>Dataset Terurut (Sorted Array)</h3></div>
        <div style="padding: 24px; display: flex; flex-wrap: wrap; gap: 8px;">
            <?php foreach ($data as $v): 
                $isModus = in_array($v, $modus);
            ?>
                <span class="badge <?= $isModus ? 'badge-warn' : 'badge-int' ?>" style="padding: 8px 12px;"><?= $v ?></span>
            <?php endforeach; ?>
        </div>
        <div style="padding: 0 24px 24px 24px; color: #64748b; font-size: 0.85rem;">
            *Nilai modus ditandai dengan warna kuning. Rentang data terendah: <strong><?= min($data) ?></strong> dan tertinggi: <strong><?= max($data) ?></strong>.
        </div>
    </div>
</div>

</main></body></html>