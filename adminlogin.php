<?php
session_start();
include "config.php";

if(isset($_SESSION['admin'])){
    header('location:admindisplay.php');
}if(isset($_COOKIE['admin'])){
    header('location:admindisplay.php');
}

$query="SELECT * FROM admin";
$chkquery=mysqli_query($conn,$query);
if(!$chkquery){
    $createtbl="CREATE TABLE admin (
        adminid varchar(30),
        adminpass text
    )";
    $chktbl=mysqli_query($conn,$createtbl);
    if(!$chktbl){
        echo mysqli_error($conn);
    }
}
$err = $perr = $emterr = "";
if (isset($_POST['submit'])) {
    
    $adminid = $_POST['userid'];
    $adminpass = $_POST['password'];

    $admindata=mysqli_fetch_assoc($chkquery);
    if (empty($adminid && $adminpass)) {
        $emterr = "* both field required";
    } elseif ($admindata['adminid'] != $adminid) {
        $err = "* userid is not correct";
    } elseif ($admindata['adminpass'] != $adminpass) {
        $perr = "* password incorect";
    } else {
        $_SESSION['admin'] = $admindata['adminid'];
        setcookie('admin',$_SESSION['admin'],time()+900);
        header('location:admindisplay.php');
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
            <h1>Admin Login</h1>
        </div>
        <form action="" method="POST">
            <div class="form-row">
                <div class="form-group col-sm-12">
                    <label>Username :</label>
                    <input type="text" name="userid" class="form-control">
                    <?php echo "<p class='text-danger'>$err</p>"; ?>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-sm-12">
                    <label>Password :</label>
                    <input type="password" name="password" class="form-control">
                    <?php echo "<p class='text-danger'>$perr</p>"; ?>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-sm-12">
                    <input type="submit" name="submit" value="Submit" class="btn btn-info btn1">
                    <a href="adminlogin.php" class="btn btn-danger btn1">Cancel</a>
                    <?php echo "<p class='text-danger'>$emterr</p>"; ?>
                </div>
            </div>
        </form>
    </div>
</body>

</html>