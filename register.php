<?php
session_start();
include 'config.php';

if (isset($_POST['register'])) {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $nama = $_POST['nama'];
    $nim = $_POST['nim'];

    // Nama file foto di-set otomatis berdasarkan username (misal: eman.jpg)
    $fotoName = strtolower($username) . '.jpg';

    // Cek apakah username sudah ada
    $cek = $conn->query("SELECT * FROM users WHERE username='$username'");
    if ($cek->num_rows > 0) {
        echo "<script>alert('Username sudah digunakan!');</script>";
    } else {
        $sql = "INSERT INTO users (username, password, nama, nim, foto) 
                VALUES ('$username', '$password', '$nama', '$nim', '$fotoName')";
        if ($conn->query($sql)) {
            echo "<script>alert('Register berhasil! Silakan login'); window.location='index.php';</script>";
        } else {
            echo "<script>alert('Gagal register.');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="login-card">
    <h2>Register</h2>
    <form method="POST">
        <label>Username</label>
        <input type="text" name="username" required>

        <label>Password</label>
        <input type="password" name="password" required>

        <label>Nama</label>
        <input type="text" name="nama" required>

        <label>NIM</label>
        <input type="text" name="nim" required>

        <button type="submit" name="register">Register</button>
    </form>
    <p>Sudah punya akun? <a href="index.php">Login</a></p>
</div>
</body>
</html>
