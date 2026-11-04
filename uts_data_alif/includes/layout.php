<?php
$current_page = basename($_SERVER['PHP_SELF']);
$menu = [
    'eda-csv.php'       => '1. Data Profiling',
    'preprocessing.php' => '2. Preprocessing',
    'statistik.php'     => '3. Analisis Statistik',
    'splitting.php'     => '4. ML Splitting',
    'data-pipeline.php' => '5. Pipeline Final'
];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Science </title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>

<header class="topbar">
    <div class="brand-container">
        <div class="brand">
            <div class="brand-icon">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 20h3v-8H4v8zm6 0h3V4h-3v16zm6 0h3v-12h-3v12z"/></svg>
            </div>
            <div class="brand-text">
                <h1>Data Science </h1>
                <p>Dashboard Terpadu Pemrosesan Data (PHP Native)</p>
            </div>
        </div>
    </div>

    <nav class="nav-tabs">
        <?php foreach ($menu as $file => $label): 
            $isActive = $current_page === $file ? 'active' : '';
        ?>
            <a href="<?= $file ?>" class="<?= $isActive ?>"><?= $label ?></a>
        <?php endforeach; ?>
    </nav>
</header>

<main class="container">