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
    <title>Timer</title>
    <link rel="stylesheet" href="style.css">
    <style>
        #main-task {
            display: flex;
            padding: 80px;
            gap: 12px;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding-top: 80px;
        }
        .add-button {
            color: black;
            font-size: large;
            font-weight: bold;
            text-decoration: none;
            padding: 12px;
            border: 1px solid black;
            border-radius: 10px;
            background-color: #f9d1df;
        }
        #sidebar {
            position: fixed;
            display: flex;
            width: 20vw;
            height: 100vh;
            border: 1px black solid;
            justify-content: center;
            align-items: center;
            gap: 30px;
            background-color: #f9d1df;
        }
        .sidebar-inner {
            display: flex;
            flex-direction: column;
            gap: 30px;
            color: white;
        }
    </style>
</head>
<body>
    <?php include_once "navbar.php" ?>
    <?php include_once "sidebar.php" ?>

    <div id="main-task">
        <h1>Timer</h1>
        <div id="timer">00:00:00</div>
        <input type="number" name="" id="minutesInput" placeholder="Masukkan Menit" min="0">
        <button onclick="startTimer()">Mulai</button>
        <button onclick="stopTimer()">Berhenti</button>
    </div>
    
    <script>
        let timerInterval;
        let timeLeft = 0;

        function startTimer() {
            const minutes = document.getElementById('minutesInput').value;
            timeLeft = minutes * 60; //konvert menit ke detik

            // simpan timer ke DB
            fetch('start_timer.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: `duration=${timeLeft}`
            }).then(response => response.text()).then(data => {
                console.log(data);
                runTimer();
            }).catch(error => console.error('Error:', error));
        }
        function runTimer() {
            clearInterval(timerInterval);
            timerInterval = setInterval(() => {
                if(timeLeft > 0) {
                    timeLeft--;
                    const hours = Math.floor(timeLeft / 3600);
                    const minutes = Math.floor((timeLeft % 3600) / 60);
                    const seconds = timeLeft % 60;
                    document.getElementById('timer').textContent =
                        String(hours).padStart(2, '0') + ":" +
                        String(minutes).padStart(2, '0') + ":" +
                        String(seconds).padStart(2, '0');
                } else {
                    clearInterval(timerInterval);
                    alert("Waktu Habis!")
                }
            }, 1000)
        }
        function stopTimer() {
            clearInterval(timerInterval);
            // Update status timer di database
            fetch('stop_timer.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: `timer_id=1`
            }).then(response => response.text()).then(data => {
                console.log(data);
            }).catch(error => console.error('Error:', error))
        }
    </script>
    
</body>
</html>