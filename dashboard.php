<?php
session_start();
include "config.php";

if (!isset($_COOKIE['email'])) {
    header('location:index.php');
}
if (!isset($_SESSION['email'])) {
    $_SESSION['email'] = $_COOKIE['email'];
}
$id = $_SESSION['email'];
$sql = "SELECT * FROM EMPLOYEE1 where email='$id'";
$sqlchk = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($sqlchk);
$idd=$fname=$lname=$email=$pass=$gender=$doj=$department=$hobby=$salary=$age=$img="";
if ($row > 0) {
    
        $idd = $row['id'];
        $fname = $row['fname'];
        $lname = $row['lname'];
        $email = $row['email'];
        $pass = base64_decode($row['pwd']);
        $gender = $row['gender'];
        $doj = $row['doj'];
        $department = $row['department'];
        $hobby = $row['hobby'];
        $salary = $row['salary'];
        $age = $row['age'];
        $img = $row['image'];
    }


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <style>
        body,
        html {
            height: 100%;
        }
    </style>
</head>

<body>
    <div class="container-fluid ">
        <div class="h-100">
            <ul class="nav bg-warning row">
                <li class="nav-item  col-2  text-center">
                    <a href="user_logout.php" class="nav-link text-warning bg-dark">Logout</a>
                </li>
                <li class="col col-10 text-right"><?php echo $email; ?></li>
            </ul>
        </div>
        <div class="p-3"></div>
        <div class="row h-100  justify-content-center ">
            <table class="table table-striped table-dark w-50 table-bordered table-hover">
                <tbody>
                    <tr>
                        <td>ID</td>
                        <td><?php echo $idd; ?></td>
                    </tr>
                    <tr>
                        <td>FNAME</td>
                        <td><?php echo $fname; ?></td>
                    </tr>
                    <tr>
                        <td>LNAME</td>
                        <td><?php echo $lname; ?></td>
                    </tr>
                    <tr>
                        <td>DOJ</td>
                        <td><?php echo $doj; ?></td>
                    </tr>
                    <tr>
                        <td>DEPARTMENT</td>
                        <td><?php echo $department; ?></td>
                    </tr>
                    <tr>
                        <td>GENDER</td>
                        <td><?php echo $gender; ?></td>
                    </tr>
                    <tr>
                        <td>AGE</td>
                        <td><?php echo $age; ?></td>
                    </tr>
                    <tr>
                        <td>SALARY</td>
                        <td><?php echo $salary; ?></td>
                    </tr>
                    <tr>
                        <td>HOBBY</td>
                        <td><?php echo $hobby; ?></td>
                    </tr>
                    <tr>
                        <td>EMAIL</td>
                        <td><?php echo $email; ?></td>
                    </tr>
                    <tr>
                        <td>PASSWORD</td>
                        <td><?php echo $pass; ?></td>
                    </tr>
                    <tr>
                        <td>IMAGE</td>
                        <td><img src="<?php echo $img; ?>" width="50px"></td>
                    </tr>
                    <tr>
                        <td>OPERATIOS</td>
                        <td><a class="text-warning" href="user_update.php?id=<?php echo $idd; ?>">Edit</a></td>
                    </tr>


                </tbody>

            </table>
        </div>
    </div>
    <p>hello i'm here</p>
</body>

</html>