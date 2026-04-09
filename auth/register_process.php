<?php
session_start();
include("../config.php");

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $cpassword = $_POST['cpassword'];

    //check if all fields are filled otherwise send alert using session
    if (empty($name)) {
        $_SESSION['error'] = "User name is missing!!";
        $_SESSION['type'] = "danger";
        header("location:register.php");
        return;
    } elseif (empty($email)) {
        $_SESSION['error'] = "Email is missing!!";
        $_SESSION['type'] = "danger";
        header("location:register.php");
        return;
    } elseif (empty($password)) {
        $_SESSION['error'] = "Password is missing!!";
        $_SESSION['type'] = "danger";
        header("location:register.php");
        return;
    } elseif (empty($cpassword)) {
        $_SESSION['error'] = "Please write your password again!!";
        $_SESSION['type'] = "danger";
        header("location:register.php");
        return;
    }

    //check if both the passwords are matched
    if (!($password === $cpassword)) {
        $_SESSION['error'] = "Password and Confirm password are not matched properly !";
        $_SESSION['type'] = 'warning';
        header("location:register.php");
        return;
    }

    //changing the password into hash
    $enc_password = password_hash($password, PASSWORD_DEFAULT);

    //user given email is present or not, if exists then user cant register with same email
    $select_query = mysqli_query($conn, "SELECT * FROM `users` WHERE email='$email'");
    if ((mysqli_num_rows($select_query) > 0)) {
        $_SESSION['error'] = "User with $email exists already ! Register with different Email";
        $_SESSION['type'] = "warning";
        header("location:register.php");
        return;
    }

    function register($conn, $name, $email, $password)
    {
        $insert_query = mysqli_query($conn, "INSERT INTO `users`(`name`, `email`, `password`) VALUES ('$name','$email','$password')");
        if ($insert_query) {
            return 1;
        } else {
            return 0;
        }
    }
    //insert data in the database
    $result = register($conn, $name, $email, $enc_password);
    if ($result == 1) {
        $_SESSION['error'] = "Account created successfully! Login Now .";
        $_SESSION['type'] = 'success';
        header("location:login.php");
        return;
    } else {
        $_SESSION['error'] = "User with $email, not created due to some issue";
        $_SESSION['type'] = "danger";
        header("location:register.php");
        return;
    }
}
?>