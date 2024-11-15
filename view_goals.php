<?php 
session_start();
include "connection.php";

if(!isset($_SESSION["isLogin"])){
    header("Location: login.php");
    exit();
  }

//Ambil ID User yg login dari session
$user_id = $_SESSION['user_id'];

//Query untuk mengambil data tugas milik user
$sql = "SELECT id, goal, is_completed FROM goals WHERE user_id = ? ORDER BY id ASC";
$stmt = $db->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Tugas Saya</title>
    <link rel="stylesheet" href="style.css">
    <style>
        #main-task {
            display: flex;
            justify-content: space-around;
            padding-top: 80px;
            margin-left: 20px;
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
        <div>
            <a class="add-button" href="add_goal.php">Add Goals</a>
        </div>
    
        <div>
            <h2>Daftar Goals Saya</h2>
            <ul>
                <?php while($row = $result->fetch_assoc()):  ?>
                    <li>
                        <form method="POST" action="toggle_goal.php" style="display: inline;">
                            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                            <input type="checkbox" name="is_completed" onchange="this.form.submit()" <?php echo $row['is_completed'] ? 'checked' : ''; ?>>
                            <?php echo htmlspecialchars($row['goal']); ?>
                        </form>
                        <a href="delete_goal.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Yakin ingin hapus?')">Hapus</a>
                    </li>
                <?php endwhile; ?>
            </ul>
        </div>
    </div>
    

    
</body>
</html>

<?php
$stmt->close();
$db->close();
?>