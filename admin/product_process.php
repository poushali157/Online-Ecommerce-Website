<?php
include("../config.php");
session_start();

if($_SERVER['REQUEST_METHOD']=="POST"){
    $category = $_POST['category'];
    $p_title = $_POST['p_title'];
    $p_description = $_POST['p_description'];
    $price = $_POST['price'];
    $company = $_POST['company'];
    $mdate = $_POST['mdate'];
    $edate = $_POST['edate'];
    $about = $_POST['about'];
    $pimage_name = $_FILES['pimage']['name'];
    $pimage_tmp_name =$_FILES['pimage']['tmp_name'];
    $file_path = "../product_image/".time().$pimage_name;
    #combining image name and time together
    if(move_uploaded_file($pimage_tmp_name,$file_path)){
        $insert_query = mysqli_query($conn, "INSERT INTO `product`( `category`, `p_title`, `p_description`, `p_price`, `company`, `m_date`, `exp_date`, `p_img`, `about`) VALUES ('$category','$p_title','$p_description','$price','$company','$mdate','$edate','$file_path','$about')");
        if($insert_query){
            $_SESSION['msg'] = "[$p_title] is added successfully!";
            $_SESSION['type'] = "success";
            header("location:add_product.php");
            return ;
        }
    }
}
?>