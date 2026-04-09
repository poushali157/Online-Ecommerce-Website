<?php
session_start();
include("../config.php");

if($_SERVER['REQUEST_METHOD'] == "POST"){
    $user = $_POST['user'];
    $address = $_POST['address'];
    $country = $_POST['country'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $zip = $_POST['zip'];
    $address_type = $_POST['address_type'];

    //add validation
    if(empty($address) || empty($country) || empty($city) || empty($state) || empty($zip) || empty($address_type)){
        $_SESSION['msg'] = "All fields are required. Please complete the fields to add a new address.";
        $_SESSION['type'] = "warning";
        header("location:address.php");
        return;
    }
    $insert_query = mysqli_query($conn, "INSERT INTO `address`(`user`,`address`, `country`, `state`, `city`, `zip`, `address_type`) VALUES ('$user','$address','$country','$state','$city','$zip','$address_type')");
    if($insert_query){
        $_SESSION['msg'] = "New Address is created successfully!";
        $_SESSION['type'] = "success";
        header("location:address.php");
        return;
    }
}
?>