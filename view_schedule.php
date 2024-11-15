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
$sql = "SELECT subject, day, time FROM schedule WHERE user_id = ? ORDER BY FIELD(day, 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'), time ASC";
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
    <title>Jadwal Saya</title>
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
            <a class="add-button" href="add_schedule.php">Add Schedule</a>
        </div>
    
        <div>
            <h2>Daftar Tugas Saya</h2>
            <table border="1">
                <thead>
                    <tr>
                        <th>Mata Pelajaran</th>
                        <th>Hari</th>
                        <th>Jam</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = $result->fetch_assoc()):  ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['subject'])?></td>
                        <td><?php echo htmlspecialchars($row['day'])?></td>
                        <td><?php echo htmlspecialchars($row['time'])?></td>
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