<?php
session_start();  // Memulai session untuk mengecek status login

// Mengecek apakah pengguna sudah login atau belum
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    // Jika tidak login, redirect ke halaman login
    header("Location: index.php");
    exit;
}

set_include_path(get_include_path() . PATH_SEPARATOR . 'phpseclib');
include('Net/SSH2.php');

// setting VPS
$host = "178.128.56.233";
$root_password = "hokage1234";

// Membuat koneksi SSH untuk mengecek status server
$ssh = new Net_SSH2($host);
if (!$ssh->login('root', $root_password)) {
    $status = "Gagal terhubung ke server.";
} else {
    $status = "Berhasil terhubung ke server.";
}

$username = $_SESSION['username'];  // Mendapatkan username yang sudah login
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
</head>
<body>
    <h2>Welcome, <?php echo htmlspecialchars($username); ?>!</h2>
    <p>Anda berhasil login ke VPS.</p>
    
    <h3>Dashboard</h3>
    <p>Status Koneksi ke Server: <?php echo $status; ?></p>
    
    <h4>Perintah yang dapat dijalankan di server:</h4>
    <ul>
        <li><strong>uname -a</strong> - Menampilkan informasi sistem.</li>
        <li><strong>df -h</strong> - Menampilkan status penggunaan disk.</li>
        <li><strong>top</strong> - Menampilkan proses yang berjalan.</li>
        <!-- Anda bisa menambahkan perintah lain sesuai kebutuhan -->
    </ul>

    <h3>Kelola Server VPS Anda:</h3>
    <form method="POST" action="dashboard.php">
        <label for="command">Masukkan perintah untuk dieksekusi:</label><br>
        <input type="text" id="command" name="command" required><br><br>
        <button type="submit">Kirim Perintah</button>
    </form>
    
    <h3>Output Perintah:</h3>
    <div>
        <?php
        // Mengeksekusi perintah jika form disubmit
        if (isset($_POST['command'])) {
            $command = $_POST['command'];
            $output = $ssh->exec($command);  // Menjalankan perintah di server
            echo "<pre>$output</pre>";  // Menampilkan hasil perintah
        }
        ?>
    </div>
    
    <!-- Tombol untuk logout -->
    <a href="logout.php">Logout</a>
</body>
</html>
