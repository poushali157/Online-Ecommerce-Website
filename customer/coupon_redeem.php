<?php
session_start();
include("../config.php");

if($_SERVER['REQUEST_METHOD'] == "POST"){
    $coupon_code = $_POST['coupon'];
    $amount = $_POST['amount'];

    $select_query = mysqli_query($conn, "SELECT * FROM `coupons` WHERE code='$coupon_code'");
    if(!mysqli_num_rows($select_query)>0){
        $_SESSION['msg'] = "Oops! That coupon code isn’t valid. Please double-check and try again.";
        $_SESSION['type'] = "warning";
        header("location:checkout.php");
        return;
    }
    $coupon = mysqli_fetch_assoc($select_query);
    $coupon_name = $coupon['code'];
    $today_date = date("Y-m-d");

    // if($_SESSION['coupon'] === $coupon_code){
    //     $_SESSION['coupon'] = $_SESSION['coupon']; //it won't delete even after refreshing the page
    //     $_SESSION['discounted_price'] = $_SESSION['discounted_price'];
    //     $_SESSION['msg'] = "$coupon_name already applied once!!";
    //     $_SESSION['type'] = "warning";
    //     header("location:checkout.php");
    //     return;
    // }

    if($today_date>$coupon['exp_date']){
        $_SESSION['msg'] = "This coupon has expired. Visit our promotions page to see the latest available discounts.";
        $_SESSION['type'] = "danger";
        header("location:checkout.php");
        return;
    }else{
        $discount_amt = ($amount * $coupon['percentage']) / 100;
        $price = $amount - $discount_amt;
        $_SESSION['discounted_price'] = $price;
        $_SESSION['coupon'] = $coupon_name;
        $_SESSION['msg'] = "Congratulations! You've saved Rs.$discount_amt on your order with the applied discount.";
        $_SESSION['type'] = "success";
        header("location:checkout.php");
        return;
    }
    
}

?>