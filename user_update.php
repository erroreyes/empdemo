<?php
session_start();
include "config.php";
if (!isset($_COOKIE['email'])) {
    header('location:index.php');
}
if (!isset($_SESSION['email'])) {
    $_SESSION['email'] = $_COOKIE['email'];
}
$id = $_GET['id'];
$query = "SELECT * FROM employee1 where id=$id";
$result = mysqli_query($conn, $query);
$data = mysqli_fetch_assoc($result);
$err = $dojerr = $agerr = $emailerr = $passerr = $cpasserr = $imgerr = $salerr = "";
if (isset($_POST['update'])) {
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
        $agerr = "alpha value not allow";
    } elseif (empty($_POST['salary'])) {                                //salary
        $err = "value is required";
    } elseif (empty($_POST['hobby'])) {
        $err = "value is required";
    } elseif (preg_match("/[A-Za-z]/", $_POST['salary'])) {
        $salerr = "alpha value not allow";
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
    } elseif (empty($filesize)) {
        $imgerr = "imgfile must be required";
    } else {
        $idd = $data['id'];
        $fname = $_POST['fname'];
        $lname = $_POST['lname'];
        $doj = $_POST['doj'];
        $dept = $_POST['dept'];
        $gender = $_POST['gender'];
        $age = $_POST['age'];
        $salary = $_POST['salary'];
        $hobby = $_POST['hobby'];
        $chkstr = implode(',', $hobby);
        $email = $_POST['email'];
        $pwd = base64_encode($_POST['pass']);
        $confirmpwd =  base64_encode($_POST['confirm']);
        $target_dir = "imgfile/";
        $imgpath = $target_dir . basename($_FILES['file']['name']);
        $moveimg = move_uploaded_file($_FILES['file']['tmp_name'], $imgpath);
        $update = "UPDATE EMPLOYEE1 SET fname='$fname',lname='$lname',doj='$doj',department='$dept',gender='$gender',age='$age',salary='$salary',hobby='$chkstr',email='$email',pwd='$pwd',image='$imgpath' where id=$id";
        $updatereslt = mysqli_query($conn, $update);
        if ($updatereslt) {
            header("location:dashboard.php");
        } else {
            echo mysqli_error($conn);
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
    <title>REGISTRATION</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <style>
        .container {
            color: gold;
        }
    </style>
</head>

<body>
    <div class=" p-3"></div>
    <div class="container w-75 bg-dark">
        <div class="row  justify-content-center p-3">
            <h1 class="col col-md-6">Registration Form</h1>
        </div>
        <form action="" method="post" enctype="multipart/form-data">
            <div class="form-row ">
                <div class="form-group col-sm-6">
                    <label>Fname :</label>
                    <input type="text" name="fname" class="form-control" value="<?php echo $data['fname']; ?>">
                    <?php echo "<p class='text-danger'>$err</p>"; ?>
                </div>
                <div class="form-group col-md-6">
                    <label>Lname :</label>
                    <input type="text" name="lname" class="form-control" value="<?php echo $data['lname']; ?>">
                </div>
                <?php echo "<p class='text-danger'>$err</p>"; ?>
            </div>
            <div class="form-row justify-content-center">
                <div class="form-group col-md-4"><br>
                    <label>Gender :</label>
                    <input type="radio" name="gender" value="male" <?php if ($data['gender']  == 'male') { ?>checked<?php } ?>> Male
                    <input type="radio" name="gender" value="female" <?php if ($data['gender']  == 'female') { ?>checked<?php } ?>> Female
                    <?php echo "<p class='text-danger'>$err</p>"; ?>
                </div>
                <div class="form-group col-md-4">
                    <label>DOJ :</label>
                    <input type="date" name="doj" class="form-control" value="<?php echo $data['doj']; ?>">
                    <?php echo "<p class='text-danger'>$err</p>";
                    echo "<p class='text-danger'>$dojerr</p>"; ?>
                </div>

                <div class="form-group col-md-4">
                    <label>Age :</label>
                    <input type="text" name="age" class="form-control" value="<?php echo $data['age']; ?>">
                    <?php echo "<p class='text-danger'>$err</p>";
                    echo "<p class='text-danger'> $agerr</p>"; ?>
                </div>


            </div>
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label>Salary :</label>
                    <input type="text" name="salary" class="form-control" value="<?php echo $data['salary']; ?>">
                    <?php echo "<p class='text-danger'>$err</p>";
                    echo "<p class='text-danger'>$salerr</p>";
                    ?>
                </div>
                <div class="form-group col-md-4">
                    <label>Department :</label>
                    <select name="dept" class="form-control">
                        <option value="sale" <?php if (isset($data['department'])) {
                                                    if ($data['department'] == 'sale')
                                                        echo 'selected';
                                                } ?>>Sale</option>
                        <option value="purchase" <?php if (isset($data['department'])) {
                                                        if ($data['department'] == 'purchase')
                                                            echo 'selected';
                                                    } ?>>Purchase</option>
                        <option value="red" <?php if (isset($data['department'])) {
                                                if ($data['department'] == 'red')
                                                    echo 'selected';
                                            } ?>>RED</option>
                        <option value="marketing" <?php if (isset($data['department'])) {
                                                        if ($data['department'] == 'marketing')
                                                            echo 'selected';
                                                    } ?>>Marketing</option>
                    </select>
                    <?php echo "<p class='text-danger'>$err</p>"; ?>
                </div>
                <div class="form-group col-md-4">
                    <label>Image :</label>
                    <div class="custom-file">

                        <input type="file" id="customfile" class="custom-file-input" name="file" value="<?php echo $data['image']; ?>">
                        <label class="custom-file-label" id="customfile">choose image file</label>
                        <?php echo "<p class='text-danger'>$imgerr</p>"; ?>
                    </div>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label>Email :</label>
                    <input type="text" name="email" class="form-control" value="<?php echo $data['email']; ?>">
                    <?php echo "<p class='text-danger'>$err</p>";
                    echo "<p class='text-danger'> $emailerr</p>"; ?>
                </div>
                <div class="form-group col-md-3">
                    <label>Password :</label>
                    <input type="password" name="pass" class="form-control" value="<?php echo base64_decode($data['pwd']); ?>">
                    <?php echo "<p class='text-danger'>$err</p>";
                    echo "<p class='text-danger'> $passerr</p>"; ?>
                </div>
                <div class="form-group col-md-3">
                    <label>Confirm Password :</label>
                    <input type="password" name="confirm" class="form-control" value="<?php echo base64_decode($data['pwd']); ?>">
                    <?php echo "<p class='text-danger'>$err</p>";
                    echo "<p class='text-danger'> $cpasserr</p>"; ?>

                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-2 ">
                    <label>Hobby:</label>
                </div>
                <div class="form-group col-md-6">
                    <input class="form-check-input" type="checkbox" name="hobby[]" value="football" <?php if (in_array('football', explode(',', $data['hobby']))) {
                                                                                                        echo 'checked';
                                                                                                    } ?>> Football <br>
                    <input class="form-check-input" type="checkbox" name="hobby[]" value="Cricket" <?php if (in_array('Cricket', explode(',', $data['hobby']))) {
                                                                                                        echo 'checked';
                                                                                                    } ?>> Cricket <br>
                    <input class="form-check-input" type="checkbox" name="hobby[]" value="Dancing" <?php if (in_array('Dancing', explode(',', $data['hobby']))) {
                                                                                                        echo 'checked';
                                                                                                    } ?>> Dancing <br>
                    <input class="form-check-input" type="checkbox" name="hobby[]" value="Singing" <?php if (in_array('Singing', explode(',', $data['hobby']))) {
                                                                                                        echo 'checked';
                                                                                                    } ?>> Singing
                    <?php echo "<p class='text-danger'>$err</p>"; ?>
                </div>
                <div class="form-group col-md-4  "><br><br>
                    <input type="submit" value="update" name="update" class="btn btn-info">
                    <a href="registration.php" class="btn btn-danger ">reset</a>
                </div>
            </div>

            <br>
        </form>
    </div>

</body>

</html>