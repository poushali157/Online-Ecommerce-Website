<?php
session_start();
include("../config.php");
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $customer_id = $_POST['customer_id'];
    $order_id = $_POST['order_id'];
    $order_status = $_POST['order_status'];

    $order_status_update_query = mysqli_query($conn, "UPDATE `orders` SET `order_status`='$order_status' WHERE order_id=$order_id");
    if ($order_status_update_query) {
        $_SESSION['error'] = "Order Status Updated Successfully";
        $_SESSION['type'] = "success";
        header("location:all_orders.php");
        return;
    }
}
?>