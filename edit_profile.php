<?php
session_start();
include "connection.php";


if(!isset($_SESSION["isLogin"])) {
    header("Location: login.php");
    exit();
}
// ambil id user yang sedang login (dari session)
$user_id = $_SESSION['user_id'];

// query untuk mendapat data user
$sql = "SELECT name, grade FROM account WHERE id = ?";
$stmt = $db->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

//kondisi jika form disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //mengambil data dari input form
    $new_name = $_POST['name'];
    $new_grade = $_POST['grade'];

    //query untuk mengupdate profil 
    $sql = "UPDATE account SET name = ?, grade = ? WHERE id = ?";
    $stmt = $db->prepare($sql);
    $stmt->bind_param("sii", $new_name, $new_grade, $user_id);

    if ($stmt->execute()) {
        echo "Profil berhasil diubah";
    } else {
        echo "Terjadi kesalahan: " . $db->error;
    }

    $stmt->close();
}
$db->close()
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <link rel="stylesheet" href="style.css">
    <style>
        * {
            font-family: sans-serif;
        }
        #profile-main {
            display: flex;
            
        }
        #edit-profile {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 3px;
        }
        input {
            padding: 8px;
            border-radius: 10px;
        }
    </style>
</head>
<body>
    <?php
        include_once "navbar.php";
    ?>
    <div id="profile-main">
        <div id="edit-profile">
            <h2>Profile</h2>
            <form method="POST" action="edit_profile.php">
                <label for="name">Name</label> <br>
                <input type="text" name="name" id="name" value="<?php echo htmlspecialchars($user['name']); ?>" required> <br>

                <label for="grade">Grade</label> <br>
                <input type="number" name="grade" id="grade" value="<?php echo $user['grade']; ?>" required> <br>
                <br>
                <input type="submit" value="Save Changes">
            </form>
        </div>
        <div id="statistics">
            <!-- yang ini mungkin belum perlu -->
        </div>
    </div>
</body>
</html>