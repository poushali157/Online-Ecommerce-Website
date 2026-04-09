<?php
include("admin_middleware.php");
include("admin_header.php");
?>

<div class="container-fluid mt-2 mb-3">
        <h2 class="fw-bold">Admin Profile</h2>
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
        <div class="container mt-4">
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-4">
                        <h4 class="fw-semibold">Profile Picture</h4>
                    </div>
                    <div class="mb-4">
                        <?php
                        $select_query = mysqli_query($conn, "SELECT * FROM `users` WHERE user_type='admin'");
                        if(mysqli_num_rows($select_query)>0){
                            $admin = mysqli_fetch_assoc($select_query);
                            $id = $admin['id'];
                            $info_query = mysqli_query($conn,"SELECT * FROM `user_info` WHERE user_id='$id'");
                            $admin_info = mysqli_fetch_assoc($info_query);
                            if (!empty($admin_info['img'])) {
                                echo '<img src="'.$admin_info['img'].'" alt="" style="height:350px; width:290px;">';
                            } else {
                                echo 'No Image';
                            }  
                        }
                        ?>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-4 pt-3">
                        <h4 class="fw-semibold">Basic Information</h4>
                    </div>
                    <div class="table-responsive">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td class="fw-bold">Name : </td>
                                    <td><?php echo $admin['name'];?></td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Email : </td>
                                    <td><?php echo $admin['email'];?></td>
                                </tr>
                                <?php
                                if(empty($admin_info['ph_no']) && empty($admin_info['dob']) && empty($admin_info['gender'])){
                                    ?>
                                    <tr>
                                        <td class="pt-4">
                                            <a href="admin_info.php" class="btn btn-success">Add Information</a>
                                        </td>
                                    </tr>
                                    <?php
                                }else{
                                    ?>
                                    <tr>
                                        <td class="fw-bold">Phone Number : </td>
                                        <td><?php echo $admin_info['ph_no'];?></td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">Date Of Birth : </td>
                                        <td><?php echo $admin_info['dob'];?></td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">Gender : </td>
                                        <td><?php echo $admin_info['gender'];?></td>
                                    </tr>
                                    <tr>
                                        <td class="pt-4">
                                            <a href="admin_profile_update.php?id=<?php echo $admin['id'];?>" class="btn btn-success">Update Profile</a>
                                        </td>
                                    </tr>
                                    <?php
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php
include("admin_footer.php");
?>