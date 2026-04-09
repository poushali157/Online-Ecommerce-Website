<?php
session_start();
include("../config.php");

if($_SERVER['REQUEST_METHOD'] == "POST"){
    $user_id = $_POST['id'];
    $ph_no = $_POST['ph_no'];
    $dob = $_POST['dob'];
    $gender = $_POST['gender'];
    $image_name = $_FILES['img']['name'];
    $image_tmp_name = $_FILES['img']['tmp_name'];
    $file_path = "../user_image/".$image_name;

    if (empty($ph_no) || empty($dob) || empty($gender) || empty($image_name)){
        $_SESSION['error'] = "Please Fill all the Fields Correctly!!";
        $_SESSION['type'] = "warning";
        header("location:admin_info.php");
        return;
    }

    if(move_uploaded_file($image_tmp_name,$file_path)){
        $insert_query = mysqli_query($conn, "INSERT INTO `user_info`( `user_id`, `ph_no`, `dob`, `gender`, `img`) VALUES ('$user_id','$ph_no','$dob','$gender','$file_path')");
        if($insert_query){
            $_SESSION['error'] = "You've successfully added your information to your profile!!";
            $_SESSION['type'] = "success";
            header("location:admin_profile.php");
            return;
        }else{
            $_SESSION['error'] = "Oops, something went wrong, please try again!";
            $_SESSION['type'] = "danger";
            header("location:admin_info.php");
            return;
        }
    }
}

?>