<?php 
session_start();
include "connection.php";

if(!isset($_SESSION["isLogin"])){
    header("Location: login.php");
    exit();
  }

//Ambil ID User yg login dari session
$user_id = $_SESSION['user_id'];

//Query untuk mengambil data tugas milik user
$sql = "SELECT task_name, progress, deadline FROM tasks WHERE user_id = ? ORDER BY deadline ASC";
$stmt = $db->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Tugas Saya</title>
    <link rel="stylesheet" href="style.css">
    <style>
        #main-task {
            display: flex;
            justify-content: space-around;
            padding-top: 80px;
        }
        .add-button {
            color: black;
            font-size: large;
            font-weight: bold;
            text-decoration: none;
            padding: 12px;
            border: 1px solid black;
            border-radius: 10px;
            background-color: #f9d1df;
        }
    </style>
</head>
<body>
    <?php include_once "navbar.php" ?>

    <div id="main-task">
        <div>
            <a class="add-button" href="add_task.php">Add Task</a>
        </div>
    
        <div>
            <h2>Daftar Tugas Saya</h2>
            <table border="1">
                <thead>
                    <tr>
                        <th>Nama Tugas</th>
                        <th>Progress (%)</th>
                        <th>Deadline</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = $result->fetch_assoc()):  ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['task_name'])?></td>
                        <td><?php echo htmlspecialchars($row['progress'])?>%</td>
                        <td><?php echo htmlspecialchars($row['deadline'])?></td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
    

    
</body>
</html>

<?php
$stmt->close();
$db->close();
?>