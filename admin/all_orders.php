<?php
include("admin_middleware.php");
include("admin_header.php");
?>

<div class="container">
    <div class="p-1 mb-3">
        <h3>All Orders</h3>
        <?php
        if (isset($_SESSION['error']) && isset($_SESSION['type'])) {
            ?>
            <div class="alert alert-<?php echo $_SESSION['type']; ?> alert-dismissible fade show " role="alert">
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                <strong><?php echo $_SESSION['error'];
                $_SESSION['error'] = null; 
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
    <div class="container">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                    <th>Customer Name</th>
                    <th>Customer Email</th>
                    <th>Contact No.</th>
                    <th>Order Date</th>
                    <th>Order ID</th>
                    <th>Order Amount</th>
                    <th>Cupon Used</th>
                    <th>Order Address</th>
                    <th>Payment Type</th>
                    <th>Payment Status</th>
                    <th>Payment ID</th>
                    <th>Order Status</th>
                    <th>Order update</th>
                    <th colspan="3" class="text-center">Action</th>
                </tr>
                </thead>
                <?php
                $select_query = mysqli_query($conn, "SELECT * FROM `orders` WHERE 1");
                if(mysqli_num_rows($select_query)>0){
                    while($order = mysqli_fetch_assoc($select_query)){
                        $user_id = $order['user'];
                        $user_query = mysqli_query($conn, "SELECT * FROM users WHERE id = '$user_id'");
                        $user = mysqli_fetch_assoc($user_query);

                        $info_query = mysqli_query($conn, "SELECT * FROM user_info WHERE user_id = '$user_id'");
                        $info = mysqli_fetch_assoc($info_query);

                        $address_query = mysqli_query($conn, "SELECT * FROM `address` WHERE user='$user_id'");
                        $address = mysqli_fetch_assoc($address_query);
                        ?>
                        <tbody>
                            <tr>
                                <td class="p-3"><?php echo $user['name'];?></td>
                                <td class="p-3"><?php echo $user['email'];?></td>
                                <td class="p-3"><?php echo(!empty($info['ph_no']) ? $info['ph_no'] : 'No Data Yet');?></td>
                                <td class="p-3"><b><?php echo $order['date'];?></b></td>
                                <td class="p-3"><?php echo $order['order_id'];?></td>
                                <td class="p-3"><?php echo $order['order_amount'];?></td>
                                <td class="p-3"><?php echo $order['coupon'];?></td>
                                <td class="p-3"><?php echo $address['address'];?></td>
                                <td class="p-3"><?php echo $order['payment_type'];?></td>
                                <?php
                                $order_status = strtolower($order['order_status']);

                                // Auto-update payment status in database if order is delivered
                                if ($order_status === 'order-delivered' && $order['payment_status'] !== 'Paid') {
                                    mysqli_query($conn, "UPDATE orders SET payment_status = 'Paid' WHERE order_id = '{$order['order_id']}'");
                                    $order['payment_status'] = 'Paid'; // also update locally to reflect instantly
                                }
                                ?>
                                <td class="<?php echo strtolower($order['payment_status']) === 'pending' ? 'text-danger' : 'text-dark' ?> p-3"><b><?php echo $order['payment_status'] ?></b></td>
                                <td class="p-3"><?php echo $order['payment_id'];?></td>
                                <td class="<?php echo strtolower($order['order_status']) === 'cancelled' ? 'text-danger' : 'text-success'; ?> p-3">
                                <b><?php echo $order['order_status']; ?></b></td>
                                <td class="p-3">
                                <form action="orders_status_process.php" method="post">
                                    <input type="number" name="order_id" id="order_id" value="<?php echo $order['order_id'];?>" hidden>
                                    <input type="number" name="customer_id" id="customer_id" value="<?php echo $user['id'];?>" hidden>
                                    <!-- According the order status changed their before status value hide -->
                                    <?php
                                    $current_status = strtolower($order['order_status']);
                                    $statuses = [
                                        "order-packed" => "Order Packed",
                                        "out-of-delivery" => "Out for Delivery",
                                        "order-delivered" => "Order Delivered"
                                    ];

                                    // Determine which statuses to show
                                    $show_options = [];

                                    if ($current_status == "order-packed") {
                                        $show_options = ["out-of-delivery", "order-delivered"];
                                    } elseif ($current_status == "out-of-delivery") {
                                        $show_options = ["order-delivered"];
                                    } elseif ($current_status == "order-delivered") {
                                        $show_options = []; // no further updates
                                    } else {
                                        // initial or unknown status — show all
                                        $show_options = array_keys($statuses);
                                    }
                                    ?>

                                    <select name="order_status" class="form-select text-center" <?php echo empty($show_options) ? 'disabled' : ''; ?>>
                                        <?php
                                        foreach ($show_options as $status_key) {
                                            echo "<option value=\"$status_key\">{$statuses[$status_key]}</option>";
                                        }
                                        ?>
                                    </select>
                                </td>
                                <td class="p-3">
                                    <?php
                                        $order_status = strtolower($order['order_status']);

                                        if ($order_status === 'cancelled') {
                                            // Don't show the update button at all
                                            echo '';
                                        } else {
                                            echo '<button type="submit" class="btn btn-primary btn-sm">Update</button>';
                                        }
                                    ?>
                                </td>
                                </form>
                                <td><a href="ordered_product.php?oid=<?php echo $order['order_id'];?>" class="btn btn-success btn-sm">View item</a></td>
                                <td>
                                    <a href="all_orders.php?oid=<?php echo $order['order_id'];?>" 
                                    class="btn btn-danger btn-sm"
                                    onclick="return confirm('Are you sure you want to delete this order?');">
                                    Remove
                                    </a>
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
</div>

<?php
include("admin_footer.php");
?>

<?php
if($_SERVER['REQUEST_METHOD'] == "GET" && isset($_GET['oid'])){
    $oid = $_GET['oid'];
    $delete_query= mysqli_query($conn, "DELETE FROM `orders` WHERE order_id='$oid'");
    if($delete_query){
        $_SESSION['error'] = "Order Deleted successfully!!";
        $_SESSION['type'] = "success";
    }
    return;
}
?>