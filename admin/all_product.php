<?php
include("admin_middleware.php");
include("admin_header.php");
?>

<div class="container-fluid">
    <div class="p-1 mb-3">
        <h3>Details of All Product</h3>
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
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Product Image</th>
                    <th scope="col">Product Category</th>
                    <th scope="col">Product Title</th>
                    <th scope="col">Product Description</th>
                    <th scope="col">Price</th>
                    <th scope="col">Product Company</th>
                    <th scope="col">About Product</th>
                    <th scope="col">Manufacture Date</th>
                    <th scope="col">Expiry Date</th>
                    <th scope="col">Date</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $select_query = mysqli_query($conn,"SELECT * FROM `product` WHERE 1");
                if(mysqli_num_rows($select_query)>0){
                    while($product = mysqli_fetch_assoc($select_query)){
                        ?>
                        <tr>
                            <th scope="row"><?php echo $product['id']; ?></th>
                            <td>
                                <img src="<?php echo $product['p_img'];?>" height="110px" width="110px">
                            </td>
                            <td><?php echo $product['category']; ?></td>
                            <td><?php echo $product['p_title']; ?></td>
                            <td><?php echo $product['p_description']; ?></td>
                            <td><?php echo $product['p_price']; ?></td>
                            <td><?php echo $product['company']; ?></td>
                            <td><?php echo $product['about']; ?></td>
                            <td><?php echo $product['m_date']; ?></td>
                            <td><?php echo $product['exp_date']; ?></td>
                            <td><?php echo $product['created_at']; ?></td>
                            <td><a href="product_update.php?pid=<?php echo $product['id']; ?>" class="btn btn-outline-primary btn-sm">Update</a></td>
                            <td><a href="all_product.php?id=<?php echo $product['id']; ?>" class="btn btn-outline-danger btn-sm">Delete</a></td>
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
<?php
function delete_product($conn, $id){
    $delete_query = "DELETE FROM `product` WHERE id=$id";
    $query = (mysqli_query($conn, $delete_query));
    if($query){
        return 1;
    }else{
        return 0;
    }
}
if($_SERVER['REQUEST_METHOD'] == "GET" && isset($_GET['id'])){
    $id = $_GET['id'];
    $result = delete_product($conn, $id);
    if($result == 1){
        $_SESSION['error'] = "Data deleted successfully!";
        $_SESSION['type'] = "success";
        ?>
        <script>
            window.location.href="http://localhost/droplet/admin/all_product.php";
        </script>
        <?php
        return;
        
    }
}
?>