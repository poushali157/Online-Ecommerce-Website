<?php
include("admin_middleware.php");
include("admin_header.php");

if($_SERVER['REQUEST_METHOD'] == "GET"){
   if(!empty($_GET['id'])){
        $user_id = $_GET['id'];
    }else{
      header("location:all_customer.php");
    }
}
    $total_amount =0;

?>

<div class="container mt-3 mb-3">
    <h3 class="mb-4">All Customer Order Details</h3>
    <div class="container d-flex gap-2 mb-4">
      <div class="mb-2 text-black-50">
          <a href="all_customer.php" class="text-black-50 text-decoration-none">All Customer >>></a>
      </div>
      <div class="mb-2">
          <a href="" class="text-black-50 text-decoration-none">Customer Orders</a>
      </div>
  </div>
</div>
<div class="container">
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>Product Image</th>
                    <th>Product Name</th>
                    <th>Order ID</th>
                    <th>Order Quantity</th>
                    <th>Order Price</th>
                    <th>Coupon Used</th>
                    <th>Payment Type</th>
                    <th>Order Status</th>
                    <th>Payment Status</th>
                    <th>Date of Order</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $order_query = mysqli_query($conn, "SELECT * FROM `orders` WHERE user='$user_id'");
                if(mysqli_num_rows($order_query)>0){
                    while($order = mysqli_fetch_assoc($order_query)){
                        $order_id = $order['order_id'];

                        $info = mysqli_query($conn, "SELECT * FROM `order_item` WHERE order_id='$order_id'");
                        if(mysqli_num_rows($info)>0){
                            while($order_info = mysqli_fetch_assoc($info)){
                                $pid = $order_info['product'];
                                $product_query = mysqli_query($conn, "SELECT * FROM `product` WHERE id='$pid'");
                                if(mysqli_num_rows($product_query) > 0){
                                $product = mysqli_fetch_assoc($product_query);
                                ?>
                                <tr>
                                    <td><img src="<?php echo $product['p_img'];?>" alt="" style="height:80px; width:90px;"></td>
                                    <td><?php echo $product['p_title'];?></td>
                                    <td><?php echo $order_id?></td>
                                    <td><?php echo $order_info['quantity'];?></td>
                                    <td><?php echo $total_amount = $product['p_price']*$order_info['quantity']?></td>
                                    <td><?php echo $order['coupon']?></td>
                                    <td><?php echo $order['payment_type'];?></td>
                                    <td><?php echo $order['order_status'];?></td>
                                    <td class="<?php echo strtolower($order['payment_status']) === 'pending' ? 'text-danger' : 'text-dark';?>"><b><?php echo $order['payment_status'];?></b></td>
                                    <td><?php echo $order['date'];?></td>
                                </tr>
                                <?php
                                }
                            }
                        }
                    
                    }
                }else{
                    echo "no data found!";
                }
                ?>

            </tbody>
        </table>
    </div>
</div>
<?php
include("admin_footer.php");
?>