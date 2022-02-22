<?php

include "config.php";
session_start();
if(isset($_SESSION['id'])){
    header('location:dashboard.php');
}
if(isset($_COOKIE['email'])){
    header('location:dashboard.php');
}

$query = "SELECT * FROM employee1";
$err = $dojerr = $agerr = $emailerr = $passerr = $cpasserr = $imgerr = $salerr = "";
if (isset($_POST['submit'])) {

    if (!mysqli_query($conn, $query)) {
        $createtbl = "CREATE TABLE  EMPLOYEE1(
        id int(3) auto_increment primary key,
        fname varchar(30),
        lname varchar(30),
        doj date,
        department varchar(20),
        gender varchar(20),
        age int(3),
        salary int(5),
        hobby varchar(60),
        email varchar(20),
        pwd text,
        confirmpwd text,
        image longblob
    )";
        $tblchk = mysqli_query($conn, $createtbl);
        if (!$tblchk) {
            echo mysqli_error($conn);
        }
    }
    $filesize = $_FILES['file']['size'];
    $uppercase = preg_match("/[A-Z]/", $_POST['pass']);
    $lowercase = preg_match("/[a-z]/", $_POST['pass']);
    $number = preg_match("/[0-9]/", $_POST['pass']);
    if (empty($_POST['fname'])) {                                   //fname
        $err = "value is required";
    } elseif (empty($_POST['lname'])) {                                //lname
        $err = "value is required";
    } elseif (empty($_POST['doj'])) {                                //date
        $err = "value is required";
    } elseif ($_POST['doj'] > date('Y-m-d')) {
        $dojerr = "not valid future date";
    } elseif (empty($_POST['dept'])) {                                //department
        $err = "value is required";
    } elseif (empty($_POST['gender'])) {                                //gender
        $err = "value is required";
    } elseif (empty($_POST['age'])) {                                //age
        $err = "value is required";
    } elseif ($_POST['age'] < 0) {
        $agerr = "minus value not allow";
    } elseif (preg_match("/[A-Za-z]/", $_POST['age'])) {
        $agerr = "minus value not allow";
    } elseif (empty($_POST['salary'])) {                                //salary
        $err = "value is required";
    } elseif (empty($_POST['hobby'])) {
        $err = "value is required";
    } elseif (preg_match("/[A-Za-z]/", $_POST['salary'])) {
        $agerr = "alpha value not allow";
    } elseif ($_POST['salary'] < 0) {
        $salerr = "minus value not allow";
    } elseif (empty($_POST['email'])) {                                //email
        $err = "value is required";
    } elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $emailerr = "not valid email";
    } elseif (empty($_POST['pass'])) {                                //password
        $err = "value is required";
    } elseif (strlen($_POST['pass']) < 8 || !$uppercase || !$lowercase || !$number || strlen($_POST['pass']) > 8) {
        $passerr = "minimum 1 small,1 capital,1 digit, length is 8";
    } elseif (empty($_POST['confirm'])) {                                   //confirm password
        $err = "value is required";
    } elseif ($_POST['pass'] != $_POST['confirm']) {
        $cpasserr = "not same as password";
    } elseif ($filesize > 1000000) {                                           //image
        $imgerr = "imgfile must be less than 1mb";
    } else {
        $fname = $_POST['fname'];
        $lname = $_POST['lname'];
        $doj = $_POST['doj'];
        $dept = $_POST['dept'];
        $gender = $_POST['gender'];
        $age = $_POST['age'];
        $salary = $_POST['salary'];
        $hobby = $_POST['hobby'];
        $chkstr = implode(",", $hobby);
        $email = $_POST['email'];
        $pwd = base64_encode($_POST['pass']);
        $confirmpwd = base64_encode($_POST['confirm']);
        $target_dir = "imgfile/";
        $imgpath = $target_dir . basename($_FILES['file']['name']);
        $moveimg = move_uploaded_file($_FILES['file']['tmp_name'], $imgpath);
        $Emailqery = "SELECT * FROM EMPLOYEE1 where email = '$email'";                                 //unique email
        $Emailqerychk = mysqli_query($conn, $Emailqery);
        $present = mysqli_num_rows($Emailqerychk);
        if ($present > 0) {
            $emailerr = "already exist";
        } else {
            $insert = "INSERT INTO EMPLOYEE1(`fname`,`lname`,`doj`,`department`,`gender`,`age`,`salary`,`hobby`,`email`,`pwd`,`image`) values('$fname','$lname','$doj','$dept','$gender','$age','$salary','$chkstr','$email','$pwd','$imgpath')";
            $reslt = mysqli_query($conn, $insert);
            if ($reslt) {
                header("location:admindisplay.php");
            } else {
                echo mysqli_error($conn);
            }
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <style>
        .container {
            color: gold;
        }
    </style>
</head>

<body>

    <div class="container-fluid h-100">
        <ul class="nav bg-warning row">
            <li class="nav-item col-auto">
                <a href="index.php" class="nav-link text-warning bg-dark">HOME</a>
            </li>
        </ul>
    </div>
    <div class="container w-75 bg-dark">
        <div class="row  justify-content-center p-3">
            <h1 class="col col-md-6">Registration Form</h1>
        </div>
        <form action="" method="post" enctype="multipart/form-data">
            <div class="form-row ">
                <div class="form-group col-sm-6">
                    <label>Fname :</label>
                    <input type="text" name="fname" class="form-control" value="<?php if (isset($_POST['fname'])) {
                                                                                    echo $fname = $_POST['fname'];
                                                                                } ?>">
                    <?php echo "<p class='text-danger'>$err</p>"; ?>
                </div>
                <div class="form-group col-md-6">
                    <label>Lname :</label>
                    <input type="text" name="lname" class="form-control" value="<?php if (isset($_POST['lname'])) {
                                                                                    echo $lname = $_POST['lname'];
                                                                                } ?>">
                    <?php echo "<p class='text-danger'>$err</p>"; ?>
                </div>
            </div>
            <div class="form-row justify-content-center">
                <div class="form-group col-md-4"><br>
                    <label>Gender :</label>
                    <input type="radio" name="gender" value="male" <?php if (isset($_POST['gender'])) {if($_POST['gender']=='male')
                                                                        echo  'checked';
                                                                    } ?>> Male
                    <input type="radio" name="gender" value="female" <?php if (isset($_POST['gender'])) {if($_POST['gender']=='female')
                                                                            echo 'checked';
                                                                        } ?>> Female
                    <?php echo "<p class='text-danger'>$err</p>"; ?>
                </div>
                <div class="form-group col-md-4">
                    <label>DOJ :</label>
                    <input type="date" name="doj" class="form-control" value="<?php if (isset($_POST['doj'])) {
                                                                                    echo $doj = $_POST['doj'];
                                                                                } ?>">
                    <?php echo "<p class='text-danger'>$err</p>";
                    echo "<p class='text-danger'>$dojerr</p>"; ?>
                </div>

                <div class="form-group col-md-4">
                    <label>Age :</label>
                    <input type="text" name="age" class="form-control" value="<?php if (isset($_POST['age'])) {
                                                                                    echo $fname = $_POST['age'];
                                                                                } ?>">
                    <?php echo "<p class='text-danger'>$err</p>";
                    echo "<p class='text-danger'> $agerr</p>"; ?>
    
                </div>


            </div>
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label>Salary :</label>
                    <input type="text" name="salary" class="form-control" value="<?php if (isset($_POST['salary'])) {
                                                                                        echo $salary = $_POST['salary'];
                                                                                    } ?>">
                    <?php echo "<p class='text-danger'>$err</p>";
                    ?>
                </div>
                <div class="form-group col-md-4">
                    <label>Department :</label>
                    <select name="dept" class="form-control">
                        <option value="sale" <?php if (isset($_POST['dept'])) {if($_POST['dept']=='sale')
                                                    echo 'selected';
                                                } ?>>Sale</option>
                        <option value="purchase" <?php  if (isset($_POST['dept'])) {if($_POST['dept']=='purchase')
                                                    echo 'selected';
                                                    } ?>>Purchase</option>
                        <option value="red" <?php if (isset($_POST['dept'])) {if($_POST['dept']=='red')
                                                    echo 'selected';
                                            } ?>>RED</option>
                        <option value="marketing" <?php if (isset($_POST['dept'])) {if($_POST['dept']=='marketing')
                                                    echo 'selected';
                                                    } ?>>Marketing</option>
                    </select>
                    <?php echo "<p class='text-danger'>$err</p>"; ?>
                </div>
                <div class="form-group col-md-4">
                    <label>Image :</label>
                    <div class="custom-file">

                        <input type="file" id="customfile" class="custom-file-input" name="file" value="<?php if (isset($_POST['fname'])) {
                                                                                                            echo $fname = $_POST['fname'];
                                                                                                        } ?>">
                        <label class="custom-file-label" id="customfile">choose image file</label>
                        <?php echo "<p class='text-danger'>$err</p>";
                        echo "<p class='text-danger'> $agerr</p>"; ?>
                    </div>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label>Email :</label>
                    <input type="text" name="email" class="form-control" value="<?php if (isset($_POST['email'])) {
                                                                                    echo $email = $_POST['email'];
                                                                                } ?>">
                    <?php echo "<p class='text-danger'>$err</p>";
                    echo "<p class='text-danger'> $emailerr</p>"; ?>
                </div>
                <div class="form-group col-md-3">
                    <label>Password :</label>
                    <input type="password" name="pass" class="form-control" value="<?php if (isset($_POST['pass'])) {
                                                                                        echo $pass = $_POST['pass'];
                                                                                    } ?>">
                    <?php echo "<p class='text-danger'>$err</p>";
                    echo "<p class='text-danger'> $passerr</p>"; ?>
                </div>
                <div class="form-group col-md-3">
                    <label>Confirm Password :</label>
                    <input type="password" name="confirm" class="form-control" value="<?php if (isset($_POST['confirm'])) {
                                                                                            echo $confirmpwd = $_POST['confirm'];
                                                                                        } ?>">
                    <?php echo "<p class='text-danger'>$err</p>";
                    echo "<p class='text-danger'> $cpasserr</p>"; ?>

                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-2 ">
                    <label>Hobby:</label>
                </div>
                <div class="form-group col-md-6">
                    <input class="form-check-input" type="checkbox" name="hobby[]" value="football" <?php if (isset($_POST['hobby']) && in_array('football', $_POST['hobby'])) {
                                                                                                        echo 'checked';
                                                                                                    } ?>> Football <br>
                    <input class="form-check-input" type="checkbox" name="hobby[]" value="Cricket" <?php if (isset($_POST['hobby']) && in_array('Cricket', $_POST['hobby'])) {
                                                                                                        echo 'checked';
                                                                                                    } ?>> Cricket <br>
                    <input class="form-check-input" type="checkbox" name="hobby[]" value="Dancing" <?php if (isset($_POST['hobby']) && in_array('Dancing', $_POST['hobby'])) {
                                                                                                        echo 'checked';
                                                                                                    } ?>> Dancing <br>
                    <input class="form-check-input" type="checkbox" name="hobby[]" value="Singing" <?php if (isset($_POST['hobby']) && in_array('Singing', $_POST['hobby'])) {
                                                                                                        echo 'checked';
                                                                                                    } ?>> Singing
                    <?php echo "<p class='text-danger'>$err</p>";?>
                </div>
                <div class="form-group col-md-4  "><br><br>
                    <input type="submit" value="Submit" name="submit" class="btn btn-info">
                    <a href="add_user.php" class="btn btn-danger ">reset</a><br>
                    Already have an account <a href="userlogin.php">Login here</a>
                </div>
            </div>

            <br>
        </form>
    </div>
</body>

</html>