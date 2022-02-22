<?php
$conn = mysqli_connect("localhost","root","");
if($conn){
    
    if(!mysqli_select_db($conn,"db1")){
        $createdb = "CREATE DATABASE db1";
        if(mysqli_query($conn,$createdb)){
            mysqli_select_db($conn,"db1") ;
        }
    }
}
else{
   echo mysqli_connect_error();
}
?>