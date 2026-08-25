<?php
session_start();
include "db.php";

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

$id = $_SESSION['id'];

$stmt = $conn->prepare("SELECT * FROM users WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

<div class="container">

    <img src="uploads/<?php echo $user['profile_pic']; ?>"
         width="120"
         height="120"
         style="border-radius:50%;">

    <h2>Welcome, <?php echo $user['name']; ?></h2>

    <p><strong>Role:</strong> <?php echo $user['role']; ?></p>

    <br>

    <a href="users.php">
        <button>Manage Users</button>
    </a>

    <br><br>

    <a href="profile.php">
        <button>My Profile</button>
    </a>

    <br><br>

    <a href="logout.php">
        <button>Logout</button>
    </a>

</div>

</body>
</html>