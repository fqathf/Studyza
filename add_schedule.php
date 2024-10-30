<?php 
session_start();
include "connection.php";

// mengambil user id yang login dari session
$user_id = $_SESSION['user_id'];

//kondisi jika form disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $subject = $_POST['subject'];
    $day = $_POST['day'];
    $time = $_POST['time'];

    //query memasukkan tugas baru
    $sql = "INSERT INTO schedule (user_id, subject, day, time) VALUES (?, ?, ?, ?)";
    $stmt = $db->prepare($sql);
    $stmt->bind_param("isss", $user_id, $subject, $day, $time);

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
    <title>Tambah Jadwal</title>
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
        <h2>Tambah Jadwal Baru</h2>
        <form action="add_schedule.php" method="POST">
            <label for="subject">Nama Mata Pelajaran:</label>
            <input type="text" id="subject" name="subject" required> <br>
            
            <label for="day">Hari:</label>
            <select name="day" id="day" required>
                <option value="Senin">Senin</option>
                <option value="Selasa">Selasa</option>
                <option value="Rabu">Rabu</option>
                <option value="Kamis">Kamis</option>
                <option value="Jumat">Jumat</option>
                <option value="Sabtu">Sabtu</option>
                <option value="Minggu">Minggu</option>
            </select>

            <label for="time">Jam (format 24 jam, contoh 14:30):</label>
            <input type="time" id="time" name="time" required> <br>
    
            <input type="submit" value="Simpan Jadwal">
        </form>
    </div>
</body>
</html>