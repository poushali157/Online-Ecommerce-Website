<?php
session_start();
include("../config.php");
include("function.php");
if($_SERVER['REQUEST_METHOD'] == "GET"){
    if(!empty($_GET["id"])){
        $id = $_GET["id"];
        $category_select_query = mysqli_query($conn, "SELECT * FROM `category` WHERE id=$id");
        if(mysqli_num_rows($category_select_query)>0){
            $category = mysqli_fetch_assoc($category_select_query);
        }else{
            echo "NO CATEGORY FOUND WITH THIS ID !";
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
    <title>Droplet - Category</title>
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

<!--all products-->
<div class="container-fluid mt-4 mb-5">
  <div class="heading text-center mb-3">
      <h2 class="fw-bold"><?php echo $category['category_title'];?></h2>
  </div>
  <div class="container-fluid pt-1">
    <div class="row">
      <?php
        $id = $category['id'];
        $product_select_query = mysqli_query($conn, "SELECT * FROM `product` WHERE category=$id");
        if(mysqli_num_rows($product_select_query)>0){
          while($product = mysqli_fetch_assoc($product_select_query)){
          ?>
              <div class="col-md-4 col-lg-2 col-sm-6">
                <div class="card mb-3 d-flex flex-column">
                    <div class="img-wrapper " style="flex-grow: 1;">
                      <img src="<?php echo $product['p_img'];?>" class="" alt="...">
                    </div>
                    <div class="card-body d-flex flex-column">
                      <div class="text-center mb-2"><b><a href="Product_details.php?id=<?php echo $product['id'];?>"><?php echo $product['p_title'];?><br>-<?php echo $product['company'];?></a></b></div>
                      <div class="text-center mb-3"><h5>Rs. <?php echo $product['p_price'];?></h5>Inclusive of all taxes</div>
                      <a class="btn btn-outline-primary" href="add_to_cart.php?product-id=<?php echo $product['id'];?>">ADD TO CART</a>
                    </div>
                </div> 
              </div>
            <?php
          }
        }
      ?>
      
      
    </div>
  </div>
</div>

<!--footer-->
<?php
include("common_footer.php")
?>