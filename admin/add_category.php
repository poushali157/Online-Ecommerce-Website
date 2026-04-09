<?php
include("admin_middleware.php");
include("admin_header.php");
?>

<div class="container-fluid my-3">
    <div class="container mb-3">
        <h4 class="mb-3">Add New Category</h4>
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
    <form action="category_process.php" method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="ctitle" class="form-label">Category Title</label>
            <input type="text" name="ctitle" class="form-control" for="ctitle">
        </div>
        <div class="mb-3">
            <label for="cdescription" class="form-label">Category Description</label>
            <textarea name="cdescription" id="cdescription" class="form-control" rows="3"></textarea>
        </div>
        <div class="mb-3">
            <label for="cimage" class="form-label">Category Image</label>
            <input type="file" id="cimage" name="cimage" class="form-control" accept="image/*">
        </div>
        <div class="mb-3">
            <button type="submit" class="btn btn-primary">Add Category</button>
        </div>
    </form>
</div>

<?php
include("admin_footer.php");
?>