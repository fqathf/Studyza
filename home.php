<?php
session_start();

if(!isset($_SESSION["isLogin"])){
  header("Location: login.php");
  exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Studyza</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php
        include_once "navbar.php";
    ?>
</body>
</html>