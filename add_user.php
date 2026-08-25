<?php
session_start();
include "db.php";

if(isset($_POST['save']))
{
$name=$_POST['name'];
$email=$_POST['email'];
$password=password_hash($_POST['password'],PASSWORD_DEFAULT);
$role=$_POST['role'];

$stmt=$conn->prepare("INSERT INTO users(name,email,password,role) VALUES(?,?,?,?)");
$stmt->bind_param("ssss",$name,$email,$password,$role);

if($stmt->execute())
{
echo "<script>
alert('User Added');
window.location='users.php';
</script>";
}
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Add User</title>
<link rel="stylesheet" href="css/style.css">
</head>

<body>

<div class="container">

<h2>Add User</h2>

<form method="POST">

<input type="text"
name="name"
placeholder="Name"
required>

<input type="email"
name="email"
placeholder="Email"
required>

<input type="password"
name="password"
placeholder="Password"
required>

<select name="role">

<option>User</option>

<option>Admin</option>

</select>

<br><br>

<button
type="submit"
name="save">
Save
</button>

</form>

</div>

</body>
</html>