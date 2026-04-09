<?php
include("admin_middleware.php");
include("admin_header.php");

if($_SERVER['REQUEST_METHOD'] == "GET"){
    if(!empty($_GET['oid'])){
        $oid = $_GET['oid'];
    }else{
      header("location:all_orders.php");
    }
}
?>
<div class="container">
    <h3 class="mt-4">Ordered Products</h3>
    <!--sub heading-->
    <div class="container d-flex gap-2 mt-4">
        <div class="mb-2 text-black-50">
            <a href="all_orders.php" class="text-black-50 text-decoration-none">All orders >></a>
        </div>
        <div class="mb-2">
            <a href="ordered_product.php" class="text-black-50 text-decoration-none">View Ordered Product >>></a>
        </div>
    </div>
</div>
<div class="container mt-5 mb-2">
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Product Image</th>
                    <th scope="col">Product Name</th>
                    <th scope="col">Product Company</th>
                    <th scope="col">Price</th>
                    <th scope="col">Quantity</th>
                </tr>
            </thead>
                <?php
                $select_query = mysqli_query($conn, "SELECT * FROM `order_item` WHERE order_id='$oid'");
                if(mysqli_num_rows($select_query)>0){
                    while($data = mysqli_fetch_assoc($select_query)){
                        $pid = $data['product'];
                        $product_select_query = mysqli_query($conn,"SELECT * FROM `product` WHERE id='$pid'");
                        $product = mysqli_fetch_assoc($product_select_query);
                        ?>
                        <tbody>
                            <tr>
                                <td><img src="<?php echo $product['p_img'];?>" alt="" style="height:120px; width:90px"></td>
                                <td><?php echo $product['p_title'];?></td>
                                <td><?php echo $product['company'];?></td>
                                <td><?php echo $total_price = $product['p_price']*$data['quantity'];?></td>
                                <td><?php echo $data['quantity'];?></td>
                            </tr>
                        </tbody>
                        <?php
                    }
                }
                ?>
        </table>
    </div>
</div>

<?php
include("admin_footer.php");
?>