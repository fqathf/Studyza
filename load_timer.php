<?php 
session_start();
include 'connection.php';

$user_id = $_SESSION['user_id'];

//Simpan data timer ke db
$sql = "SELECT * FROM timers WHERE user_id = ? AND status = 'running' LIMIT 1";
$stmt = $db->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$timer = $result->fetch_assoc();

$response = [
    'time_left' => 0
];

if ($timer) {
    $duration = $timer['duration'];
    $start_time = strtotime($timer['start_time']);
    $time_elapsed = time() - $start_time;
    $response['time_left'] = max($duration - $time_elapsed, 0);
}

$stmt->close();
$db->close();

echo json_encode($response);
?>