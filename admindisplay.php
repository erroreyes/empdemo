<?php
session_start();
include "config.php";
if (!$_COOKIE['admin']) {
    header('locatin:index.php');
}
if (!$_SESSION['admin']) {
    $_SESSION['admin'] = $_COOKIE['admin'];
}
$query = "SELECT * FROM EMPLOYEE1";
$reslt = mysqli_query($conn, $query);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">

</head>

<body>
    <div class="container-fluid ">
        <div class="h-100">
            <ul class="nav bg-warning row">
                <li class="nav-item  col-2  text-center">
                    <a href="admin_logout.php" class="nav-link text-warning bg-dark">Logout</a>
                </li>
                <li class="nav-item  col-2  text-center">
                    <a href="add_user.php" class="nav-link text-warning bg-dark">Add User</a>
                </li>
                <li class="text-right col-8"><?php echo $_SESSION['admin']; ?></li>
            </ul>
        </div>
        <div class="p-2"></div>
       
        <select class="btn btn-warning btn-md dropdown-toggle mr-3">
            <option  href="#" id="id">ID</option>
            <option  href="#">FNAME</option>
            <option  href="#">LNAME</option>
            <option  href="#">DOJ</option>
            <option  href="#">DEPARTMENT</option>
            <option  href="#">GENDER</option>
            <option  href="#">AGE</option>
            <option  href="#">SALARY</option>
            <option  href="#">HOBBY</option>
            <option href="#">EMAIL</option>
            <option  href="#">PASSWORD</option>
        </select>
         <input type="text" class=" text-center mr-3" placeholder="search...">
        <input type="button" class="btn btn-outline-info btn-sm" value="search">

    </div>
    <div class="p-2"></div>
    <div class="table-responsive">
        <table class="table table-bordered table-striped table-dark">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>FNAME</th>
                    <th>LNAME</th>
                    <th>DOJ</th>
                    <th>DEPARTMENT</th>
                    <th>GENDER</th>
                    <th>AGE</th>
                    <th>SALARY</th>
                    <th>HOBBY</th>
                    <th>EMAIL</th>
                    <th>PASSWORD</th>
                    <th>IMAGE</th>
                    <th colspan="2">OPERATIOS</th>

                </tr>
            </thead>
            <tbody>
                <?php while ($data = mysqli_fetch_assoc($reslt)) { ?>
                    <tr>
                        <td><?php echo $data['id']; ?></td>
                        <td><?php echo $data['fname']; ?></td>
                        <td><?php echo $data['lname']; ?></td>
                        <td><?php echo $data['doj']; ?></td>
                        <td><?php echo $data['department']; ?></td>
                        <td><?php echo $data['gender']; ?></td>
                        <td><?php echo $data['age']; ?></td>
                        <td><?php echo $data['salary']; ?></td>
                        <td><?php echo $data['hobby']; ?></td>
                        <td><?php echo $data['email']; ?></td>
                        <td><?php echo base64_encode($data['pwd']); ?></td>
                        <td><img src="<?php echo $data['image']; ?>" width="50px"></td>
                        <td><a class="text-warning" href="update.php?id=<?php echo $data['id']; ?>">Edit</a></td>
                        <td><a class="text-danger" href="delete.php?iddel=<?php echo $data['id']; ?>">Delete</a></td>

                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
    </div>

</body>

</html>