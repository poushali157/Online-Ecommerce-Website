<?php
session_start();
include("function.php");
include("../config.php");

if($_SERVER['REQUEST_METHOD'] == "GET"){
    if(!empty($_GET["oid"])){
        $order_id = $_GET["oid"];
        $update_query = mysqli_query($conn, "UPDATE `orders` SET `payment_status`='Cancelled', `order_status`='Cancelled' WHERE order_id='$order_id'");
        if($update_query){
            $_SESSION['msg'] = "Order Cancelled Successfully!!";
            $_SESSION['type'] = "success";
            header("location:all_orders.php");
            return;
        }
    }
}
?>