<?php
session_start();
setcookie('admin',$_SESSION['admin'],time()-900);
session_unset();
session_destroy();
header('location:index.php');
?>