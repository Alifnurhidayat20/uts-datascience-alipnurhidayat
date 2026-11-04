<?php
require '../includes/layout.php';

$rawData = [
    ['id' => 'TX001', 'tgl' => '2026-10-21', 'nominal' => 50000,   'status' => 'success'],
    ['id' => 'TX002', 'tgl' => '2026-10-21', 'nominal' => -10000,  'status' => 'success'],
    ['id' => 'TX003', 'tgl' => '2026-10-21', 'nominal' => 150000,  'status' => 'pending'],
    ['id' => 'TX004', 'tgl' => '2026-10-21', 'nominal' => null,    'status' => 'success'],
    ['id' => 'TX005', 'tgl' => '2026-10-22', 'nominal' => 75000,   'status' => 'success'],
];

function validateRow(array $row): bool {
    if (!isset($row['id'], $row['tgl'], $row['status'])) return false;
    if (!is_numeric($row['nominal']) || $row['nominal'] <= 0) return false;
    return true;
}

$valid = []; $rejected = [];
foreach ($rawData as $r) {
    if (validateRow($r)) $valid[] = $r;
    else $rejected[] = $r;
}
?>

<div class="hero-card">
    <div>
        <h2>Simulasi Pipeline Audit Transaksi</h2>
        <p>Ingestion, Audit Kelayakan Data, dan Penyaringan Transaksi Otomatis</p>
    </div>
    <div class="badge-active">Status: Pipeline Selesai</div>
</div>

<div class="stats-grid" style="grid-template-columns: repeat(3, 1fr);">
    <div class="stat-card blue">
        <div class="stat-label">TOTAL MASUK</div>
        <div class="stat-value"><?= count($rawData) ?></div>
    </div>
    <div class="stat-card green">
        <div class="stat-label">LOLOS AUDIT (VALID)</div>
        <div class="stat-value" style="color: #059669;"><?= count($valid) ?></div>
    </div>
    <div class="stat-card red">
        <div class="stat-label">DITOLAK (AUDIT GAGAL)</div>
        <div class="stat-value" style="color: #ef4444;"><?= count($rejected) ?></div>
    </div>
</div>

<div class="panel">
    <div class="panel-header"><h3>Laporan Audit Transaksi Mentah</h3></div>
    <table>
        <thead>
            <tr><th>ID TRANSAKSI</th><th>TANGGAL</th><th>NOMINAL (AMOUNT)</th><th>STATUS TRANSAKSI</th><th>HASIL AUDIT</th></tr>
        </thead>
        <tbody>
            <?php foreach ($rawData as $r): 
                $isValid = validateRow($r);
            ?>
            <tr>
                <td class="bold"><?= $r['id'] ?></td>
                <td><?= $r['tgl'] ?></td>
                <td>
                    <?php if ($r['nominal'] === null): ?>
                        <span class="badge badge-fail">kosong</span>
                    <?php else: ?>
                        <strong>Rp <?= number_format($r['nominal'], 0, ',', '.') ?></strong>
                    <?php endif; ?>
                </td>
                <td><span class="badge" style="background:#f1f5f9; color:#475569;"><?= $r['status'] ?></span></td>
                <td>
                    <?php if ($isValid): ?>
                        <span class="badge badge-ok">Lolos Audit</span>
                    <?php else: ?>
                        <span class="badge badge-fail">Ditolak</span>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

</main></body></html>