<?php
session_start();
include("function.php");
include("../config.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Link Swiper's CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <link rel="stylesheet" href="common_css.css">
    <title>Droplet - Homepage</title>
    <style>
      .swiper{
        width: 100%;
        height: 100%;
      }
      .swiper-slide{
        text-align: center;
        font-size: 18px;
        display: flex;
        justify-content: center;
        align-items: center;
      }
      .bg-image{
        background-image: url('image/bg3.jpg');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        position: relative;
        z-index: 0;
      }
    </style>
</head>
<body>   
<header>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
      <div class="container-fluid d-flex">
        <img class="navbar-brand" src="image/logo.png" alt="" style="height: 50px; width: 100px; margin-left:55px;">
        <!-- Toggle Button for Offcanvas -->
        <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar"
            aria-controls="offcanvasNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <!-- Offcanvas Sidebar Menu -->
        <div class="offcanvas offcanvas-end " tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
            <div class="offcanvas-header">
              <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Menu</h5>
              <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
              <ul class="navbar-nav mx-auto gap-3">
                  <li class="nav-item">
                  <a class="nav-link active" aria-current="page" href="index.php">Home</a>
                  </li>
                  <li class="nav-item">
                    <div class="dropdown">
                      <button class="btn btn-light dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Categories
                      </button>
                      <ul class="dropdown-menu">
                      <?php
                        $category_select_query = mysqli_query($conn, "SELECT * FROM `category` WHERE 1");
                        if(mysqli_num_rows($category_select_query)>0){
                          while($category_list = mysqli_fetch_assoc($category_select_query)){
                            ?>
                            <li><a class="dropdown-item mb-2" href="category.php?id=<?php echo $category_list['id'];?>"><?php echo $category_list['category_title'];?></a></li>
                            <?php
                          }
                        }
                      ?>
                      </ul>       
                    </div>
                  </li>
                  <li class="nav-item">
                  <a class="nav-link" href="#">About</a>
                  </li>
                  <li class="nav-item">
                      <a class="nav-link" href="#">Contact</a>
                  </li>
              </ul><hr>
              <?php
                $result = login_checker();
                if($result === 0){
                  ?>
                  <div class="d-flex gap-3" style=" margin-right: 60px;">
                    <a href="../auth/login.php" class="btn btn-outline-dark">Login</a>
                    <a href="../auth/register.php" class="btn btn-outline-dark">Register</a>
                </div>
                <?php
                }else{
                  ?>
                  <div class="d-flex gap-3" style=" margin-right: 30px;">
                    <div>
                      <a class="btn btn-outline-dark" href="cart.php">
                        <i class="fa-solid fa-cart-shopping"></i>
                          Cart
                        <span class="badge bg-dark text-white me-1 rounded-pill">
                          <?php
                            $user = $_SESSION['customer']['id'];
                            $result = get_cart_item($conn, $user);
                            echo $result;
                          ?>
                        </span>
                      </a>
                    </div>
                    <div class="dropdown">
                      <button class="btn btn-dark dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <?php echo $_SESSION['customer']['name']; ?>
                      </button>
                      <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="profile.php">
                          My Profile</a></li>
                        <li><a class="dropdown-item" href="all_orders.php">
                          My Orders</a></li>
                        <li><a class="dropdown-item" href="address.php">
                          My Address</a></li>
                        <li><a class="dropdown-item" href="../auth/logout.php">Logout</a></li>
                      </ul>
                    </div>
                </div>
                <?php
                }
              ?>
            </div>
        </div>
      </div>
    </nav>
</header>

<!--sesssion msg-->
<div class="container-fluid">
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

<!--hero section-->
<div id="carousel" class="carousel slide mb-3">
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img src="image/droplet banner.png" class="d-block w-100" alt="..." style="height: 600px;">
    </div>
  </div>
</div>

<!--Features section-->
<div class="container">
  <div class="heading">
    <h5></h5>
    <h3 class="fw-bold text-center mt-3" style="color: rgb(136, 6, 54);">Why You'll love it</h3>
  </div>
  <div class="container-fuild feature mt-4">
    <div class="row">
      <div class="col-lg-2 col-md-4 col-sm-4">
        <div class="card d-flex align-items-center mb-4">
          <img src="https://cdn-icons-png.flaticon.com/512/7078/7078643.png" class="card-img-top" alt="..." style="border-radius: 50%;">
          <div class="card-body">
            <h6 class="card-title text-center">low calorie</h6>
          </div>
        </div>
      </div>
      <div class="col-lg-2 col-md-4 col-sm-4">
        <div class="card d-flex align-items-center mb-4">
          <img src="http://villemagazine.com/images/easyblog_articles/323/b2ap3_large_5-ways-to-eat-less-sugar.jpg" class="card-img-top" alt="...">
          <div class="card-body">
            <h6 class="card-title text-center">less than 9g of natural sugars</h6>
          </div>
        </div>
      </div>
      <div class="col-lg-2 col-md-4 col-sm-4">
        <div class="card  d-flex align-items-center mb-4">
          <img src="https://www.ecofriendlyhabits.com/wp-content/uploads/2022/01/organic-face-serum.jpg" class="card-img-top" alt="...">
          <div class="card-body">
            <h6 class="card-title text-center">organic adaptogen extracts
            </h6>
          </div>
        </div>
      </div>
      <div class="col-lg-2 col-md-4 col-sm-4">
        <div class="card  d-flex align-items-center mb-4">
          <img src="https://insanelygoodrecipes.com/wp-content/uploads/2023/02/Lychees-1024x1024.jpg" class="card-img-top" alt="...">
          <div class="card-body">
            <h6 class="card-title text-center">whole fruit pulps & juices</h6>
          </div>
        </div>
      </div>
      <div class="col-lg-2 col-md-4 col-sm-4">
        <div class="card  d-flex align-items-center mb-4">
          <img src="https://www.hellofitnessmagazine.com/image/catalog/blog/blogs-image/guide_to_finding_inner_balance_stress_management_techniques_by_hello_fitness_magazine.jpeg" class="card-img-top" alt="...">
          <div class="card-body">
            <h6 class="card-title text-center">stress-balancing
            </h6>
          </div>
        </div>
      </div>
      <div class="col-lg-2 col-md-4 col-sm-4">
        <div class="card d-flex align-items-center mb-4">
          <img src="https://img.freepik.com/premium-psd/elegant-candle-logo-mockup_23-2151656126.jpg" class="card-img-top" alt="..." style=" height: 100px;">
          <div class="card-body">
            <h6 class="card-title text-center">aromatherapeutic blends</h6>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!--Product Category-->
<div class="container mb-4">
  <div class="row">
    <div class="col-lg-6 d-flex justify-content-center align-items-center">
        <div class="card border-0">
          <div class="card-body benefit">
            <h5 class="fw-bold" style="color: rgb(159, 9, 2);">Explore Our Categories</h5><hr>
            <h2 class="card-title fw-bold">Say goodbye to sluggish summer days and hello to hydration with purpose</h2>
            <h4 class="card-text">Droplet presents drinks, that are your <b>summer refreshers, packed with stress-fighting adaptogens, skin-loving antioxidants, mood-lifting superfoods,</b> and <b>vitamin-rich blends</b> that keep you glowing from sunrise to sunset.<br>
              Whether it’s a chilled <b>sparkling drink</b>, a fruity <b>smoothie</b>, a crisp <b>iced tea</b>, or a <b>water powder boost</b>on-the-go — Droplet helps you stay cool, energized, and balanced even on the hottest days.<br>
              No sugar crashes, no artificial junk. Just clean, nourishing sips your body will thank you for.
            </h4>
          </div>
        </div>
    </div>
    <div class="col-lg-6">
      <div class="row"> 
        <?php
        $select_query = mysqli_query($conn, "SELECT * FROM `category` WHERE 1");
        if (mysqli_num_rows($select_query) > 0) {
          while ($category = mysqli_fetch_assoc($select_query)) {
            ?>
            <div class="col-md-6 col-sm-12">
              <div class="card mb-3 d-flex flex-column">
                <div class="img-wrapper " style="flex-grow: 1;">
                  <img src="<?php echo $category['photo']; ?>" class="" alt="...">
                </div>
                <div class="card-body d-flex flex-column">
                  <h4><?php echo $category['category_title']; ?></h4>
                  <p><?php echo $category['category_description']; ?></p>
                  <a href="category.php?id=<?php echo $category['id'];?>" class="btn btn-outline-dark">View More</a>
                </div>
              </div>
            </div>
            <?php
          }
        }
        ?>
      </div>
    </div>
  </div>
</div>

<!--offer-->
<div class="container-fluid mb-5 mt-5">
    <div class="heading text-center mb-3">
      <h2 class="fw-bold">Sip Into Summer – Hot Deals, Cool Drinks</h2>
  </div>
  <div class="container mt-4">
    <div class="row">
      <div class="col-md-6 col-sm-6">
        <div class="card mb-3 text-center shadow-sm" style="background-color:rgb(243, 217, 196);"> 
          <div class="card-body">
            <h5 class="card-title fw-bold">☀️ Summer Glow Combo – Flat 20% OFF</h5>
            <p class="card-text">Bundle 1 adaptogen drink + 1 juice + 1 smoothie for Droplet-Lovers<br><b>Use Coupon Code - SUMMERGLOW20</b></p>
          </div>
        </div>
      </div>
      <div class="col-md-6 col-sm-6">
        <div class="card mb-3 text-center shadow-sm" style="background-color:rgb(251, 246, 237);"> 
          <div class="card-body">
            <h5 class="card-title fw-bold">🌿 Flat 25% OFF on Your First Order (Above ₹499)</h5>
            <p class="card-text">Perfect for new users — low-risk trial<br><b>Use Coupon Code - DropletNewbie25</b></p>
          </div>
        </div>
      </div>
      <div class="col-md-6 col-sm-6">
        <div class="card mb-3 text-center shadow-sm" style="background-color:rgb(251, 246, 237);"> 
          <div class="card-body">
            <h5 class="card-title fw-bold">🎁 Free Wellness Gift on Orders Above ₹999</h5>
            <p class="card-text">Treat yourself to a surprise wellness gift <br> because your health deserves a little extra love</p>
          </div>
        </div>
      </div>
      <div class="col-md-6 col-sm-6">
        <div class="card mb-3 text-center shadow-sm" style="background-color:rgb(243, 217, 196);"> 
          <div class="card-body">
            <h5 class="card-title fw-bold">🔥 Flash Sale: Smoothie Sundays – 15% OFF Every Sunday</h5>
            <p class="card-text">Because your Sundays deserve a delicious, healthy reward! <br><b>Use Coupon Code - SmoothieSunday15</b></p>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!--all products-->
<div class="container-fluid mt-5 mb-4">
  <div class="heading text-center mb-4">
      <h2 class="fw-bold">Explore Our Refreshing Collection</h2>
  </div>
  <div class="container-fluid pt-1 mt-4">
    <div class="row">
      <?php
        $select_query = mysqli_query($conn, "SELECT * FROM `product` WHERE 1");
        if(mysqli_num_rows($select_query)>0){
          while($product = mysqli_fetch_assoc($select_query)){
          ?>
              <div class="col-md-4 col-lg-2 col-sm-6">
                <div class="card mb-3 d-flex flex-column">
                    <div class="img-wrapper " style="flex-grow: 1;">
                      <img src="<?php echo $product['p_img'];?>" class="" alt="...">
                    </div>
                    <div class="card-body d-flex flex-column">
                      <div class="text-center mb-2"><b><a href="Product_details.php?id=<?php echo $product['id'];?>"><?php echo $product['p_title'];?><br>-<?php echo $product['company'];?></a></b></div>
                      <div class="text-center mb-3"><h5>Rs. <?php echo $product['p_price'];?></h5>Inclusive of all taxes</div>
                      <a class="btn btn-outline-primary" href="add_to_cart.php?product-id=<?php echo $product['id'];?>">ADD TO CART</a>
                    </div>
                </div> 
              </div>
            <?php
          }
        }
      ?>
      
      
    </div>
  </div>
</div>

<!--health benefit-->
<div class="container-fluid mb-5 mt-5 bg-image">
  <div class="heading text-center mb-3">
    <h3 class="fw-bold">Why Droplet?</h3>
    <h5 class="fw-semibold">Because your wellness deserves better</h5><hr>
  </div>
  <!-- Swiper -->
  <div class="swiper mySwiper1">
    <div class="swiper-wrapper pb-3">
      <div class="swiper-slide">
        <div class="card border-0 shadow-none mb-3 bg-transparent">
          <div class="card-body">
            <h4 class="card-title">🛡️Boosts Immunity</h4>
            <p class="card-text">Your body’s best friend in every season. Our blends are rich in nature’s defenders — adaptogens, herbs, and vitamins — working gently to strengthen your immunity and keep you feeling your best, every single day.</p>
          </div>
        </div>
      </div>
      <div class="swiper-slide">
        <div class="card border-0 shadow-none mb-3 bg-transparent">
          <div class="card-body">
            <h4 class="card-title">🌿Melts Away Stress & Fatigue</h4>
            <p class="card-text">Long days? Heavy minds? Let nature help. Droplet’s adaptogens softly ease your stress, restore inner calm, and help you bounce back — focused, light, and in control</p>
          </div>
        </div>
      </div>
      <div class="swiper-slide">
        <div class="card border-0 shadow-none mb-3 bg-transparent">
          <div class="card-body">
            <h4 class="card-title">🍋Happy Gut, Happy You</h4>
            <p class="card-text">Each sip supports smooth digestion with plant-based enzymes, fiber, and anti-bloat ingredients — because we believe wellness starts from within. No discomfort, just happy tummies.</p>
          </div>
        </div>
      </div>
      <div class="swiper-slide">
        <div class="card border-0 shadow-none mb-3 bg-transparent">
          <div class="card-body">
            <h4 class="card-title">✨Radiance from Within</h4>
            <p class="card-text">Your skin glows differently when it’s nourished right. With vitamin-rich fruits and glow-boosting herbs, Droplet helps bring out that natural radiance — no filters needed.</p>
          </div>
        </div>
      </div>
      <div class="swiper-slide">
        <div class="card border-0 shadow-none mb-3 bg-transparent">
          <div class="card-body">
            <h4 class="card-title">💧Deep, Delicious Hydration</h4>
            <p class="card-text">Not just water — it’s hydration with purpose. Packed with minerals and natural electrolytes, each sip helps your body absorb more, feel better, and stay refreshed longer.</p>
          </div>
        </div>
      </div>
      <div class="swiper-slide">
        <div class="card border-0 shadow-none mb-3  bg-transparent">
          <div class="card-body">
            <h4 class="card-title">⚖️Gentle Hormone Support</h4>
            <p class="card-text">We understand how delicate balance can be. Droplet’s adaptogen-powered blends support hormonal harmony, helping you manage mood, sleep, and monthly cycles with more ease.</p>
          </div>
        </div>
      </div>
    </div>
    <div class="swiper-button-next"></div>
    <div class="swiper-button-prev"></div>
    <div class="swiper-pagination"></div>
  </div>
</div>

<!--testimonial-->
<div class="container-fluid mb-4 pt-2">
  <div class="heading text-center mb-3">
    <h3 class="fw-bold">Loved by Thousands — Here's Why</h3>
  </div>
  <div class="container">
    <div class="swiper mySwiper2">
      <div class="swiper-wrapper">
        <div class="swiper-slide">
          <div class="card shadow bg-light mb-5">
            <div class="card-body">
              <p class="card-text">"I was honestly skeptical at first, but after trying Droplet's adaptogen drink, I felt calmer and more energized without needing my 4PM coffee crash. It's now part of my daily routine."<br><b>— Ritika S., 27, Bangalore</b></p>
            </div>
          </div>
        </div>
        <div class="swiper-slide">
          <div class="card shadow bg-light mb-5">
            <div class="card-body">
              <p class="card-text">“I gifted myself the Hydration Pack, and wow — my skin is clearer, and I feel less bloated. The smoothies actually taste amazing, not like medicine.”<br><b>— Aarav M., 31, Mumbai</b></p>
            </div>
          </div>
        </div>
        <div class="swiper-slide">
          <div class="card shadow bg-light mb-5">
            <div class="card-body">
              <p class="card-text">“Droplet is my little self-care moment every day. The packaging is cute, the flavors are natural, and it actually makes me feel good — inside and out.”<br><b>— Anjali P., 24, Kolkata</b></p>
            </div>
          </div>
        </div>
        <div class="swiper-slide">
          <div class="card shadow bg-light mb-5">
            <div class="card-body">
              <p class="card-text">“As someone who works long hours, these drinks have become my healthy energy fix. No sugar crash, just clean focus and a refreshed vibe.”<br><b>— Karan D., 35, Delhi</b></p>
            </div>
          </div>
        </div>
        <div class="swiper-slide">
          <div class="card shadow bg-light mb-5">
            <div class="card-body">
              <p class="card-text">“I tried the Sunday Smoothie offer and now I wait for Sundays! It's such a treat. Tastes amazing and makes me feel so light.”<br><b>— Tanisha R., 21, Pune</b></p>
            </div>
          </div>
        </div>
        <div class="swiper-slide">
          <div class="card shadow bg-light mb-5">
            <div class="card-body">
              <p class="card-text">“Honestly, Droplet is the only wellness brand I trust now. Clean ingredients, no gimmicks — and my digestion has actually improved.”<br><b>— Neha G., 29, Hyderabad</b></p>
            </div>
          </div>
        </div>
        <div class="swiper-slide">
          <div class="card shadow bg-light mb-5">
            <div class="card-body">
              <p class="card-text">“Not gonna lie, I bought it for the aesthetic — but stayed for how it made me feel. The adaptogen drinks really help with my anxiety and sleep.”<br><b>— Zayan M., 23, Lucknow</b></p>
            </div>
          </div>
        </div>
      </div>
      <div class="swiper-pagination"></div>
    </div>
  </div>
</div>

<!--footer-->
<?php 
include("common_footer.php");
?>
<!-- Swiper JS -->
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<!-- Initialize Swiper -->
  <script>
    var swiper = new Swiper(".mySwiper1", {
      cssMode: true,
      navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
      },
      pagination: {
        el: ".swiper-pagination",
      },
      mousewheel: true,
      keyboard: true,
    });

    var swiper = new Swiper(".mySwiper2", {
      slidesPerView: 3,
      spaceBetween: 30,
      pagination: {
        el: ".swiper-pagination",
        clickable: true,
      },
    });
  </script>
