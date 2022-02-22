<?php
session_start();
include "config.php";

if (isset($_POST['submit'])) {
    $email = $_POST['userid'];
    $pass = $_POST['password'];
    $sql = "SELECT * FROM EMPLOYEE1 WHERE email='$email'";

    $sqlchk = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($sqlchk);
    setcookie('email', $email, time() + 300);
    setcookie('password', $pass, time() + 300);
    if (mysqli_num_rows($sqlchk) > 0) {
        $_SESSION['email'] = $row['email'];
        header('location:dashboard.php');
    } else {
        echo "invalid email password";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <title>Document</title>
    <style>
        .container {
            color: gold;
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <ul class="nav bg-warning row">
            <li class="nav-item col-auto">
                <a href="index.php" class="nav-link text-warning bg-dark">HOME</a>
            </li>
        </ul>
    </div>
    <div class=" p-5"></div>
    <div class="container w-50 bg-dark  h-100 p-2">
        <div class="row  justify-content-center p-3">
            <h1 class="col col-md-4">Login</h1>
        </div>

        <form action="" method="POST">
            <div class="form-row">
                <div class="form-group col-sm-12">
                    <label>Username :</label>
                    <input type="text" name="userid" class="form-control">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-sm-12">
                    <label>Password :</label>
                    <input type="password" name="password" class="form-control">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-sm-12">
                    <input type="submit" name="submit" value="Signin" class="btn btn-warning ">
                    <a href="userlogin.php" class="btn btn-danger">Cancel</a><br>
                    Don't have an account <a href="registration.php">Register</a>
                </div>
        </form>
    </div>
</body>

</html>