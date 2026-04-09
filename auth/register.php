<?php
    $page = 'register';
    require_once "header.php";
?>
<main>
    <div class="container-fluid d-flex justify-content-center mt-5">
        <div class="col-lg-5 col-md-6 col-sm-7 ">
            <div class="card shadow-lg rounded-lg mt-5">
                <div class="card-header text-center pt-2">
                    <h3 class="fw-bold">Create Account</h3>
                    <?php
                        if(isset($_SESSION['error']) && isset($_SESSION['type'])){
                            ?>
                            <div class="alert alert-<?php echo $_SESSION['type'];?> alert-dismissible fade show " role="alert">
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"
                                ></button>
                                <strong><?php echo $_SESSION['error']; session_unset();?>
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
                <div class="card-body">
                    <form action="register_process.php" method="post">
                        <div class="input-box mb-3">
                            <input class="form-control" name="name" placeholder="Full Name">
                            <span class="icon">
                                <i class="fa-solid fa-circle-user"></i>
                            </span>
                        </div>
                        <div class="input-box mb-3">
                            <input class="form-control" name="email" type="email" placeholder="Email Address">
                            <span class="icon">
                                <i class="fa-solid fa-envelope"></i>
                            </span>
                        </div>
                        <div class="input-box mb-3">
                            <input class="form-control" name="password" type="password" placeholder="Password">
                            <span class="icon">
                                <i class="fa-solid fa-lock"></i>
                            </span>
                        </div>
                        <div class="input-box mb-3">
                            <input class="form-control" name="cpassword" type="password" placeholder="Confirm Password">
                            <span class="icon">
                                <i class="fa-solid fa-lock"></i>
                            </span>
                        </div>
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-light btn-lg shadow">Register</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>
<?php
    require_once "footer.php";
?>