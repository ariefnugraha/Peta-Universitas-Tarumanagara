<?php
    include "config.php";

    if(isset($_POST['submit'])) {
        $email = mysqli_real_escape_string($conn,$_POST['email']);
        $password = mysqli_real_escape_string($conn,$_POST['password']);

        $user = mysqli_query($conn,"SELECT 'id', 'email', 'password' FROM admin WHERE email = '$email'");
        $userFetch = mysqli_fetch_assoc($user);

        if(mysqli_num_rows($user) == 1) {
            if(password_verify($password,$userFetch['password'])) {
                $_SESSION['id'] = $userFetch['id'];
                header("location:dashboard.php");
            } else {
                $_SESSION['false'] = "Email atau Password Salah";
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login Admin</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="css/login.css">
</head>
<body>
    <main class="container">
        <form method="post">
            <input type="email" class="form-control" name="email" placeholder="Email..." required>
            <input type="password" class="form-control" name="password" placeholder="Password" required>
            <button type="submit" name="submit" class="btn">login</button>
        </form>
    </main>
</body>
</html>