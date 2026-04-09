<?php
include("admin_middleware.php");
include("admin_header.php");
?>
<div class="container mt-3 mb-3">
    <!--session msg-->
    <div class="container mt-2">
        <?php
        if (isset($_SESSION['msg']) && isset($_SESSION['type'])) {
            ?>
            <div class="alert alert-<?php echo $_SESSION['type']; ?> alert-dismissible fade show" role="alert">
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                <strong><?php echo $_SESSION['msg'];
                $_SESSION['msg'] = null;
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
    <div class="container">
        <div class="row">
            <div class="col-md-9 col-sm-8">
                <div class="mb-3">
                    <h3 class="">All Coupon Details</h3>
                </div>
            </div>
            <div class="col-md-3 col-sm-4">
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-success mt-2 fw-semibold
            " data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                    Add Coupon Code
                </button>

                <!--Add Coupon Modal -->
                <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false"
                    tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="staticBackdropLabel">Add a new Coupon :</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="coupon_process.php" method="post">
                                    <div class="mb-3">
                                        <label for="code" class="form-label">Coupon Code</label>
                                        <input type="text" name="code" class="form-control" id="code">
                                    </div>
                                    <div class="mb-3">
                                        <label for="percentage" class="form-label">Coupon Percentage</label>
                                        <input type="text" name="percentage" id="percentage" class="form-control">
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="created_on" class="form-label">Created On</label>
                                                <input type="date" name="created_on" id="created_on"
                                                    class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="exp_date" class="form-label">Valid Until</label>
                                                <input type="date" name="exp_date" id="exp_date" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary">Add Coupon</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <hr>
    </div>

    <div class="container mt-5">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col" class="text-center">ID</th>
                        <th scope="col" class="text-center">Coupon Code</th>
                        <th scope="col" class="text-center">Coupon Percentage</th>
                        <th scope="col" class="text-center">Valid Until</th>
                        <th scope="col" class="text-center">Created On</th>
                        <th scope="col" class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $select_query = mysqli_query($conn, "SELECT * FROM `coupons` WHERE 1");
                    if (mysqli_num_rows($select_query) > 0) {
                        while ($coupon = mysqli_fetch_assoc($select_query)) {
                            ?>
                            <tr>
                                <th scope="row" class="text-center"><?php echo $coupon['id']; ?></th>
                                <td class="text-center"><?php echo $coupon['code']; ?></td>
                                <td class="text-center"><?php echo $coupon['percentage']; ?></td>
                                <td class="text-center"><?php echo $coupon['exp_date']; ?></td>
                                <td class="text-center"><?php echo $coupon['created_on']; ?></td>
                                <td class="text-center"><a href="add_coupon.php?id=<?php echo $coupon['id']; ?>"
                                        class="btn btn-outline-danger btn-sm">Delete</a></td>
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

<?php
include("admin_footer.php");
?>

<?php
function delete_coupon($conn, $id)
{
    $delete_query = "DELETE FROM `coupons` WHERE id=$id";
    $query = (mysqli_query($conn, $delete_query));
    if ($query) {
        return 1;
    } else {
        return 0;
    }
}
if ($_SERVER['REQUEST_METHOD'] == "GET" && isset($_GET['id'])) {
    $id = $_GET['id'];
    $result = delete_coupon($conn, $id);
    if ($result == 1) {
        $_SESSION['error'] = "Coupon is delected successfully!";
        $_SESSION['type'] = "success";
        ?>
        <script>
            window.location.href = "http://localhost/droplet/admin/add_coupon.php";
        </script>
        <?php
        return;
    }
}
?>