<?php
include("admin_middleware.php");
include("admin_header.php");

if($_SERVER['REQUEST_METHOD'] == "GET"){
    if(!empty($_GET["pid"])){
        $pid = $_GET["pid"];
        $select_query = mysqli_query($conn, "SELECT * FROM `product` WHERE id='$pid'");
        $product = mysqli_fetch_assoc($select_query);
        $cid = $product['category'];
        $category_select_query = mysqli_query($conn, "SELECT * FROM `category` WHERE id='$cid'");
        $current_category = mysqli_fetch_assoc($category_select_query);
    }
}
?>

<div class="container">
    <div class="container-fluid mt-4 mb-4">
        <h3>Update Product</h3>
        <!--sub heading-->
        <div class="container d-flex gap-2 mt-4">
            <div class="mb-2 text-black-50">
                <a href="all_product.php" class="text-black-50 text-decoration-none">All Product >></a>
            </div>
            <div class="mb-2">
                <a href="" class="text-black-50 text-decoration-none">Update Product >>></a>
            </div>
        </div>
    </div>
    <div class="container mt-2">
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
    
    <form action="product_update_process.php" method="post" enctype="multipart/form-data">
        <div class="row">
            <div class="col-md-7">
                <input type="text" name="id" value="<?php echo $product['id'];?>" hidden>
                <div class="mb-3">
                    <label for="update_category" class="form-label">Choose Category</label>
                    <select name="update_category" id="update_category" class="form-select">
                        <option value="<?php echo $product['category'];?>">
                            <?php 
                                $catrgory_id = $product['category'];
                                $category_select_query = mysqli_query($conn, "SELECT * FROM `category` WHERE id=$catrgory_id");
                                if (mysqli_num_rows($category_select_query)>0) {
                                    $category = mysqli_fetch_assoc($category_select_query);
                                    echo $category['category_title'];
                                }
                            ?>
                        </option>
                        <?php
                            $categories = mysqli_query($conn, "SELECT * FROM `category` WHERE 1");
                            if (mysqli_num_rows($categories)>0) {
                                while ($category = mysqli_fetch_assoc($categories)) {
                                    ?>
                                    <option value="<?php echo $category['id'];?>"><?php echo $category['category_title'];?></option>
                                    <?php
                                }
                            }
                        ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="title" class="form-label">Product Title</label>
                    <input type="text" name="title" id="title" class="form-control" value="<?php echo $product['p_title'];?>">
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Product Description</label>
                    <textarea name="description" rows="2" class="form-control"><?php echo $product['p_description']; ?></textarea>
                </div>
                <div class="mb-3">
                    <label for="price" class="form-label">Product Price</label>
                    <input type="number" name="price" id="price" class="form-control" value="<?php echo $product['p_price'];?>">
                </div>
                <div class="mb-3">
                    <label for="company" class="form-label">Company</label>
                    <input type="text" name="company" id="company" class="form-control" value="<?php echo $product['company'];?>">
                </div>
                <div class="mb-3">
                    <label for="about" class="form-label">About Section</label>
                    <textarea name="about" rows="4" class="form-control"><?php echo $product['about']; ?></textarea>
                </div>
                <div class="mb-3">
                    <label for="img" class="form-label"></label>
                    <input type="file" class="form-control" name="img" id="img" accept="image/*">
                </div>
                <div class="mb-3">
                    <label for="m_date" class="form-label">Manufacturing Date</label>
                    <input type="date" name="m_date" id="m_date" class="form-control" value="<?php echo $product['m_date'];?>">
                </div>
                <div class="mb-3">
                    <label for="e_date" class="form-label">Expiry Date</label>
                    <input type="date" name="e_date" id="e_date" class="form-control" value="<?php echo $product['exp_date'];?>">
                </div>
                <div class="mb-3">
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </div>
            <div class="col-md-4">
                <img src="<?php echo $product['p_img'];?>" alt="" style="height:420px; width:410px;">
            </div>
        </div>
    </form>
    
</div>

<?php
include("admin_footer.php");
?>