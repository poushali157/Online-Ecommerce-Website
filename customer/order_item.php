<?php
session_start();
require_once "function.php";
require_once "../config.php";

if($_SERVER['REQUEST_METHOD'] == "GET"){
    if(!empty($_GET["oid"])){
        $order_id = $_GET["oid"];
        // $select_query = mysqli_query($conn, "SELECT * FROM `order_item` WHERE order_id='$order_id'");
        // if(mysqli_num_rows(result: $select_query)>0){
        //     $data = mysqli_fetch_assoc($select_query);
        // }else{
        //     echo "NO ORDER IS DONE WITH THIS ID !!";
        // }
    }else{
        header("location:all_orders.php");
    }
$total_amount=0;
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
    <title>Droplet - Ordered Items</title>
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
            <a href="index.php" class="text-black-50">Home >></a>
        </div>
        <div class="mb-2">
            <a href="all_orders.php" class="text-black-50">My Orders >>></a>
        </div>
        <div class="mb-2">
            <a href="order_item.php" class="text-black-50">Ordered Items</a>
        </div>
    </div>
    <div class="container mt-5 mb-2">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Product Image</th>
                        <th scope="col">Product Name</th>
                        <th scope="col">Price</th>
                        <th scope="col">Quantity</th>
                        <th scope="col">Manufacturing Date</th>
                        <th scope="col">Expiry Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $select_query = mysqli_query($conn, "SELECT * FROM `order_item` WHERE order_id='$order_id'");
                    if(mysqli_num_rows(result: $select_query)>0){
                      while($data = mysqli_fetch_assoc($select_query)){
                        $pid = $data['product'];
                        $product_query = mysqli_query($conn, "SELECT * FROM `product` WHERE id='$pid'");
                        $product = mysqli_fetch_assoc($product_query);
                        $total_price = $product['p_price'] * $data['quantity']; // Calculate per-product total
                          ?>
                          <tr>
                              <td><img src="<?php echo $product['p_img'];?>" alt="" style="height:80px; width:80px"></td>
                              <td><?php echo $product['p_title'];?></td>
                              <td><?php echo $total_price;?></td>
                              <td><?php echo $data['quantity'];?></td>
                              <td><?php echo $product['m_date'];?></td>
                              <td><?php echo $product['exp_date'];?></td>
                          </tr>
                          <?php
                      }
                    }
                    ?>
                    </tbody>
            </table>
        </div>
        <div class="container d-flex justify-content-between mt-3">
            <div class="mb-5">
                <h4>Total Amount : <?php 
                $select_query = mysqli_query($conn, "SELECT * FROM `orders` WHERE order_id = '$order_id'");
                $order = mysqli_fetch_assoc($select_query);
                echo $order['order_amount'];
                ?></h4>
            </div>  
            <div class="mb-3">
                <?php
                $select_query =mysqli_query($conn, "SELECT * FROM `orders` WHERE order_id = '$order_id'");
                $order = mysqli_fetch_assoc($select_query);
                if(strtolower($order['payment_status']) === "cancelled"){
                    ?>
                    <h4>Order Cancelled</h4>
                    <?php
                }else{
                    ?>
                    <a href="update_order.php?oid=<?php echo $order['order_id'];?>" class="btn btn-danger btn-lg shadow">Cancel Order</a>
                    <?php
                }
                ?>
            </div>
        </div>
        <div class="container mt-5 mb-4">
            <h6 class="text-danger"><b>Important : </b> In case of cancellation of a prepaid order, the refund will be processed automatically and credited to the customer’s account within <b>2 working days</b>.</h6>
        </div>
    </div>
</div>

<?php
include("common_footer.php");
?>