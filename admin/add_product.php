<?php
include("admin_middleware.php");
include("admin_header.php");
?>

<div class="container-fluid my-3">
    <div class="container mb-3">
        <h4 class="mb-3">Add New Product</h4>
        <?php
        if (isset($_SESSION['msg']) && isset($_SESSION['type'])) {
            ?>
            <div class="alert alert-<?php echo $_SESSION['type']; ?> alert-dismissible fade show " role="alert">
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                <strong><?php echo $_SESSION['msg'];
                $_SESSION['msg'] = null;
                $_SESSION['type'] = null;
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
    <form action="product_process.php" method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="category" class="form-label">Choose Category</label>
            <select class="form-select" name="category">
                <?php
                $categories = mysqli_query($conn, "SELECT * FROM `category` WHERE 1");
                if (mysqli_num_rows($categories) > 0) {
                    while ($category = mysqli_fetch_assoc($categories)) {
                        ?>
                        <option value="<?php echo $category['id'];?>"><?php echo $category['category_title'];?></option>
                        <?php
                    }
                } else {
                    ?>
                    <option>Category Not Found!</option>
                    <?php
                }
                ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="p_title" class="form-label">Product Title</label>
            <input type="text" name="p_title" class="form-control" for="p_title">
        </div>
        <div class="mb-3">
            <label for="p_description" class="form-label">Product Description</label>
            <textarea name="p_description" id="p_description" class="form-control" rows="2"></textarea>
        </div>
        <div class=" container-fluid">
            <div class="row">
                <div class="col-md-6 col-sm-6 mb-3">
                    <label for="price" class="form-label">Price</label>
                    <input type="text" name="price" class="form-control" for="price">
                </div>
                <div class="col-md-6 col-sm-6 mb-3">
                    <label for="company" class="form-label">Company</label>
                    <input type="text" name="company" class="form-control" for="company">
                </div>
                <div class="col-md-6 col-sm-6 mb-3">
                    <label for="mdate" class="form-label">Manufacture Date</label>
                    <input type="date" id="mdate" name="mdate" class="form-control">
                </div>
                <div class="col-md-6 col-sm-6 mb-3">
                    <label for="edate" class="form-label">Expiry Date</label>
                    <input type="date" id="edate" name="edate" class="form-control">
                </div>
            </div>
        </div>
        <div class="mb-3">
            <label for="pimage" class="form-label">Product Image</label>
            <input type="file" id="pimage" name="pimage" class="form-control" accept="image/*">
        </div>
        <div class="mb-3">
            <label for="about" class="form-label">About The Product</label>
            <textarea name="about" id="about" class="form-control" rows="5"></textarea>
        </div>
        <div class="mb-3">
            <button type="submit" class="btn btn-primary">Add Product</button>
        </div>
    </form>
</div>

<?php
include("admin_footer.php");
?>
