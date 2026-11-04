<?php
require '../includes/layout.php';

$file = '../dataset_mahasiswa.csv';
$rows = []; $header_cols = [];
$stats = ['total_rows' => 0, 'total_cols' => 0, 'num_cols' => 0, 'text_cols' => 0];

if (($handle = fopen($file, "r")) !== FALSE) {
    $header_cols = fgetcsv($handle, 1000, ",");
    $stats['total_cols'] = count($header_cols);
    $col_types = array_fill(0, $stats['total_cols'], 'numeric');
    $row_count = 0;

    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
        if ($row_count < 5) $rows[] = $data;
        $row_count++;
        foreach ($data as $index => $value) {
            if (!is_numeric($value)) $col_types[$index] = 'string';
        }
    }
    fclose($handle);
    $stats['total_rows'] = $row_count;
}

foreach ($col_types as $type) {
    if ($type == 'numeric') $stats['num_cols']++;
    else $stats['text_cols']++;
}
?>

<div class="hero-card">
    <div>
        <h2>Eksplorasi Awal Dataset (Data Profiling)</h2>
        <p>Membaca dan mendeteksi tipe data dari berkas <code>dataset_mahasiswa.csv</code></p>
    </div>
    <div class="badge-active">File Status: Aktif</div>
</div>

<div class="stats-grid">
    <div class="stat-card blue">
        <div class="stat-label">JUMLAH BARIS</div>
        <div class="stat-value"><?= $stats['total_rows'] ?></div>
    </div>
    <div class="stat-card green">
        <div class="stat-label">JUMLAH KOLOM</div>
        <div class="stat-value"><?= $stats['total_cols'] ?></div>
    </div>
    <div class="stat-card purple">
        <div class="stat-label">KOLOM NUMERIK</div>
        <div class="stat-value"><?= $stats['num_cols'] ?></div>
    </div>
    <div class="stat-card orange">
        <div class="stat-label">KOLOM TEKS</div>
        <div class="stat-value"><?= $stats['text_cols'] ?></div>
    </div>
</div>

<div class="data-grid">
    <div class="panel">
        <div class="panel-header"><h3>Struktur & Tipe Data Kolom</h3></div>
        <table>
            <thead><tr><th>NAMA KOLOM</th><th>TIPE DATA</th></tr></thead>
            <tbody>
                <?php foreach ($header_cols as $index => $col_name): 
                    $type = $col_types[$index];
                    $badge = $type == 'numeric' ? 'badge-int' : 'badge-str';
                    $label = $type == 'numeric' ? 'Integer' : 'String';
                ?>
                <tr>
                    <td class="bold"><?= htmlspecialchars($col_name) ?></td>
                    <td><span class="badge <?= $badge ?>"><?= $label ?></span></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div class="panel">
        <div class="panel-header">
            <h3>Pratinjau Dataset CSV (Head Data)</h3>
            <span>Format: .csv</span>
        </div>
        <table>
            <thead>
                <tr><?php foreach ($header_cols as $col): ?><th><?= strtoupper(htmlspecialchars($col)) ?></th><?php endforeach; ?></tr>
            </thead>
            <tbody>
                <?php foreach ($rows as $row): ?>
                <tr>
                    <?php foreach ($row as $index => $cell): ?>
                        <td class="<?= $index == 0 ? 'bold' : '' ?>"><?= htmlspecialchars($cell) ?></td>
                    <?php endforeach; ?>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

</main></body></html>