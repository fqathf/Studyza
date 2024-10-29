<?php 
session_start();
include "connection.php";

// mengambil user id yang login dari session
$user_id = $_SESSION['user_id'];

//kondisi jika form disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $task_name = $_POST['task_name'];
    $progress = $_POST['progress'];
    $deadline = $_POST['deadline'];

    //query memasukkan tugas baru
    $sql = "INSERT INTO tasks (user_id, task_name, progress, deadline) VALUES (?, ?, ?, ?)";
    $stmt = $db->prepare($sql);
    $stmt->bind_param("isis", $user_id, $task_name, $progress, $deadline);

    if($stmt->execute()) {
        echo "Tugas berhasil ditambahkan";
    } else {
        echo "Terjadi kesalahan: " . $db->error; 
    }

    $stmt->close();
}
$db->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Tugas Baru</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .container {
            padding: 12px;
            margin: 12px;
            background-color: #f9d1df;
            border-radius: 10px;
        }
        input {
            border-radius: 10px;
        }
    </style>
</head>
<body>
    <?php include_once "navbar.php" ?>
    <div class="container">
        <h2>Tambah Tugas Baru</h2>
        <form action="add_task.php" method="POST">
            <label for="task_name">Nama Tugas:</label>
            <input type="text" id="task_name" name="task_name" required> <br>
            
            <label for="progress">Progress:</label>
            <input type="number" id="progress" name="progress" min="0" max="100" value="0" required> <br>
    
            <label for="deadline">Deadline:</label>
            <input type="date" id="deadline" name="deadline" required> <br>
    
            <input type="submit" value="Simpan Tugas">
        </form>
    </div>
</body>
</html>