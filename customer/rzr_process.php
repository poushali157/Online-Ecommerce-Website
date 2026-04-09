<?php
session_start();
include("../config.php");
if($_SERVER['REQUEST_METHOD'] == "POST"){
    $order_id = rand(1111111111, 9999999999);
    $order_amount =$_POST['amount'];
    $coupon = $_POST['coupon'];
    $address = $_POST['address'];
    $user = $_POST['customer'];
    $payment_id = $_POST['payment_id'];
    $payment_mode = $_POST['payment_mode'];


    if(empty($address)){
        $_SESSION['msg'] = "Kindly select an shipping address before checkout!!";
        $_SESSION['type'] = "warning";
        header("location:checkout.php");
        return;
    }
        
    $insert_query= mysqli_query($conn, "INSERT INTO `orders`(`order_id`, `user`, `order_address`, `order_amount`, `coupon`, `payment_type`, `payment_id`, `payment_status` ) VALUES ('$order_id','$user','$address','$order_amount','$coupon','$payment_mode','$payment_id','Paid')");

    if($insert_query){
        $select_query = mysqli_query($conn, "SELECT * FROM `cart` WHERE user = '$user'");
        if(mysqli_num_rows($select_query)>0){
            while($cart_data = mysqli_fetch_assoc($select_query)){
                $product = $cart_data['product'];
                $quantity = $cart_data['quantity'];
                $order_item_insert_query = mysqli_query($conn, "INSERT INTO `order_item`( `order_id`, `product`, `quantity`) VALUES ('$order_id','$product','$quantity')");
            }
        }
        if($order_item_insert_query){
            $_SESSION['coupon'] = null;
            $_SESSION['discounted_price'] = null;
            $cart_empty_query = mysqli_query($conn, "DELETE FROM `cart` WHERE user = '$user'");
            if($cart_empty_query){
                echo "thanku.php?oid=$order_id&order_amount=$order_amount&opid=$payment_id";
                exit;
            }
        } 
    }    
}  
?>