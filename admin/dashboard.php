<?php
include("admin_middleware.php");
include("admin_header.php");
?>

<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Dashboard</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Dashboard</li>
        </ol>
        <div class="row">
            <div class="col-xl-3 col-md-6">
                <div class="card bg-primary text-white mb-4">
                    <div class="card-body"><b><h5>Total Revenue</h5></b></div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        <a class="small text-white stretched-link text-decoration-none" href="total_revenue.php">
                        <h5>
                        <?php
                        $revenue_select_query = mysqli_query($conn, "SELECT SUM(order_amount) AS revenue FROM orders");
                        $data = mysqli_fetch_assoc($revenue_select_query);
                        $revenue = $data['revenue'] ?? 0;
                        echo "₹ ".number_format($revenue, 2);
                        ?>
                        </h5>
                        </a>
                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card bg-warning text-white mb-4">
                    <div class="card-body"><b><h5>Total Orders</h5></b></div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        <a class="small text-white stretched-link text-decoration-none" href="all_orders.php">
                            <h5>
                            <?php
                            $order_select_query = mysqli_query($conn, "SELECT COUNT(order_id) AS `ordercount` FROM `orders`");
                            if (!mysqli_num_rows($order_select_query)>0) {
                                echo "<h5>Quantity:0</h5>";
                            }
                            $data = mysqli_fetch_assoc($order_select_query);
                            echo "Quantity: ".$data['ordercount'];
                            ?>
                            </h5>
                        </a>
                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card bg-success text-white mb-4">
                    <div class="card-body"><b><h5>Total Products</h5></b></div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        <a class="small text-white stretched-link text-decoration-none" href="all_product.php">
                            <h5>
                            <?php
                            $product_select_query = mysqli_query($conn, "SELECT COUNT(id) AS `productcount` FROM `product`");
                            if (!mysqli_num_rows($product_select_query)>0) {
                                echo "<h5>Quantity:0</h5>";
                            }
                            $data = mysqli_fetch_assoc($product_select_query);
                            echo "Quantity: ".$data['productcount'];
                            ?>
                            </h5>
                        </a>
                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card bg-danger text-white mb-4">
                    <div class="card-body"><b><h5>Total Customers</h5></b></div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        <a class="small text-white stretched-link text-decoration-none" href="all_customer.php">
                            <h5>
                            <?php
                            $user_select_query = mysqli_query($conn, "SELECT COUNT(id) AS `usercount` FROM `users` WHERE `user_type` = 'customer'");
                            if (!mysqli_num_rows($user_select_query)>0) {
                                echo "<h5>Person:0</h5>";
                            }
                            $data = mysqli_fetch_assoc($user_select_query);
                            echo "Person: ".$data['usercount'];
                            ?>
                            </h5>
                        </a>
                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-6">
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-chart-area me-1"></i>
                        Area Chart 
                    </div>
                    <div class="card-body"><canvas id="revenueChart" width="100%" height="40"></canvas></div>
                </div>
            </div>
            <div class="col-xl-6">
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-chart-bar me-1"></i>
                        Bar Chart 
                    </div>
                    <div class="card-body"><canvas id="orderChart" width="100%" height="40"></canvas></div>
                </div>
            </div>
        </div>
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table me-1"></i>
                Orders Table Section
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Order ID</th>
                                <th>Order Amount</th>
                                <th>Coupon Used</th>
                                <th>Order Status</th>
                                <th>Payment Type</th>
                                <th>Payment ID</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                             $select_query = mysqli_query($conn, "SELECT * FROM `orders` WHERE 1");
                            if(mysqli_num_rows($select_query)>0){
                                while($order = mysqli_fetch_assoc($select_query)){
                                    $user_id = $order['user'];
                                    $user_query = mysqli_query($conn, "SELECT * FROM users WHERE id = '$user_id'");
                                    $user = mysqli_fetch_assoc($user_query);

                                    $info_query = mysqli_query($conn, "SELECT * FROM user_info WHERE user_id = '$user_id'");
                                    $info = mysqli_fetch_assoc($info_query);
                                    ?>
                                    <tr>
                                        <td><?php echo $user['name'];?></td>
                                        <td><?php echo $order['order_id'];?></td>
                                        <td><?php echo $order['order_amount'];?></td>
                                        <td><?php echo $order['coupon'];?></td>
                                        <td><?php echo $order['order_status'];?></td>
                                        <td><?php echo $order['payment_type'];?></td>
                                        <td><?php echo $order['payment_id'];?></td>
                                    </tr>
                                    <?php
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>
<script>
    const labels = <?php echo json_encode($labels); ?>;
    const revenueData = <?php echo json_encode($monthlyRevenue); ?>;
    const orderData = <?php echo json_encode($monthlyOrders); ?>;

    // Revenue Area Chart
    new Chart(document.getElementById("revenueChart"), {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: "Revenue (₹)",
                data: revenueData,
                backgroundColor: "rgba(78, 115, 223, 0.2)",
                borderColor: "rgba(78, 115, 223, 1)",
                borderWidth: 2,
                pointRadius: 5,
                tension: 0.4,
                fill: true
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: true } },
            scales: {
                y: { beginAtZero: true }
            }
        }
    });

    // Orders Bar Chart
    new Chart(document.getElementById("orderChart"), {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: "Orders",
                data: orderData,
                backgroundColor: "rgba(35, 84, 247, 0.8)",
                borderColor: "rgba(5, 25, 139, 1)",
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: true } },
            scales: {
                y: { beginAtZero: true }
            }
        }
    });
</script>


<?php
include("admin_footer.php");
?>