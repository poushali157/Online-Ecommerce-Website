<?php
session_start();
include("../config.php");

if($_SERVER['REQUEST_METHOD'] == "POST"){
    $id = $_POST['id'];
    $ph_no = $_POST['ph_no'];
    $dob = $_POST['dob'];
    $gender = $_POST['gender'];
    $updated_image_name = $_FILES['img']['name'];
    $updated_image_tmp_name = $_FILES['img']['tmp_name'];
    $file_path = "../user_image/".$updated_image_name;

    if ($updated_image_name == "") {
        $update_query = mysqli_query($conn, "UPDATE `user_info` SET `ph_no`='$ph_no',`dob`='$dob',`gender`='$gender' WHERE id=$id");
        
        if ($update_query){
            $_SESSION['msg'] = "Your Profile is Updated Successfully!!";
            $_SESSION['type'] = "success";
            header("location:profile.php");
            return;
        } 
    }
    $update_query_with_image = mysqli_query($conn, "UPDATE `user_info` SET `ph_no`='$ph_no',`dob`='$dob',`gender`='$gender',`img`='$file_path' WHERE id='$id'");
    if ($update_query_with_image){
        move_uploaded_file($updated_image_tmp_name, $file_path);
        $_SESSION['msg'] = "Your Profile Updated Successfully!!";
        $_SESSION['type'] = "success";
        header("location:profile.php");
        return;
    } 
}
?>