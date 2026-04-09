<?php
//site information
$site_title = "Droplet";
$site_desc = "Droplet is your daily dose of plant-powered wellness — offering adaptogen drinks, cold-pressed juices, smoothies, and functional blends designed to help you glow, energize, and feel your best.";

//paths
$path = "http://localhost/droplet/";

//db connection
$conn = mysqli_connect("localhost", "root", "", "droplet");
if(!$conn){
    echo "db not connected"; 
}
?>
