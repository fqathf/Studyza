<?php
    include "connection.php";
    session_start();

    if(isset($_SESSION["id"])){
        header("Location: home.php");
        exit();
    }
    if(isset($_POST['login'])){
        $email = $_POST['email'];
        $password = $_POST['password'];
        $encryptPassword = hash("sha256", $password);

        $checkAccount = "SELECT * FROM account WHERE email = '$email' AND password = '$encryptPassword'";
        $result = mysqli_query($db, $checkAccount);
        if(mysqli_num_rows($result) > 0){
            $data = mysqli_fetch_assoc($result);
            $_SESSION['id'] = $data['id'];
            $_SESSION['isLogin'] = true;

            header("Location: home.php");
            exit();
        } else {
            echo "Login Failed";
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Studyza</title>
    <link rel="stylesheet" href="index.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300..700&display=swap" rel="stylesheet">
</head>
<body>
    <form action="login.php" method="POST" id="container">
        <label for="email">Email</label>
        <input name="email" type="email" id="email">
        <label for="password">Password</label>
        <input name="password" type="password" id="password">
        <button type="submit" name="login" class="button button-login">Login</button>
    </form>
</body>
</html>