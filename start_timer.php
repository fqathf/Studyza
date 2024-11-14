<?php 
session_start();
include 'connection.php';

$user_id = $_SESSION['user_id'];
$duration = $_POST['duration'];
$start_time = date("Y-m-d H:i:s");

//Simpan data timer ke db
$sql = "INSERT INTO timers (user_id, duration, start_time, status) VALUES (?, ?, ?, 'running')";
$stmt = $db->prepare($sql);
$stmt->bind_param("iis", $user_id, $duration, $start_time);

if($stmt->execute()){
    echo "Timer berhasil dimulai";
} else {
    echo "Terjadi kesalahan: " . $db->error;
}
$stmt->close();
$db->close();
?>