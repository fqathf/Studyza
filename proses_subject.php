<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = array(
        "subject" => $_POST["subject"],
        "day" => $_POST["day"],
        "times" => $_POST["times"]
    );
}
?>