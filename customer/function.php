<?php
function login_checker(){
    if (!(isset($_SESSION['customer']))) {
        return 0;
    }
    return 1;
}

function get_cart_item($conn, $user){
    $query = mysqli_query($conn, "SELECT SUM(quantity) as total_items FROM cart WHERE user=$user");
    $result = mysqli_fetch_assoc($query);
    return $result['total_items'];
}
?>