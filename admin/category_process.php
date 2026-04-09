<?php
include("../config.php");
session_start();

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $ctitle = $_POST['ctitle'];
    $cdescription = $_POST['cdescription'];
    $cimage_name = $_FILES['cimage']['name'];
    $cimage_tmp_name =$_FILES['cimage']['tmp_name'];
    $file_path = "../category_image/".$cimage_name;
    //if any field is empty
    if (empty($ctitle) || empty($cdescription)) {
        $_SESSION['error'] = "All fields are required. Please complete the fields before submitting.";
        $_SESSION['type'] = "warning";
        header("location:add_category.php");
        return;
    }
}
if (move_uploaded_file($cimage_tmp_name, $file_path)) {
    $insert_query = mysqli_query($conn, "INSERT INTO `category`( `category_title`, `category_description`, `photo`) VALUES ('$ctitle','$cdescription','$file_path')");
    if ($insert_query) {        //if insert query works,
        $_SESSION['error'] = "New Category $ctitle is added Successfully !";
        $_SESSION['type'] = "success";
        header("location:add_category.php");
        return;
    }
}
?>

