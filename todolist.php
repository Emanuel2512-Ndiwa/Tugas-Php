<?php
session_start();
include 'config.php';
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}
$uid = $_SESSION['user_id'];
$data = $conn->query("SELECT * FROM todos WHERE user_id='$uid'");
$userData = $conn->query("SELECT * FROM users WHERE id='$uid'")->fetch_assoc();

// Foto default berdasarkan username
$foto = "uploads/" . strtolower($_SESSION['username']) . ".jpg";
if (!file_exists($foto)) {
    $foto = "uploads/default.jpg";
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>To Do List</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        .header {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            margin-bottom: 20px;
            padding-right: 50px;
        }

        .profile-pic {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            object-fit: cover;
            margin-right: 15px;
            border: 3px solid #4caf50;
        }

        .user-info {
            text-align: right;
        }

        .user-info h3, .user-info p {
            margin: 0;
        }
    </style>
</head>
<body>

<div class="header">
    <img src="<?= $foto ?>" alt="Foto Profil" class="profile-pic">
    <div class="user-info">
        <h3><?= htmlspecialchars($userData['nama']) ?></h3>
        <p>NIM: <?= htmlspecialchars($userData['nim']) ?></p>
    </div>
</div>

<div class="todo-card">
    <h2><?= htmlspecialchars($_SESSION['username']) ?>'s To Do List</h2>
    <form method="POST" action="proses.php">
        <input type="text" name="task" placeholder="Teks to do" required>
        <button type="submit" name="add">Tambah</button>
    </form>

    <ul>
        <?php while ($row = $data->fetch_assoc()): ?>
            <li style="<?= $row['status']=='done' ? 'text-decoration: line-through;' : '' ?>">
                <?= htmlspecialchars($row['task']) ?>
                <a href="proses.php?done=<?= $row['id'] ?>">Selesai</a>
                <a href="proses.php?hapus=<?= $row['id'] ?>">Hapus</a>
            </li>
        <?php endwhile; ?>
    </ul>
    <a href="logout.php" class="logout-btn">Logout</a>
</div>
</body>
</html>
