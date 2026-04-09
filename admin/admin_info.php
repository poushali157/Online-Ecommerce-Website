<?php
include("admin_middleware.php");
include("admin_header.php");
?>
    <div class="container-fluid mt-2 mb-3">
        <h2 class="fw-bold">Add Data To Your Profile</h2>
    </div>
    <div class="container d-flex gap-2 mt-2">
        <div class="mb-2">
            <a href="admin_profile.php" class="text-black-50 text-decoration-none">Admin Profile >>></a>
        </div>
        <div class="mb-2">
            <a href="Admin_info.php" class="text-black-50 text-decoration-none">Add Information</a>
        </div>
    </div>
    <!--sesssion msg-->
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

    <div class="container d-flex justify-content-center align-items-center mt-4 mb-5">
        <div class="card col-6 border-none shadow">
            <form action="admin_profile_process.php" method="post" enctype="multipart/form-data" class="p-4">
                <?php
                $select_query = mysqli_query($conn, "SELECT * FROM `users` WHERE user_type='admin'");
                $admin = mysqli_fetch_assoc($select_query);
                ?>
                <input type="hidden" name="id" value="<?php echo $admin['id'];?>">
                <div class="mb-3">
                    <label for="ph_no" class="form-lable">Phone Number</label>
                    <input type="number" name="ph_no" class="form-control border border-dark">
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="dob" class="form-lable">Date of Birth</label>
                            <input type="date" name="dob" class="form-control border border-dark">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3"> 
                            <label for="gender" class="form-label">Gender</label><br>
                            <input type="radio" class="form-check-input" name="gender" id="gender" value="male"> Male &nbsp;
                            <input type="radio" class="form-check-input" name="gender" id="gender" value="female"> Female &nbsp;
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="img">Upload Your Image</label>
                    <input type="file" name="img" accept="image/*" class="form-control border border-dark">
                </div>
                <div class="d-grid mb-3">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>

<?php
include("admin_footer.php");
?>