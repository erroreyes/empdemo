<?php
session_start();
setcookie('email',$email,time()-300);
setcookie('password',$pass,time()-300);
 session_unset();
session_destroy();

header('location:userlogin.php');


 ?>