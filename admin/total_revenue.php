<?php
include("admin_middleware.php");
include("admin_header.php");
?>

<div class="container-fluid mt-2 mb-3">
    <h2 class="fw-bold">Total Revenue Section</h2>
</div>
<div class="container-fluid mt-3 mb-5">
    <div class="row">
        <div class="col-md-4">
            <div class="card bg-success text-center text-white mb-4">
                <div class="card-body"><b><h5>Paid Orders Amount</h5></b></div>
                <div class="card-footer align-items-center justify-content-between">
                    <a class="small text-white stretched-link text-decoration-none" href="total_revenue.php">
                        <h5>
                        <?php
                        $revenue_select_query = mysqli_query($conn, "SELECT SUM(order_amount) AS revenue FROM orders WHERE payment_status = 'paid'");
                        $data = mysqli_fetch_assoc($revenue_select_query);
                        $revenue = $data['revenue'] ?? 0;
                        echo "₹ ".number_format($revenue, 2);
                        ?>
                        </h5>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-danger text-center text-white mb-4">
                <div class="card-body"><b><h5>Pending Orders Amount</h5></b></div>
                <div class="card-footer align-items-center justify-content-between">
                    <a class="small text-white stretched-link text-decoration-none" href="total_revenue.php">
                        <h5>
                        <?php
                        $revenue_select_query = mysqli_query($conn, "SELECT SUM(order_amount) AS revenue FROM orders WHERE payment_status = 'pending'");
                        $data = mysqli_fetch_assoc($revenue_select_query);
                        $revenue = $data['revenue'] ?? 0;
                        echo "₹ ".number_format($revenue, 2);
                        ?>
                        </h5>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-primary text-center text-white mb-4">
                <div class="card-body"><b><h5>Change Amount Status</h5></b></div>
                <a class="small text-white stretched-link" href="all_orders.php"></a>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid">
    <?php
    if (isset($_SESSION['error']) && isset($_SESSION['type'])) {
        ?>
        <div class="alert alert-<?php echo $_SESSION['type']; ?> alert-dismissible fade show" role="alert">
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

<div class="container-fluid">
    <div class="table-responsive text-center">
        <table class="table">
            <thead>
                <tr>
                    <th>Customer Photo</th>
                    <th>Customer Name</th>
                    <th>Customer Email</th>
                    <th>Customer Contact</th>
                    <th colspan="2" class="text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $customers_select_query = mysqli_query($conn, "SELECT * FROM `users` WHERE `user_type` = 'customer'");
                    if (mysqli_num_rows($customers_select_query)>0) {
                        while ($customer = mysqli_fetch_assoc($customers_select_query)) {
                            $id = $customer['id'];

                            $info = mysqli_query($conn, "SELECT * FROM `user_info` WHERE user_id='$id'");
                            $customer_info = mysqli_fetch_assoc($info);
                            ?>
                                <tr>
                                    <td>
                                        <?php 
                                            if (!empty($customer_info['img'])) {
                                                echo '<img src="'.$customer_info['img'].'" alt="" style="height:70px; width:90px;">';
                                            } else {
                                                echo 'No Image';
                                            }
                                        ?>
                                    </td>
                                    <td><?php echo $customer['name'];?></td>
                                    <td><?php echo $customer['email'];?></td>
                                    <td><?php echo (!empty($customer_info['ph_no']) ? $customer_info['ph_no'] : 'No Data Yet'); ?></td>
                                    <td><a href="customer_order.php?cid=<?php echo $customer['id'];?>" class="btn btn-success btn-sm">View Now</a></td>
                                    <td>
                                        <a href="total_revenue.php" class="btn btn-danger btn-sm"
                                        onclick="return confirm('Are you sure you want to delete this customer?');">
                                        Remove</a>
                                    </td>
                                </tr>
                            <?php
                        }
                    }
                ?>
            </tbody>
        </table>
    </div>
</div>

<?php
include("admin_footer.php");
?>