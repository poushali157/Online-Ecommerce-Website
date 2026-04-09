<?php
include("admin_middleware.php");
include("admin_header.php");
if($_SERVER['REQUEST_METHOD'] == "GET"){
    if(!empty($_GET['id'])){
        $cid = $_GET['id'];
    }else{
        header("location:all_category.php");
    }
}
?>

<div class="container">
    <div class="p-1 mb-3">
        <h3>Products Based On Category</h3>
        <div class="container d-flex gap-2 mb-4 mt-4">
            <div class="mb-2 text-black-50">
                <a href="all_category.php" class="text-black-50 text-decoration-none">All Category >>></a>
            </div>
            <div class="mb-2">
                <a href="" class="text-black-50 text-decoration-none">Products Based on Category</a>
            </div>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col" class="text-center">ID</th>
                    <th scope="col" class="text-center">Product Image</th>
                    <th scope="col" class="text-center">Product Category</th>
                    <th scope="col" class="text-center">Product Title</th>
                    <th scope="col" class="text-center">Product Description</th>
                    <th scope="col" class="text-center">Price</th>
                    <th scope="col" class="text-center">Product Company</th>
                    <th scope="col" class="text-center">About Product</th>
                    <th scope="col" class="text-center">Manufacture Date</th>
                    <th scope="col" class="text-center">Expiry Date</th>
                    <th scope="col" class="text-center">Date</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $select_query = mysqli_query($conn,"SELECT * FROM `product` WHERE category=$cid");
                if(mysqli_num_rows($select_query)>0){
                    while($data = mysqli_fetch_assoc($select_query)){
                        ?>
                        <tr>
                            <th scope="row"><?php echo $data['id']; ?></th>
                            <td>
                                <img src="<?php echo $data['p_img'];?>" height="80px" width="80px">
                            </td>
                            <td class="text-center"><?php echo $data['p_title']; ?></td>
                            <td><?php echo $data['category']; ?></td>
                            <td><?php echo $data['p_description']; ?></td>
                            <td><?php echo $data['p_price']; ?></td>
                            <td><?php echo $data['company']; ?></td>
                            <td><?php echo $data['about']; ?></td>
                            <td><?php echo $data['m_date']; ?></td>
                            <td><?php echo $data['exp_date']; ?></td>
                            <td class="text-center"><?php echo $data['created_at']; ?></td>
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