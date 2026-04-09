<?php
session_start();
include("../config.php");
include("function.php");
//check if the user is logged in or not, if not then redirect to index.php
$result = login_checker();
if($result === 0){
    $_SESSION['msg'] = "Login First! To add your drink in the cart";
    $_SESSION['type'] = "danger";
    header("location:index.php");
    return;
}

if($_SERVER['REQUEST_METHOD'] == "GET"){
    if(empty($_GET['product-id'])){
        header("location:index.php");
        return;
    }
    $product_id = $_GET['product-id'];
    $user_id = $_SESSION['customer']['id'];

//validate if the product is available or not
    $product_select_query = mysqli_query($conn, "SELECT * FROM `product` WHERE id=$product_id");
    if(!mysqli_num_rows($product_select_query)>0){
        header("location:index.php");
        return;
    }
//check if the product is exists in the cart,according to a specific user id
    $cart_select_query = mysqli_query($conn, "SELECT * FROM `cart` WHERE product=$product_id AND user=$user_id");
    if(mysqli_num_rows($cart_select_query)>0){
        $cart = mysqli_fetch_assoc($cart_select_query);
    //retrive the product quantity from the cart table and update it by one if the product already exists in the cart
        $cart_id = $cart['id'];
        $cart_quantity = $cart['quantity'];
        $cart_quantity += 1;
        $cart_update_query = mysqli_query($conn, "UPDATE `cart` SET `quantity`='$cart_quantity' WHERE id=$cart_id");
        if($cart_update_query){
            $_SESSION['msg'] = "Your Drink is added to your cart successfully!";
            $_SESSION['type'] = "success";
            header("location:index.php");
            return;
        }
    }

    $insert_query = mysqli_query($conn, "INSERT INTO `cart`( `user`, `product`) VALUES ('$user_id','$product_id')");
    if($insert_query){
        $_SESSION['msg'] = "Your Drink is added to your cart successfully!";
        $_SESSION['type'] = "success";
        header("location:index.php");
        return;
    }
    

}
?>