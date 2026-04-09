<?php
session_start();
include("../config.php");
include("function.php");
//check if the user is logged in or not, if not then redirect to index.php
$result = login_checker();
if ($result === 0) {
    header("location:index.php");
    return;
}

$total_price = 0;
$coupon_code = null;
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
    <title>Droplet - CheckOut Page</title>
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg bg-body-tertiary shadow-sm">
            <div class="container-fluid d-flex">
                <img class="navbar-brand" src="image/logo.png" alt=""
                    style="height: 50px; width: 100px; margin-left:55px;">

                <!--check if customer logged in or not and displaying buttons according to it-->


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

    <!--session msg-->
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
                <a href="cart.php" class="text-black-50">My Cart >>></a>
            </div>
            <div class="mb-2">
                <a href="checkout.php" class="text-black-50">Checking Out</a>
            </div>
        </div>

        <div class="container-fluid mt-4">
            <div class="row">
                <!--cart items-->
                <div class="col-md-6 col-lg-5 order-md-last">
                    <h4 class="d-flex justify-content-between align-items-center mb-3">
                        <span>Your Cart Items</span>
                    </h4>
                    <ul class="list-group mb-3">
                        <?php
                        $customer = $_SESSION['customer']['id'];
                        $select_query = mysqli_query($conn, "SELECT * FROM `cart` WHERE user=$customer");
                        if (!mysqli_num_rows($select_query) > 0) {
                            ?>
                            <h3 class="text-center">No Product found in cart</h3>
                            <hr>
                            <?php
                            return;
                        } else {
                            while ($cart = mysqli_fetch_assoc($select_query)) {
                                //as cart database only stores the product and customer id
                                $pid = $cart['product'];
                                $product_select_query = mysqli_query($conn, "SELECT * FROM `product` WHERE id=$pid");
                                $product = mysqli_fetch_assoc($product_select_query);
                                ?>
                                <li class="list-group-item d-flex justify-content-between lh-sm">
                                    <div>
                                        <h6 class="my-0"><?php echo $product['p_title']; ?></h6>
                                        <small class="text-muted">Quantity : <?php echo $cart['quantity']; ?></small>
                                    </div>
                                    <span class="text-muted">Rs. <?php echo $price = $product['p_price'] * $cart['quantity'];
                                    $total_price += $price;
                                    ?></span>
                                </li>
                                <?php
                            }
                        }
                        ?>
                        <?php
                        if (isset($_SESSION['discounted_price']) && isset($_SESSION['coupon'])) {
                            $total_price = $_SESSION['discounted_price'];
                            $coupon_code = $_SESSION['coupon'];
                        }
                        ?>
                        <li class="list-group-item d-flex justify-content-between">
                            <span class="fw-bold">Total (INR)</span>
                            <strong>Rs. <?php echo $total_price; ?></strong>
                        </li>
                    </ul>
                    <?php
                    if(!empty($coupon_code)){
                        ?>
                        <div class="border border-2 text-success text-center mb-2">
                            <h5>Coupon Applied - <?php echo $coupon_code;?></h5>
                        </div>
                        <?php
                    }
                    ?>
                    <?php
                    if(empty($coupon_code)){
                        ?>
                        <form class="card p-2" method="POST" action="coupon_redeem.php">
                            <div class="input-group">
                                <input type="hidden" name="amount" value="<?php echo $total_price; ?>"/>
                                <input type="text" class="form-control" name="coupon" placeholder="Promo code" />
                                <button type="submit" class="btn btn-secondary">Redeem</button>
                            </div>
                        </form>
                        <?php
                    }
                    ?>
                </div>

                <!--shipping address-->
                <div class="col-md-6 col-lg-7">
                    <form id="paymentForm" method="post">
                        <input type="hidden" name="customer" id="customer" value="<?php echo $_SESSION['customer']['id'];?>">
                        <input type="hidden" name="total_amount" id="total_amount" value="<?php echo isset($_SESSION['discounted_price']) ? $_SESSION['discounted_price'] : 0; ?>">
                        <input type="hidden" name="coupon" id="coupon" value="<?php echo isset($_SESSION['coupon']) ? $_SESSION['coupon'] : ''; ?>">
                        <div class="container-fluid mb-4">
                            <h4 class="mb-4">Shipping Address</h4>
                            <div class="row">
                                <?php
                                $customer = $_SESSION['customer']['id'];
                                $select_query = mysqli_query($conn, "SELECT * FROM `address` WHERE user='$customer'");
                                if (!mysqli_num_rows($select_query) > 0) {
                                    $_SESSION['msg'] = "We couldn't find a shipping address for your order.
                                Please add a delivery address to proceed with checkout.";
                                    $_SESSION['type'] = "danger";
                                    ?>
                                    <script>
                                        window.location.href = "http://localhost/droplet/customer/checkout.php";
                                    </script>
                                    <?php
                                    return;
                                } else {
                                    while ($address = mysqli_fetch_assoc($select_query)) {
                                        $user_id = $address['user'];
                                        $user_select_query = mysqli_query($conn, "SELECT * FROM `users` WHERE id='$user_id'");
                                        $user = mysqli_fetch_assoc($user_select_query);
                                        ?>
                                        <div class="col-sm-6">
                                            <div class="form-check mb-2">
                                                <input type="radio" id="<?php echo $address['id'];?>" name="address" value="<?php echo $address['id'];?>" class="form-check-input">
                                                <label for="<?php echo $address['id'];?>">
                                                    <div class="card shadow">
                                                        <div class="card-body">
                                                            <h6><?php echo $user['name']; ?></h6>
                                                            <p><?php echo $address['address'] ?><br><?php echo $address['country'] ?>,<?php echo $address['state'] ?>,<?php echo $address['city'] ?><br><?php echo $address['address_type'] ?>
                                                            </p>
                                                            <div class="d-flex mb-2 gap-3">
                                                                <a href="address_update.php?id=<?php echo $address['id'];?>&from=checkout" class="btn btn-warning btn-sm">Edit</a>
                                                                <a href="checkout.php?id=<?php echo $address['id']; ?>"
                                                                    class="btn btn-danger btn-sm">Delete</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </label><br>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                }
                                ?>
                            </div>
                        </div>
                        <!--payment mode-->
                        <div class="container pt-2 mb-3">
                            <h4 class="mb-3">Payment Mode</h4>
                            <div class="row">
                                <div class="col-sm-6">
                                    <input type="radio" id="cod" name="payment_mode" value="cod"
                                        class="form-check-input" checked>
                                    <label for="cod">Cash On Delivery</label><br>
                                </div>
                                <div class="col-sm-6">
                                    <input type="radio" id="razor" name="payment_mode" value="razor"
                                        class="form-check-input">
                                    <label for="razor">Online Payment</label><br>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3 ">
                            <button type="button" class="btn btn-primary btn-lg shadow btn-block" onclick="submit_Checkout()">Pay Now</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

<script>
    function submit_Checkout() {
    var selectedPayment = document.querySelector('input[name="payment_mode"]:checked');

    if (!selectedPayment) {
        alert("Please select one payment method!!");
        return;
    }

    var selectedAddress = document.querySelector('input[name="address"]:checked');
    if (!selectedAddress) {
        alert("Please select a shipping address!");
        return;
    }
    
    var payment = selectedPayment.value;
    var address = selectedAddress.value;
    var form = document.getElementById('paymentForm');

    if (payment === 'cod') {
        form.action = 'cod_process.php';
        form.submit();
    } else if (payment === 'razor') {
        var customer = document.getElementById('customer').value;
        var amount = document.getElementById('total_amount').value;
        var coupon = document.getElementById('coupon').value;

        var options = {
        key: "rzp_test_LOQW4a93WLPyup",
        amount: amount * 100,
        currency: "INR",
        name: "<?php echo $site_title;?>",
        description: "Test transaction",
        image: "https://cdn.razorpay.com/logos/GhRQcyean79PqE_medium.png",
        notes: { address: "Razorpay Corporate Office" },
        theme: { color: "#3399cc" },
        handler: function (response) {
            jQuery.ajax({
            type: "post",
            url: "rzr_process.php",
            data: {
                payment_mode: payment,
                customer: customer,
                address: address,
                amount: amount,
                payment_id: response.razorpay_payment_id,
                coupon: coupon,
            },
            success: function (response) {
                window.location.href = response;
            }
            });
        }
        };
        var rzp = new Razorpay(options);
        rzp.open();
    }
    }
</script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"
integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>
</body>
</html>

<?php
function delete_address($conn, $id)
{
    $delete_query = "DELETE FROM `address` WHERE id=$id";
    $query = (mysqli_query($conn, $delete_query));
    if ($query) {
        return 1;
    } else {
        return 0;
    }
}
if ($_SERVER['REQUEST_METHOD'] == "GET" && isset($_GET['id'])) {
    $id = $_GET['id'];
    $result = delete_address($conn, $id);
    if ($result == 1) {
        $_SESSION['msg'] = "Address is delected successfully!";
        $_SESSION['type'] = "success";
        ?>
        <script>
            window.location.href = "http://localhost/droplet/customer/checkout.php";
        </script>
        <?php
        return;
    }
}
?>