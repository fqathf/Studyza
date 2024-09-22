<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Studyza Schedule</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <a href="" id="profile">
            <img width="50px" src="assets/profile.svg" alt="">
        </a>
        <nav>
            <a href="">Schedule</a>
            <a href="">Task</a>
            <a href="">Exam</a>
            <a href="">Self-Study</a>
        </nav>
        <a href="" id="home">
            <img width="50px" src="assets/home.svg" alt="">
        </a>
    </header>
    <main id="schedule_main">
        <div id="subject">
            <form id="subject_form" method="GET">
                <label for="subject">Add name</label>
                <input type="text" id="subject" name="subject" required><br><br>
                <label for="day">Add day</label>
                <input type="text" id="day" name="day" required><br><br>
                <label for="times">Add times</label>
                <input type="text" id="times" name="times" required>
                <button type="submit">Add Subject</button>
            </form>
        </div>
        <div id="classes">
            <?php echo $_GET["subject"] . " in " . $_GET["day"] . " " . $_GET["times"];?>
        </div>
    </main>
</body>
</html>