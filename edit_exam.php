<?php 
session_start();
include "connection.php";

// mengambil user id yang login dari session
$user_id = $_SESSION['user_id'];
$exam_id = $_GET['id'];

// Ambil data ujian
$sql = "SELECT subject, date, time FROM exams WHERE id = ? AND user_id = ?";
$stmt = $db->prepare($sql);
$stmt->bind_param("ii", $exam_id, $user_id);
$stmt->execute();
$stmt->bind_result($subject, $date, $time);
$stmt->fetch();
$stmt->close();

//kondisi jika form disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_subject = $_POST['subject'];
    $new_date = $_POST['date'];
    $new_time = $_POST['time'];

    //update data ujian
    $update_sql = "UPDATE exams SET subject = ?, date = ?, time = ? WHERE id = ? AND user_id = ?";
    $update_stmt = $db->prepare($sql);
    $update_stmt->bind_param("sssii", $new_subject, $new_date, $new_time, $exam_id, $user_id);

    if($stmt->execute()) {
        echo "Ujian berhasil diperbarui.";
    } else {
        echo "Terjadi kesalahan: " . $db->error; 
    }

    $update_stmt->close();
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
        <form action="edit_exam.php?id=<?php echo $exam_id; ?>" method="POST">
            <label for="subject">Nama Mata Pelajaran:</label>
            <input type="text" id="subject" name="subject" value="<?php echo htmlspecialchars($subject); ?>" required> <br>
            
            <label for="date">Tanggal:</label>
            <input type="date" id="date" name="date" value="<?php echo htmlspecialchars($date); ?>" required> <br>
    
            <label for="time">Jam (format 24 jam):</label>
            <input type="time" id="time" name="time" value="<?php echo htmlspecialchars($time); ?>" required> <br>
    
            <input type="submit" value="Update Ujian">
        </form>
    </div>
</body>
</html>