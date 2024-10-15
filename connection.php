<!-- Ini kode untuk menghubungkan website dengan database -->
<?php
$hostname = "localhost";
$username = "root";
$password = "";
$database = "studyza";

$db = mysqli_connect($hostname, $username, $password, $database);

if($db->connect_error) {
    echo "connection failed";
    die("Error!");
}
?>