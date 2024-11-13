<?php 
session_start();
include "connection.php";

// mengambil user id yang login dari session
$user_id = $_SESSION['user_id'];
$goal_id = $_POST['id'];

    //query mengambil status goal 
    $sql = "SELECT is_completed FROM goals WHERE id = ? AND user_id = ?";
    $stmt = $db->prepare($sql);
    $stmt->bind_param("ii", $goal_id, $user_id);
    $stmt->execute();
    $stmt->bind_result($is_completed);
    $stmt->fetch();
    $stmt->close();

    //Ubah status
    $new_status = !$is_completed;
    $update_sql = "UPDATE goals SET is_completed = ? WHERE id = ? AND user_id = ?";
    $update_stmt = $db->prepare($update_sql);
    $update_stmt->bind_param("iii", $new_status, $goal_id, $user_id);

    if ($update_stmt->execute()) {
        header("Location: view_goals.php");
        exit;
    } else {
        echo "Terjadi kesalahan: " . $db->error;
    }
$update_stmt->close();
$db->close();
?>