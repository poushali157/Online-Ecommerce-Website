<?php
include("admin_middleware.php");
include("admin_header.php");
?>

<div class="container">
    <div class="p-1 mb-3">
        <h3>All Category</h3>
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
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col" class="text-center">ID</th>
                    <th scope="col" class="text-center">Category Image</th>
                    <th scope="col" class="text-center">Category Title</th>
                    <th scope="col" class="text-center">Category Description</th>
                    <th scope="col" class="text-center">Date</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $select_query = mysqli_query($conn,"SELECT * FROM `category` WHERE 1");
                if(mysqli_num_rows($select_query)>0){
                    while($data = mysqli_fetch_assoc($select_query)){
                        ?>
                        <tr>
                            <th scope="row"><?php echo $data['id']; ?></th>
                            <td>
                                <img src="<?php echo $data['photo'];?>" height="80px" width="80px">
                            </td>
                            <td class="text-center"><?php echo $data['category_title']; ?></td>
                            <td><?php echo $data['category_description']; ?></td>
                            <td class="text-center"><?php echo $data['created_at']; ?></td>
                            <td><a href="category_based_product.php?id=<?php echo $data['id']; ?>" class="btn btn-primary btn-sm">View Product</a></td>
                            <td><a href="all_category.php?id=<?php echo $data['id']; ?>" class="btn btn-danger btn-sm">Delete</a></td>
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
<?php
function delete_category($conn, $id){
    $delete_query = "DELETE FROM `category` WHERE id=$id";
    $query = (mysqli_query($conn, $delete_query));
    if($query){
        return 1;
    }else{
        return 0;
    }
}
if($_SERVER['REQUEST_METHOD'] == "GET" && isset($_GET['id'])){
    $id = $_GET['id'];
    $result = delete_category($conn, $id);
    if($result == 1){
        $_SESSION['error'] = "Data deleted successfully!";
        $_SESSION['type'] = "success";
        ?>
        <script>
            window.location.href="http://localhost/droplet/admin/all_category.php";
        </script>
        <?php
    }
}
?>