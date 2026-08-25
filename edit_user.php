<?php
session_start();
include "db.php";

if(!isset($_SESSION['id']))
{
    header("Location: login.php");
    exit();
}

$id=$_GET['id'];

$stmt=$conn->prepare("SELECT * FROM users WHERE id=?");
$stmt->bind_param("i",$id);
$stmt->execute();

$result=$stmt->get_result();
$user=$result->fetch_assoc();

if(isset($_POST['update']))
{
    $name=$_POST['name'];
    $email=$_POST['email'];
    $role=$_POST['role'];

    $stmt=$conn->prepare("UPDATE users SET name=?,email=?,role=? WHERE id=?");
    $stmt->bind_param("sssi",$name,$email,$role,$id);

    if($stmt->execute())
    {
        echo "<script>
        alert('User Updated Successfully');
        window.location='users.php';
        </script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Edit User</title>
<link rel="stylesheet" href="css/style.css">
</head>

<body>

<div class="container">

<h2>Edit User</h2>

<form method="POST">

<input type="text"
name="name"
value="<?php echo $user['name'];?>"
required>

<input type="email"
name="email"
value="<?php echo $user['email'];?>"
required>

<select name="role">

<option value="User"
<?php if($user['role']=="User") echo "selected"; ?>>
User
</option>

<option value="Admin"
<?php if($user['role']=="Admin") echo "selected"; ?>>
Admin
</option>

</select>

<br><br>

<button type="submit" name="update">
Update User
</button>

</form>

</div>

</body>
</html>