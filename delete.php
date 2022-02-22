<?php
include "config.php";
$id = $_GET['iddel'];
$delete = "DELETE FROM EMPLOYEE1 WHERE id=$id";
$reslt = mysqli_query($conn,$delete);
if(!$reslt){
 echo mysqli_error($conn);
}
header('location:admindisplay.php');
?>