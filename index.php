<?php
session_start();  // Mulai session untuk mengelola login

set_include_path(get_include_path() . PATH_SEPARATOR . 'phpseclib');
include('Net/SSH2.php');

// setting VPS
$host = "178.128.56.233";
$root_password = "hokage1234";

// Mengecek apakah form login sudah disubmit
if (isset($_POST['login_username']) && isset($_POST['login_password'])) {
    // mendapatkan data dari form login
    $login_username = $_POST['login_username'];
    $login_password = $_POST['login_password'];

    // Memastikan data tidak kosong
    if (!empty($login_username) && !empty($login_password)) {
        // Membuat koneksi SSH untuk login
        $ssh = new Net_SSH2($host);
        if (!$ssh->login('root', $root_password)) {
            echo "Login gagal.";
        } else {
            // Menyimpan username ke session setelah login sukses
            $_SESSION['loggedin'] = true;
            $_SESSION['username'] = $login_username; // Menyimpan username dalam session
            
            // Redirect ke dashboard
            header("Location: dashboard.php");
            exit;
        }
    } else {
        echo "Username dan password login tidak boleh kosong.";
    }
}

// Mengecek apakah form pendaftaran user baru sudah disubmit
if (isset($_POST['register_username']) && isset($_POST['register_password'])) {
    // mendapatkan data dari form pendaftaran
    $register_username = $_POST['register_username'];
    $register_password = $_POST['register_password'];

    // Memastikan data tidak kosong
    if (!empty($register_username) && !empty($register_password)) {
        // Membuat koneksi SSH untuk menambahkan user baru
        $ssh = new Net_SSH2($host);
        if (!$ssh->login('root', $root_password)) {
            echo "Login gagal.";
        } else {
            // Menambahkan user baru
            $ssh->exec("useradd $register_username");

            // Mengatur password untuk user baru
            $ssh->exec("echo '$register_password' | passwd --stdin $register_username");

            // Memberikan feedback
            echo "User '$register_username' berhasil ditambahkan dan password telah diatur.";
        }
    } else {
        echo "Username dan password pendaftaran tidak boleh kosong.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login dan Daftar User</title>
</head>
<body>
    <h2>Form Login</h2>
    <form action="index.php" method="POST">
        <label for="login_username">Username:</label><br>
        <input type="text" id="login_username" name="login_username" required><br><br>

        <label for="login_password">Password:</label><br>
        <input type="password" id="login_password" name="login_password" required><br><br>

        <button type="submit">Login</button>
    </form>

    <h2>Form Daftar User Baru</h2>
    <form action="index.php" method="POST">
        <label for="register_username">Username Baru:</label><br>
        <input type="text" id="register_username" name="register_username" required><br><br>

        <label for="register_password">Password Baru:</label><br>
        <input type="password" id="register_password" name="register_password" required><br><br>

        <button type="submit">Daftar</button>
    </form>
</body>
</html>
