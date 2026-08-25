<?php
session_start();
include "db.php";

if(!isset($_SESSION['id']))
{
    header("Location: login.php");
    exit();
}

$result = $conn->query("SELECT * FROM users");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Users</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

<div class="container" style="width:90%;">

<h2>User Management</h2>

<a href="dashboard.php">
<button>Dashboard</button>
</a>

<a href="add_user.php">
<button>Add User</button>
</a>

<br><br>

<table border="1" cellpadding="10" cellspacing="0" width="100%">

<tr>
<th>ID</th>
<th>Name</th>
<th>Email</th>
<th>Role</th>
<th>Profile</th>
<th>Action</th>
</tr>

<?php while($row=$result->fetch_assoc()) { ?>

<tr>

<td><?php echo $row['id']; ?></td>

<td><?php echo $row['name']; ?></td>

<td><?php echo $row['email']; ?></td>

<td><?php echo $row['role']; ?></td>

<td>
<img src="uploads/<?php echo $row['profile_pic']; ?>" width="60">
</td>

<td>

<a href="edit_user.php?id=<?php echo $row['id']; ?>">Edit</a>

|

<a href="delete_user.php?id=<?php echo $row['id']; ?>"
onclick="return confirm('Delete this user?')">

Delete

</a>

</td>

</tr>

<?php } ?>

</table>

</div>

</body>
</html>