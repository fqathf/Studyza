<?php 
session_start();
include 'connection.php';

$user_id = $_SESSION['user_id'];
$timer_id = $_POST['timer_id'];
$end_time = date("Y-m-d H:i:s");

//Simpan data timer ke db
$sql = "UPDATE timers SET end_time = ?, status = 'stopped' WHERE id = ? AND user_id = ?";
$stmt = $db->prepare($sql);
$stmt->bind_param("sii", $end_time, $timer_id, $user_id);

if($stmt->execute()){
    echo "Timer berhasil dihentikan";
} else {
    echo "Terjadi kesalahan: " . $db->error;
}
$stmt->close();
$db->close();
?>