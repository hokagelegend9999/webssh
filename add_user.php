<?php
set_include_path(get_include_path() . PATH_SEPARATOR . 'phpseclib');
include('Net/SSH2.php');

// setting VPS
$host = "178.128.56.233";
$root_password = "hokage1234";

// mendapatkan data dari form
$username = $_POST['username'];
$password = $_POST['password'];

// membuat koneksi SSH
$ssh = new Net_SSH2($host);
if (!$ssh->login('root', $root_password)) {
    echo "Login gagal.";
} else {
    // Menambahkan user baru
    $ssh->exec("useradd $username");

    // Mengatur password untuk user baru
    $ssh->exec("echo '$password' | passwd --stdin $username");

    // Memberikan feedback
    echo "User '$username' berhasil ditambahkan dan password telah diatur.";
}
?>
