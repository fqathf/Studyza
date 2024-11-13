<?php 
session_start();
include "connection.php";

// mengambil user id yang login dari session
$user_id = $_SESSION['user_id'];
$exam_id = $_GET['id'];

//update data ujian
$sql = "DELETE FROM goals WHERE id = ? AND user_id = ?";
$stmt = $db->prepare($sql);
$stmt->bind_param("ii", $exam_id, $user_id);

if($stmt->execute()) {
    echo "Goals berhasil dihapus.";
} else {
    echo "Terjadi kesalahan: " . $db->error; 
}

$stmt->close();
$db->close();

header("Location: view_goals.php");
exit;
?>