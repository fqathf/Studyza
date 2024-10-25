<?php
    include "connection.php";
    session_start();

    if(isset($_SESSION["user_id"])){ //ini juga
        header("Location: home.php");
        exit();
    }
    if(isset($_POST['signup'])){
        $email = $_POST['email'];
        $name = $_POST['name'];
        $password = $_POST['password'];
        $encryptPassword = hash("sha256", $password);

        try {
            $createAccount = "INSERT INTO account (email, name, password) VALUES('$email', '$name', '$encryptPassword')";
            if(mysqli_query($db, $createAccount)){
                echo "Register Success";
                header("Location: home.php");
            } else {
                echo "Register Failed";
            }
        } catch(mysqli_sql_exception) {
            echo "Register Failed";
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
    <form action="signup.php" method="POST" id="container">
        <label for="name">Name</label>
        <input name="name" type="name" id="name">
        <label for="email">Email</label>
        <input name="email" type="email" id="email">
        <label for="password">Password</label>
        <input name="password" type="password" id="password">
        <button type="submit" name="signup" class="button button-signup">Sign up</button>
    </form>
</body>
</html>