<?php 
session_start();
include "connection.php";

if(!isset($_SESSION["isLogin"])){
    header("Location: login.php");
    exit();
  }

// mengambil user id yang login dari session
$user_id = $_SESSION['user_id'];

//kondisi jika form disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $goal = $_POST['goal'];

    //query memasukkan tugas baru
    $sql = "INSERT INTO goals (user_id, goal) VALUES (?, ?)";
    $stmt = $db->prepare($sql);
    $stmt->bind_param("is", $user_id, $goal);

    if($stmt->execute()) {
        echo "Goal berhasil ditambahkan";
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
            <label for="goal">Goal:</label>
            <input type="text" id="goal" name="goal" required> <br>
    
            <input type="submit" value="Tambah Goal">
        </form>
    </div>
</body>
</html>