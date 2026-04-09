<?php
    $page = 'login';
    include("header.php");
?>
<main>
    <div class="container-fluid d-flex justify-content-center mt-5">
        <div class="col-lg-5 col-md-5 col-sm-5 ">
            <div class="card shadow-lg rounded-lg mt-5">
                <div class="card-header text-center pt-2">
                    <h3 class=" fw-bold">Login Here</h3>
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
                    <form method="post" action="login_process.php">
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
                        <div class="remember-forgot d-flex align-items-center justify-content-between mt-2 mb-2">
                            <div class="form-check gap-2 mt-2">
                                <input class="form-check-input" id="Rpassword" name="Rpassword" type="checkbox" value="">
                                <label class="form-check-label" for="Rpassword">Remember Password</label>
                            </div>
                            <a href="password.html">Forgot Password?</a>
                        </div>
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-light btn-lg shadow">Login</button>
                        </div>
                    </form>
                </div>
                <div class="card-footer text-center py-3">
                    <a href="register.php">Need an account? Sign up!</a>
                </div>
            </div>
        </div>
    </div>
</main>
<?php
include("footer.php")
?>