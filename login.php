<?php
session_start();
include "db.php";

if(isset($_POST['login']))
{
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE email=?");
    $stmt->bind_param("s",$email);
    $stmt->execute();

    $result = $stmt->get_result();

    if($result->num_rows==1)
    {
        $row = $result->fetch_assoc();

        if(password_verify($password,$row['password']))
        {
            $_SESSION['id']=$row['id'];
            $_SESSION['name']=$row['name'];
            $_SESSION['role']=$row['role'];

            header("Location: dashboard.php");
            exit();
        }
        else
        {
            echo "<script>alert('Incorrect Password');</script>";
        }
    }
    else
    {
        echo "<script>alert('Email Not Found');</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class="container">

<h2>Login</h2>

<form method="POST">

<input
type="email"
name="email"
placeholder="Enter Email"
required>

<input
type="password"
name="password"
placeholder="Enter Password"
required>

<button
type="submit"
name="login">
Login
</button>

</form>

<p>
<a href="register.php">Create New Account</a>
</p>

</div>

</body>
</html>