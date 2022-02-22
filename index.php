<?php
session_start();
include "config.php";
if(isset($_SESSION['id']) || isset($_COOKIE['email'])){
    header('location:dashboard.php');
}

if(isset($_SESSION['admin']) || isset($_COOKIE['admin'])){
    header('location:admindisplay.php');
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
        html,body{
            height: 100%;
        }
        body{
            background-image: url("imgfile/backimg.jpg");
            background-repeat: no-repeat;
            background-size: cover;
        
        }

    </style>
</head>

<body >
<div class="container-fluid h-100">
        <ul class="nav bg-warning row">
            <li class="nav-item col-auto">
                <a href="index.php" class="nav-link text-warning bg-dark">HOME</a>
            </li>
        </ul>
        <div class="row justify-content-center align-items-center h-100">
            <div class="col col-lg-2">
            <a href="registration.php" class="btn btn-outline-warning btn-lg w-75 p-3 font-weight-bold">Register</a>
            </div>
            <div class="col col-lg-2">
            <a href="adminlogin.php" class="btn btn-outline-warning btn-lg w-75 p-3 font-weight-bold">Admin</a>
            </div>
            
        </div>

    </div>

</body>

</html>