<?php
    include("../config.php");
    session_start();
    if(!isset($_SESSION['admin'])){
        header("location:../auth/login.php");
    }
?>