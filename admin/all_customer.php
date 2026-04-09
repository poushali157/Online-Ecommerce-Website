<?php
include("admin_middleware.php");
include("admin_header.php");
?>

<div class="container mt-3 mb-3">
    <h3>All Customer Details</h3>
</div>
<div class="container">
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>Customer Image</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Contact number</th>
                    <th>DOB</th>
                    <th>Gender</th>
                    <th>Date of Registration</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $user_query = mysqli_query($conn, "SELECT * FROM `users` WHERE user_type='customer'");
                if(mysqli_num_rows($user_query)>0){
                    while($customer = mysqli_fetch_assoc($user_query)){
                    $id = $customer['id'];

                    $info = mysqli_query($conn, "SELECT * FROM `user_info` WHERE user_id='$id'");
                    $customer_info = mysqli_fetch_assoc($info);

                    ?>
                    <tr>
                        <td>
                            <?php 
                                if (!empty($customer_info['img'])) {
                                    echo '<img src="'.$customer_info['img'].'" alt="" style="height:90px; width:110px;">';
                                } else {
                                    echo 'No Image';
                                }
                            ?>
                        </td>
                        <td><?php echo $customer['name']?></td>
                        <td><?php echo $customer['email']?></td>
                        <td><?php echo (!empty($customer_info['ph_no']) ? $customer_info['ph_no'] : 'No Data Yet'); ?></td>
                        <td><?php echo (!empty($customer_info['dob']) ? $customer_info['dob'] : 'No Data Yet');?></td>
                        <td><?php echo (!empty($customer_info['gender']) ? $customer_info['gender'] : 'No Data Yet');?></td>
                        <td><?php echo $customer['created_at']?></td>
                        <td><a href="customer_order.php?id=<?php echo $id;?>" class="btn btn-success btn-sm">View Orders</a></td>
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