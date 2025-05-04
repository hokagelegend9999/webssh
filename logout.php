<?php
session_start();
session_unset();  // Menghapus session
session_destroy();  // Menghancurkan session

// Redirect ke halaman login
header("Location: index.php");
exit;
