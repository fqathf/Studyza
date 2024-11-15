<?php
session_start();
include "connection.php";

if(!isset($_SESSION["isLogin"])){
  header("Location: login.php");
  exit();
}

$user_id = $_SESSION['user_id'];

// Ambil nama hari
$current_day = date('1'); 

// Query mendapatkan list kelas
$sql_classes = "SELECT * FROM schedule WHERE user_id = ? AND day = ?";
$stmt_classes = $db->prepare($sql_classes);
$stmt_classes->bind_param("is", $user_id, $current_day);
$stmt_classes->execute();
$result_classes = $stmt_classes->get_result();

// Query mendapatkan tugas dalam progres
$sql_tasks = "SELECT * FROM tasks WHERE user_id = ? AND progress < 100 ORDER BY deadline ASC";
$stmt_tasks = $db->prepare($sql_tasks);
$stmt_tasks->bind_param("i", $user_id);
$stmt_tasks->execute();
$result_tasks = $stmt_tasks->get_result();

// Query mendapatkan tugas dalam progres
$current_date = date('Y-m-d');
$sql_exams = "SELECT * FROM exams WHERE user_id = ? AND date = ?";
$stmt_exams = $db->prepare($sql_exams);
$stmt_exams->bind_param("is", $user_id, $current_date);
$stmt_exams->execute();
$result_exams = $stmt_exams->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Studyza</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .sections {
            display: flex;
            justify-content: space-around;
        }
    </style>
</head>
<body>
    <?php
        include_once "navbar.php";
    ?>

    <main>
        <h1>Today</h1>
        <div class="sections">
            <div class="section">
                <h2>Jadwal Kelas Hari Ini (<?php echo $current_day; ?>)</h2>
                <?php if ($result_classes->num_rows > 0): ?>
                    <?php while ($class = $result_classes->fetch_assoc()): ?>
                        <div class="list-item">
                            <strong>Mata Pelajaran: </strong> <?php echo htmlspecialchars(($class['subject']))?> <br>
                            <strong>Jam: </strong> <?php echo htmlspecialchars(($class['time']))?>
                        </div>
                    <?php endwhile; ?>   
                <?php else: ?>     
                    <p>Tidak ada kelas untuk hari ini</p>
                <?php endif; ?>    
            </div>
            <div class="section">
                <h2>Tugas dalam progress</h2>
                <?php if ($result_tasks->num_rows > 0): ?>
                    <?php while ($task = $result_tasks->fetch_assoc()): ?>
                        <div class="list-item">
                            <strong>Nama Tugas: </strong> <?php echo htmlspecialchars(($task['task_name']))?> <br>
                            <strong>Progress: </strong> <?php echo htmlspecialchars(($task['progress']))?>% <br>
                            <strong>Deadline: </strong> <?php echo htmlspecialchars(($task['deadline']))?>
                        </div>
                    <?php endwhile; ?>   
                <?php else: ?>     
                    <p>Tidak ada tugas dalam progres.</p>
                <?php endif; ?>    
            </div>
            <div class="section">
                <h2>Ujian Hari Ini (<?php echo $current_date; ?>)</h2>
                <?php if ($result_exams->num_rows > 0): ?>
                    <?php while ($exam = $result_exams->fetch_assoc()): ?>
                        <div class="list-item">
                            <strong>Mata Pelajaran: </strong> <?php echo htmlspecialchars(($exam['subject']))?>
                            <strong>Jam: </strong> <?php echo htmlspecialchars(($exam['time']))?>
                        </div>
                    <?php endwhile; ?>   
                <?php else: ?>     
                    <p>Tidak ada ujian hari ini</p>
                <?php endif; ?>    
            </div>
        </div>
    </main>
</body>
</html>