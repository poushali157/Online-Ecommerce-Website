<?php
session_start();
include("function.php");
include("../config.php");

if($_SERVER['REQUEST_METHOD'] == "GET"){
    if(!empty($_GET["id"])){
        $id = $_GET["id"];
        $select_query = mysqli_query($conn, "SELECT * FROM `product` WHERE id=$id");
        if(mysqli_num_rows($select_query)>0){
            $data = mysqli_fetch_assoc($select_query);
        }else{
            echo "NO DATA FOUND WITH THIS ID !";
        }
    }else{
        header("location:index.php");
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="common_css.css">
    <title>Droplet - Product Details</title>
</head>
<body>

<header>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
      <div class="container-fluid d-flex">
        <img class="navbar-brand" src="image/logo.png" alt="" style="height: 50px; width: 100px; margin-left:55px;">

        <!--check if customer logged in or not and displaying buttons according to it-->
        
        
        <!-- Toggle Button for Offcanvas -->
        <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar"
            aria-controls="offcanvasNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <!-- Offcanvas Sidebar Menu -->
        <div class="offcanvas offcanvas-end " tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
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
                      <button class="btn btn-light dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Categories
                      </button>
                      <ul class="dropdown-menu">
                      <?php
                        $category_select_query = mysqli_query($conn, "SELECT * FROM `category` WHERE 1");
                        if(mysqli_num_rows($category_select_query)>0){
                          while($category_list = mysqli_fetch_assoc($category_select_query)){
                            ?>
                            <li><a class="dropdown-item mb-2" href="category.php?id=<?php echo $category_list['id'];?>"><?php echo $category_list['category_title'];?></a></li>
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
              </ul><hr>
              <?php
                $result = login_checker();
                if($result === 0){
                  ?>
                  <div class="d-flex gap-3" style=" margin-right: 60px;">
                    <a href="../auth/login.php" class="btn btn-outline-dark">Login</a>
                    <a href="../auth/register.php" class="btn btn-outline-dark">Register</a>
                </div>
                <?php
                }else{
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
                      <button class="btn btn-dark dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
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

<div class="container mt-5">
    <!--sub-header-->
    <div class="container d-flex gap-2">
        <div class="mb-2 text-black-50">
            <i class="fa-solid fa-house"></i>
            <a href="index.php" class="text-black-50">Home >>></a>
        </div>
        <div class="mb-2">
            <a href="Product_details.php" class="text-black-50">Product Detail</a>
        </div>
    </div>
    
    <!--product Detail-->
    <div class="row mt-3">
        <div class="col-md-5">
            <img src="<?php echo $data['p_img'];?>" alt="" style="height: 550px; width: 400px; margin-left:55px;">
        </div>
        <div class="col-md-7">
            <div class="mb-3">
                <h1><?php echo $data["p_title"];?></h1>
            </div>
            <div class="mb-3">
                <h6><?php echo $data["p_description"];?></h6>
            </div>
            <div class="d-flex mb-3 gap-3">
                <h4><?php echo $data["company"];?> - </h4>
                <div class="mt-1">
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                </div>
            </div>
            <div class="mb-3">
                <h3 class="text-primary fw-bolder">Rs. <?php echo $data["p_price"];?></h3>
                <h6 class="fw-light">Inclusive of all taxes</h6>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <h6>Packed On - <?php echo $data["m_date"];?></h6>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <h6>Expiration Date (EXP) - <?php echo $data["exp_date"];?></h6>
                    </div>
                </div>
            </div>
            <div class="mb-3"><hr>
                <ul>
                    <li>Free Delivery on All Orders</li>
                    <li>Orders Delivered in 15 minutes</li>
                    <li>Cash on Delivery Available</li>
                    <li>Eco-friendly and minimal packaging</li>
                    <li>Schedule deliveries at your preferred time and location available</li>
                </ul>
            </div>
            <div class="mb-3"><hr>
                <h6>About The Product :</h6>
                <p><?php echo $data["about"];?></p>
            </div>
            <div class="mb-3">
                <a href="add_to_cart.php?product-id=<?php echo $data['id'];?>" class="btn btn-primary" style="width:150px; height:40px; font-size:18px;">Add To Cart</a>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>
</body>
</html>