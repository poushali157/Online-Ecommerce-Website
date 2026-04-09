<?php
session_start();
include("../config.php");

if($_SERVER['REQUEST_METHOD'] == "POST"){
    $from = $_GET['from']; //either checkout or address page
    $id = $_POST['id'];
    $address = $_POST['address'];
    $country = $_POST['country'];
    $state = $_POST['state'];
    $city = $_POST['city'];
    $zip = $_POST['zip'];
    $address_type = $_POST['address_type'];

    $update_qeury = mysqli_query($conn, "UPDATE `address` SET `address`='$address',`country`='$country',`state`='$state',`city`='$city',`zip`='$zip',`address_type`='$address_type' WHERE id='$id'");

    if($update_qeury){
        $_SESSION['msg'] = "Your Address is updated successfully!!";
        $_SESSION['type'] = "success";
        if ($from == 'checkout') {
            header("Location:checkout.php");
        } else {
            header("Location:address.php");
        }
        return;
    }else{
        $_SESSION['msg'] = "Ooops!! Your Address can't be updated successfully!!";
        $_SESSION['type'] = "danger";
        if ($from == 'checkout') {
            header("Location:checkout.php");
        } else {
            header("Location:address.php");
        }
        return;
    }
}
?>