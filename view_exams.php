<?php 
session_start();
include "connection.php";

if(!isset($_SESSION["isLogin"])){
    header("Location: login.php");
    exit();
  }

//Ambil ID User yg login dari session
$user_id = $_SESSION['user_id'];
$search = isset($_GET['search']) ? $_GET['search'] : '';

//Query untuk mengambil data tugas milik user
$sql = "SELECT id, subject, date, time FROM exams WHERE user_id = ? AND subject LIKE ? ORDER BY date, time";
$stmt = $db->prepare($sql);
$search_param = "%" . $search . "%";
$stmt->bind_param("is", $user_id, $search_param);
$stmt->execute();
$result = $stmt->get_result();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Ujian Saya</title>
    <link rel="stylesheet" href="style.css">
    <style>
        #main-task {
            display: flex;
            justify-content: space-around;
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
    </style>
</head>
<body>
    <?php include_once "navbar.php" ?>
    <div id="main-task">
        <div>
            <a class="add-button" href="add_exam.php">Add Exam</a>
        </div>
    
        <div>
            <h2>Daftar Ujian Saya</h2>
            <form action="view_exams.php" method="GET">
                <input type="text" name="search" placeholder="Cari berdasarkan nama mata pelajaran" value="<?php echo htmlspecialchars($search); ?>">
                <input type="submit" value="Cari">
            </form>
            <table border="1">
                <thead>
                    <tr>
                        <th>Mata Pelajaran</th>
                        <th>Tanggal</th>
                        <th>Jam</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = $result->fetch_assoc()):  ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['subject'])?></td>
                        <td><?php echo htmlspecialchars($row['date'])?></td>
                        <td><?php echo htmlspecialchars($row['time'])?></td>
                        <td>
                            <a href="edit_exam.php?id=<?php echo $row['id'];?>">Edit</a> 
                            <a href="delete_exam.php?id=<?php echo $row['id']; ?>" onclick="return confirm(Yakin ingin menghapus data?)">Hapus</a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
    

    
</body>
</html>

<?php
$stmt->close();
$db->close();
?>