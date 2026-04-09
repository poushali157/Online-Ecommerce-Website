<?php
session_start();
include("../config.php");

if($_SERVER['REQUEST_METHOD'] == "POST"){
    $code = $_POST['code'];
    $percentage = $_POST['percentage'];
    $exp_date = $_POST['exp_date'];
    $created_on = $_POST['created_on'];

    //add validation
    if(empty($code) || empty($percentage) || empty($exp_date) || empty($created_on)){
        $_SESSION['msg'] = "All fields are required. Please complete the fields before submitting.";
        $_SESSION['type'] = "warning";
        header("location:add_coupon.php");
        return;
    }
    $insert_query = mysqli_query($conn, "INSERT INTO `coupons`(`code`, `percentage`, `exp_date`, `created_on`) VALUES ('$code','$percentage','$exp_date','$created_on')");
    if($insert_query){
        $_SESSION['msg'] = "Coupon $code is created successfully!";
        $_SESSION['type'] = "success";
        header("location:add_coupon.php");
        return;
    }
}
?>