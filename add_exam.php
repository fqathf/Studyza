<?php 
session_start();
include "connection.php";

// mengambil user id yang login dari session
$user_id = $_SESSION['user_id'];

//kondisi jika form disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $subject = $_POST['subject'];
    $date = $_POST['date'];
    $time = $_POST['time'];

    //query memasukkan tugas baru
    $sql = "INSERT INTO exams (user_id, subject, date, time) VALUES (?, ?, ?, ?)";
    $stmt = $db->prepare($sql);
    $stmt->bind_param("isss", $user_id, $subject, $date, $time);

    if($stmt->execute()) {
        // Masukkan ke tabel schedule juga
        $schedule_sql = "INSERT INTO schedule (user_id, subject, day, time) VALUES (?, ?, ?, ?)";
        $day = date('l', strtotime($date));
        $schedule_stmt = $db->prepare($schedule_sql);
        $schedule_stmt->bind_param("isss", $user_id, $subject, $day, $time);
        $schedule_stmt->execute();

        echo "Ujian berhasil ditambahkan";
    } else {
        echo "Terjadi kesalahan: " . $db->error; 
    }

    $stmt->close();
    $schedule_stmt->close();
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
        <form action="add_exam.php" method="POST">
            <label for="subject">Nama Mata Pelajaran:</label>
            <input type="text" id="subject" name="subject" required> <br>
            
            <label for="date">Tanggal:</label>
            <input type="date" id="date" name="date" required> <br>
    
            <label for="time">Jam (format 24 jam):</label>
            <input type="time" id="time" name="time" required> <br>
    
            <input type="submit" value="Simpan Ujian">
        </form>
    </div>
</body>
</html>