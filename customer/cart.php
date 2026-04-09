<?php
session_start();
include("../config.php");
include("function.php");
//check if the user is logged in or not, if not then redirect to index.php
$result = login_checker();
if($result === 0){
    header("location:index.php");
    return;
}
$total_price = 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="common_css.css">
    <title>Droplet - Cart</title>
</head>
<body>   
<header>
    <nav class="navbar navbar-expand-lg bg-body-tertiary shadow-sm">
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
          <a href="cart.php" class="text-black-50">My Cart</a>
      </div>
  </div>

  <div class="container-fluid mt-4 shadow-lg">
      <div class="row">
      <div class="col-md-8">
        <div class="table-responsive">
          <table class="table mt-3">
            <thead>
              <tr>
                <th>Product</th>
                <th>Title</th>
                <th>Quantity</th>
                <th>Price</th>
                <th colspan="2" class="text-center">Action</th>
              </tr>
            </thead>
            <tbody>
              <?php
                $customer = $_SESSION['customer']['id'];
                $select_query = mysqli_query($conn, "SELECT * FROM `cart` WHERE user=$customer");
                if(!mysqli_num_rows($select_query)>0){
                  ?>
                  <h3 class="text-center">No Product found in cart</h3><hr>
                  <?php
                  return ;
                }
                else{
                  while($cart = mysqli_fetch_assoc($select_query)){
                  //as cart database only stores the product and customer id
                  $pid = $cart['product'];
                  $product_select_query = mysqli_query($conn, "SELECT * FROM `product` WHERE id=$pid");
                  $product = mysqli_fetch_assoc($product_select_query);
                  ?>
                  <tr>
                    <form action="cart_update.php" method="post">
                      <input type="hidden" name="cart" value="<?php echo $cart['id'];?>">
                      <td>
                        <div>
                          <img src="<?php echo $product['p_img'];?>" style="height: 100px; width:80px" alt="No Image Found">
                        </div>
                      </td>
                      <td>
                        <?php echo $product['p_title'];?>
                      </td>
                      <td>
                        <input name="quantity" type="number" class="form-control" value="<?php echo $cart['quantity'];?>">
                      </td>
                      <td>
                        Rs. <?php echo $price = $product['p_price']*$cart['quantity'];
                        $total_price += $price;
                        ?>
                      </td>
                      <td>
                        <button class="btn btn-outline-primary btn-sm" type="submit">Update</button>
                      </td>
                      <td>
                          <a class="btn btn-outline-danger btn-sm" href="cart.php?id=<?php echo $cart['id'];?>">Remove</a>
                      </td>
                    </form>
                  </tr>
                  <?php
                  }
                }
              ?> 
            </tbody>
          </table>
        </div>
      </div>
      <div class="col-md-4">
        <div class="container mt-3 mb-4 bg-body-tertiary shadow-sm">
          <div class="mb-2">
            <h3 class="text-center">Checkout Details</h3><hr>
          </div>
          <div class="d-flex justify-content-around">
            <div class="mb-3"><h5>Sub Total :</h5></div>
            <div class="mb-3"><h5>Rs. <?php echo $total_price;?></h5></div>
          </div>
          <div class="d-flex justify-content-around">
            <div class="mb-3"><h5>Shipping : </h5></div>
            <div class="mb-3"><h5> Free</div>
          </div><hr>
          <div class="d-flex justify-content-around mb-2">
            <div class="mb-3"><h5>Sub Total :</h5></div>
            <div class="mb-3"><h5>Rs. <?php echo $total_price;?></h5></div>
          </div>
          <div class="mb-3 d-grid">
            <a href="checkout.php" class="btn btn-dark shadow">Proceed To CheckOut</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>
</body>
</html>

<?php
function delete_cart_product($conn, $id){
    $delete_query = "DELETE FROM `cart` WHERE id=$id";
    $query = (mysqli_query($conn, $delete_query));
    if($query){
        return 1;
    }else{
        return 0;
    }
}
if($_SERVER['REQUEST_METHOD'] == "GET" && isset($_GET['id'])){
    $id = $_GET['id'];
    $result = delete_cart_product($conn, $id);
    if($result == 1){
        $_SESSION['msg'] = "Product is deleted successfully from Your Cart!";
        $_SESSION['type'] = "success";
        ?>
        <script>
          window.location.href = "http://localhost/droplet/customer/cart.php";
        </script>
        <?php
    }
}
?>