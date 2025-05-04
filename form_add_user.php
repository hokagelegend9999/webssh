<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah User Baru</title>
    <link rel="stylesheet" href="style.css"> <!-- optional, jika ingin styling -->
</head>
<body>
    <h2>Tambah User Baru</h2>
    <!-- Formulir untuk menambah user -->
    <form action="add_user.php" method="POST">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required><br><br>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br><br>

        <input type="submit" value="Tambah User">
    </form>
</body>
</html>
