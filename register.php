<?php
include "db.php";

if(isset($_POST['register']))
{
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Check if email already exists
    $check = $conn->prepare("SELECT id FROM users WHERE email=?");
    $check->bind_param("s", $email);
    $check->execute();
    $check->store_result();

    if($check->num_rows > 0)
    {
        echo "<script>alert('Email already exists');</script>";
    }
    else
    {
        $stmt = $conn->prepare("INSERT INTO users(name,email,password) VALUES(?,?,?)");
        $stmt->bind_param("sss", $name, $email, $password);

        if($stmt->execute())
        {
            echo "<script>
                    alert('Registration Successful');
                    window.location='login.php';
                  </script>";
        }
        else
        {
            echo "Registration Failed";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class="container">

<h2>User Registration</h2>

<form method="POST">

<input
type="text"
name="name"
placeholder="Enter Name"
required>

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
name="register">
Register
</button>

</form>

<p>
Already have an account?
<a href="login.php">Login</a>
</p>

</div>

</body>
</html>