<?php
session_start();
include("../config.php");

    if($_SERVER['REQUEST_METHOD'] == "POST"){
        $email = $_POST['email'];
        $password = $_POST['password'];

        //form validation
        if(empty($email)){
        $_SESSION['error'] = "Your Email is missing!!";
        $_SESSION['type'] = "danger";
        header("location:login.php");
        return;
        }elseif(empty($password)){
            $_SESSION['error'] = "Your Password is missing!!";
            $_SESSION['type'] = "danger";
            header("location:login.php");
            return;
        }
        //check if the email is available or not
        $select_query = mysqli_query($conn, "SELECT * FROM `users` WHERE email='$email'");
        if ($select_query) {
            $num_rows = mysqli_num_rows($select_query);

            if(!($num_rows)>0){
            $_SESSION['error'] = "User with $email doesn't exists, Register Now!! ";
            $_SESSION['type'] = "warning";
            header("location:register.php");
            return;
            }
        }
        //match the password
        $user = mysqli_fetch_assoc($select_query);
        if(password_verify($password, $user['password'])){
            if($user['user_type'] == "customer"){
                $_SESSION['customer'] = $user;
                header("location:../customer/index.php");
                return;
            }else{
                $_SESSION['admin'] = $user;
                header("location:../admin/dashboard.php");
                return;
            }
        }else{
            $_SESSION['error'] = "Wrong password, try again !!";
            $_SESSION['type'] = "danger";
            header("location:login.php");
            return;
        }


    }
?>