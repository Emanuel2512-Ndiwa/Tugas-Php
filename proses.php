<?php
session_start();
include 'config.php';


// LOGIN
if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $result = $conn->query("SELECT * FROM users WHERE username='$username'");
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['nama'] = $user['nama'];
            $_SESSION['nim'] = $user['nim'];
            $_SESSION['foto'] = $user['foto'];
            header("Location: todolist.php");
            exit;
        } else {
            echo "<script>alert('Password salah'); window.location='index.php';</script>";
        }
    } else {
        echo "<script>alert('Username tidak ditemukan'); window.location='index.php';</script>";
    }
}


// Tambah To Do
if (isset($_POST['add'])) {
    $task = $_POST['task'];
    $uid = $_SESSION['user_id'];
    $conn->query("INSERT INTO todos (user_id, task) VALUES ('$uid', '$task')");
    header("Location: todolist.php");
}

// Selesai
if (isset($_GET['done'])) {
    $id = $_GET['done'];
    $conn->query("UPDATE todos SET status='done' WHERE id='$id'");
    header("Location: todolist.php");
}

// Hapus
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    $conn->query("DELETE FROM todos WHERE id='$id'");
    header("Location: todolist.php");
}
?>
