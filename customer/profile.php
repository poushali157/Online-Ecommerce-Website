<?php
session_start();
include("../config.php");
include("function.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="common_css.css">
    <title>Droplet - Profile Page</title>
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg bg-body-tertiary shadow-sm">
            <div class="container-fluid d-flex">
                <img class="navbar-brand" src="image/logo.png" alt=""
                    style="height: 50px; width: 100px; margin-left:55px;">

                <!-- Toggle Button for Offcanvas -->
                <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas"
                    data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <!-- Offcanvas Sidebar Menu -->
                <div class="offcanvas offcanvas-end " tabindex="-1" id="offcanvasNavbar"
                    aria-labelledby="offcanvasNavbarLabel">
                    <div class="offcanvas-header">
                        <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Menu</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                    </div>
                    <div class="offcanvas-body">
                        <ul class="navbar-nav mx-auto gap-3">
                            <li class="nav-item">
                                <a class="nav-link" href="index.php">Home</a>
                            </li>
                            <li class="nav-item">
                                <div class="dropdown">
                                    <button class="btn btn-light dropdown-toggle" type="button"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        Categories
                                    </button>
                                    <ul class="dropdown-menu">
                                        <?php
                                        $category_select_query = mysqli_query($conn, "SELECT * FROM `category` WHERE 1");
                                        if (mysqli_num_rows($category_select_query) > 0) {
                                            while ($category_list = mysqli_fetch_assoc($category_select_query)) {
                                                ?>
                                                <li><a class="dropdown-item mb-2"
                                                        href="category.php?id=<?php echo $category_list['id']; ?>"><?php echo $category_list['category_title']; ?></a>
                                                </li>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </ul>
                                </div>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">About</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">Contact</a>
                            </li>
                        </ul>
                        <hr>
                        <?php
                        $result = login_checker();
                        if ($result === 0) {
                            ?>
                            <div class="d-flex gap-3" style=" margin-right: 60px;">
                                <a href="../auth/login.php" class="btn btn-outline-dark">Login</a>
                                <a href="../auth/register.php" class="btn btn-outline-dark">Register</a>
                            </div>
                            <?php
                        } else {
                            ?>
                            <div class="d-flex gap-3" style=" margin-right: 30px;">
                                <div>
                                    <a class="btn btn-outline-dark" href="cart.php">
                                        <i class="fa-solid fa-cart-shopping"></i>
                                        Cart
                                        <span class="badge bg-dark text-white me-1 rounded-pill">
                                            <?php
                                            $user = $_SESSION['customer']['id'];
                                            $result = get_cart_item($conn, $user);
                                            echo $result;
                                            ?>
                                        </span>
                                    </a>
                                </div>
                                <div class="dropdown">
                                    <button class="btn btn-dark dropdown-toggle" type="button" data-bs-toggle="dropdown"
                                        aria-expanded="false">
                                        <?php echo $_SESSION['customer']['name']; ?>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="profile.php">
                                                My Profile</a></li>
                                        <li><a class="dropdown-item" href="all_orders.php">
                                                My Orders</a></li>
                                        <li><a class="dropdown-item" href="address.php">
                                                My Address</a></li>
                                        <li><a class="dropdown-item" href="../auth/logout.php">Logout</a></li>
                                    </ul>
                                </div>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
        </nav>
    </header>
<!--sub-header-->
    <div class="container d-flex gap-2 mt-5">
        <div class="mb-2 text-black-50">
            <i class="fa-solid fa-house"></i>
            <a href="index.php" class="text-black-50">Home >>></a>
        </div>
        <div class="mb-2">
            <a href="profile.php" class="text-black-50">My Profile</a>
        </div>
    </div>

    <div class="container-fluid mt-2 mb-3">
        <h2 class="text-center fw-bold">My Profile</h2>
    </div>
    
    <div class="container-fluid">
        <!--sesssion msg-->
        <div class="container mt-2">
            <?php
            if (isset($_SESSION['msg']) && isset($_SESSION['type'])) {
                ?>
                <div class="alert alert-<?php echo $_SESSION['type']; ?> alert-dismissible fade show" role="alert">
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    <strong><?php echo $_SESSION['msg'];
                    $_SESSION['msg'] = null;
                    $_SESSION['type'] = null;
                    //as session_unset claers all the session variable which redirects the page to login page.
                    ?>
                    </strong>
                </div>
                <script>
                    var alertList = document.querySelectorAll(".alert");
                    alertList.forEach(function (alert) {
                        new bootstrap.Alert(alert);
                    });
                </script>
                <?php
            }
            ?>
        </div>
        <div class="container mt-4">
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-4">
                        <h4 class="fw-semibold">Profile Picture</h4>
                    </div>
                    <div class="mb-4">
                        <?php
                        $user_id = $_SESSION['customer']['id'];
                        $select_query = mysqli_query($conn, "SELECT * FROM `user_info` WHERE user_id='$user_id'");
                        if(mysqli_num_rows($select_query)>0){
                            $data = mysqli_fetch_assoc($select_query);
                            ?>
                            <img src="<?php echo $data['img'];?>" alt="" style="height:310px; width: 310px">
                            <?php
                        }
                        ?>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-4 pt-3">
                        <h4 class="fw-semibold">Basic Information</h4>
                    </div>
                    <div class="table-responsive">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td class="fw-bold">Name : </td>
                                    <td><?php echo $_SESSION['customer']['name'];?></td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Email : </td>
                                    <td><?php echo $_SESSION['customer']['email'];?></td>
                                </tr>
                                <?php
                                $user_id = $_SESSION['customer']['id'];
                                $select_query = mysqli_query($conn, "SELECT * FROM `user_info` WHERE user_id='$user_id'");
                                $user = mysqli_fetch_assoc($select_query);
                                if(empty($user['ph_no']) && empty($user['dob']) && empty($user['gender'])){
                                    ?>
                                    <tr>
                                        <td class="pt-4">
                                            <a href="user_info.php" class="btn btn-success">Add Information</a>
                                        </td>
                                    </tr>
                                    <?php
                                }else{
                                    ?>
                                    <tr>
                                        <td class="fw-bold">Phone Number : </td>
                                        <td><?php echo $user['ph_no'];?></td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">Date Of Birth : </td>
                                        <td><?php echo $user['dob'];?></td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">Gender : </td>
                                        <td><?php echo $user['gender'];?></td>
                                    </tr>
                                    <tr>
                                        <td class="pt-4">
                                            <a href="profile_update.php?id=<?php echo $user['id'];?>" class="btn btn-success">Update Profile</a>
                                        </td>
                                    </tr>
                                    <?php
                                }
                                //"UPDATE `users` SET `ph_no`='[value-4]',`dob`='[value-5]',`gender`='[value-6]' WHERE 1"
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php
include("common_footer.php")
?>