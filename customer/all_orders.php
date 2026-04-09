<?php
session_start();
include("function.php");
include("../config.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Link Swiper's CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <link rel="stylesheet" href="common_css.css">
    <title>Droplet - Your Orders</title>
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
                  <a class="nav-link active" aria-current="page" href="index.php">Home</a>
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

<div class="container mt-5">
<!--sub-header-->
  <div class="container d-flex gap-2">
      <div class="mb-2 text-black-50">
          <i class="fa-solid fa-house"></i>
          <a href="index.php" class="text-black-50">Home >>></a>
      </div>
      <div class="mb-2">
          <a href="all_orders.php" class="text-black-50">My Order</a>
      </div>
  </div>

    <div class="table-responsive mt-3 mb-5">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Order ID</th>
                    <th scope="col">Order Amount</th>
                    <th scope="col">Coupon Used</th>
                    <th scope="col">Order Address</th>
                    <th scope="col">Order Status</th>
                    <th scope="col">Payment Type</th>
                    <th scope="col">Payment ID</th>
                    <th scope="col">Payment Status</th>
                    <th scope="col">Order Date</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <?php 
            $user= $_SESSION['customer']['id'];
            $select_query = mysqli_query($conn, "SELECT * FROM `orders` WHERE user='$user'");
            if(mysqli_num_rows($select_query)>0){
                while($order = mysqli_fetch_assoc($select_query)){
                    $address=$order['order_address'];
                    $address_select_query = mysqli_query($conn,"SELECT * FROM `address` WHERE id='$address'");
                    if($address_select_query){
                    $order_address = mysqli_fetch_assoc($address_select_query);
                    }

                    ?>
                    <tbody>
                        <tr>
                            <td><?php echo $order['order_id'];?></td>  
                            <td><?php echo $order['order_amount'];?></td>
                            <td><?php echo $order['coupon'];?></td>
                            <td><?php echo $order_address['address_type'];?></td>
                            <td class="<?php echo strtolower($order['order_status']) === 'cancelled' ? 'text-danger' : 'text-dark' ?>"><b><?php echo $order['order_status'] ?></b></td>
                            <td><?php echo $order['payment_type'];?></td>
                            <td><?php echo $order['payment_id'];?></td>
                            <td class="<?php echo strtolower($order['payment_status']) === 'cancelled' ? 'text-danger' : (strtolower($order['payment_status']) === 'pending' ? 'text-success' : 'text-dark') ?>"><b><?php echo $order['payment_status'] ?></b></td>
                            <td><?php echo $order['date'];?></td>
                            <td>
                              <a href="order_item.php?oid=<?php echo $order['order_id'];?>" class="btn btn-success btn-sm">View Items</a> 
                            </td>
                        </tr>
                    </tbody>
                    <?php
                }
            }
            ?>
        </table>
    </div>
</div>

<!--footer-->
<?php
include("common_footer.php");
?>
