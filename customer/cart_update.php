<?php
session_start();
include("../config.php");
include("function.php");
//check if the user is logged in or not, if not then redirect to index.php
$result = login_checker();
if($result === 0){
    header("location:index.php");
    return;
}
if($_SERVER['REQUEST_METHOD'] == "POST"){
    $cart = $_POST['cart'];
    $quantity = $_POST['quantity'];
    if(!($quantity >= 1)){
        $_SESSION['msg'] = "Minimum quantity should be 1. You must keep atleast 1 item in your cart.";
        $_SESSION['type'] = "danger";
        header("location:cart.php");
        return;
    }
    $cart_update_query = mysqli_query($conn, "UPDATE `cart` SET `quantity`='$quantity' WHERE id=$cart");
    if($cart_update_query){
        $_SESSION['msg'] = "Your cart is updated Successfully!";
        $_SESSION['type'] = "success";
        header("location:cart.php");
        return;
    }
}
?>