<?php
session_start();
include("../config.php");

if($_SERVER['REQUEST_METHOD'] == "POST"){
    $id = $_POST['id'];
    $update_category = $_POST['update_category'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $company = $_POST['company'];
    $about = $_POST['about'];
    $e_date = $_POST['e_date'];
    $m_date = $_POST['m_date'];
    $updated_image_name = $_FILES['img']['name'];
    $updated_image_tmp_name = $_FILES['img']['tmp_name'];
    $file_path = "../product_image/".$updated_image_name;

    if ($updated_image_name == "") {
        $update_query = mysqli_query($conn, "UPDATE `product` SET `category`='$update_category',`p_title`='$title',`p_description`='$description',`p_price`='$price',`company`='$company',`m_date`='$m_date',`exp_date`='$e_date',`about`='$about' WHERE id='$id'");
        
        if ($update_query){
            $_SESSION['error'] = "Your Product is Updated Successfully!!";
            $_SESSION['type'] = "success";
            header("location:all_product.php");
            return;
        } 
    }
    $update_query_with_image = mysqli_query($conn, "UPDATE `product` SET `category`='$update_category',`p_title`='$title',`p_description`='$description',`p_price`='$price',`company`='$company',`m_date`='$m_date',`exp_date`='$e_date',`p_img`='$file_path',`about`='$about' WHERE id='$id'");
    if ($update_query_with_image){
        move_uploaded_file($updated_image_tmp_name, $file_path);
        $_SESSION['error'] = "Your Product Updated Successfully!!";
        $_SESSION['type'] = "success";
        header("location:all_product.php");
        return;
    } 
}
?>