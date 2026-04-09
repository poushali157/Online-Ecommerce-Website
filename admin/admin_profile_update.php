<?php
include("admin_middleware.php");
include("admin_header.php");

if($_SERVER['REQUEST_METHOD'] == "GET"){
    if(!empty($_GET["id"])){
        $id = $_GET["id"];
        $select_query = mysqli_query($conn,"SELECT * FROM `user_info` WHERE user_id='$id'");
        if(mysqli_num_rows($select_query) > 0){
            $data = mysqli_fetch_assoc($select_query);
        }  else{
            echo "no data found with this id";
        }
    } else {
        header("location:admin_profile.php");
    }
}
?>
    <div class="container-fluid mb-3">
        <h2 class="text-center fw-bold">Update Your Profile</h2>
    </div>
    
    <div class="container-fluid">
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
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <form action="profile_update_process.php" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="id" value="<?php echo $data['id'];?>">
                        <div class="mb-3 ">
                            <label for="ph_no" class="form-lable">Phone Number</label>
                            <input type="number" name="ph_no" class="form-control border border-dark" value="<?php echo $data['ph_no'];?>">
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="dob" class="form-lable">Date of Birth</label>
                                    <input type="date" name="dob" class="form-control border border-dark" value="<?php echo $data['dob'];?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3"> 
                                    <label for="gender" class="form-label">Gender</label><br>
                                    <input type="radio" class="form-check-input" name="gender" id="gender" value="male" <?php echo $gender = $data['gender'] == "male"?"checked":"";?>> Male &nbsp;
                                    <input type="radio" class="form-check-input" name="gender" id="gender" value="female" <?php echo $gender = $data['gender'] == "female"?"checked":"";?>> Female &nbsp;
                                </div>
                            </div>
                        </div>
                        <div class="mb-4">
                            <label for="img" class="form-label">Upload Photo</label>
                            <input type="file" class="form-control" name="img" id="img" accept="image/*">
                        </div>
                        <div class="mb-3">
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-md-6">
                    <div class="d-flex justify-content-center">
                        <img src="<?php echo $data['img'] ?>" height="290px" width="280px" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php
include("admin_footer.php");
?>