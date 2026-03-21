<?php 
$host = "localhost";
$user = "root";
$password = "";
$dbname = "TF_Database";

$conn = new mysqli($host, $user, $password, $dbname);

session_start();

if(!isset($_SESSION['username']) || $_SESSION['role'] != "user"){
    echo"<script>
            alert('Please login to use this feature!');
            window.location.href='reglog.php';
        </script>";
        exit;
}

$username = $_SESSION['username'];

$usersql = "SELECT * FROM userdata WHERE email = ?";

$stmt = $conn->prepare($usersql);
$stmt->bind_param("s", $username);
$stmt->execute();
$userdata = $stmt->get_result();
$users = $userdata->fetch_assoc();;
$stmt->close();
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trinity - Tier</title>
    <link rel="stylesheet" href="../Css/userTier.css">
    <link rel="icon" type="image/png" href="../Pictures/Banners/logo.png">
    <link
      href="https://fonts.googleapis.com/css2?family=Birthstone&family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap"
      rel="stylesheet"/>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300..700;1,300..700&display=swap" rel="stylesheet">
</head>
<body>

<div class="container">
        <?php if($users['user_tier'] == "1"): ?>
        <div class="row row-tier-1">
            <div class="card bronze">
                <div class="card-header">
                    <div class="user-info">
                        <div class="avatar"></div>
                        <span><?=$_SESSION['username']?></span>
                    </div>
                </div>
                <div class="card-body">
                    <h3>New Member</h3>
                    <div class="progress-bar"><div class="progress" style="width: 10%;"></div></div>
                    <p class="next-step">Spend $200 more to upgrade your tier to silver</p>
                </div>
                <div class="card-footer">
                    <span>Get more deals for loyal customer</span>
                    <i>&rsaquo;</i>
                </div>
            </div>
        </div>
        <?php endif; ?>
        <?php if($users['user_tier'] == "2"): ?>
        <div class="row row-tier-2">
            <div class="card silver">
                <div class="card-header">
                    <div class="user-info">
                        <div class="avatar"></div>
                        <span><?=$_SESSION['username']?></span>
                    </div>
                </div>
                <div class="card-body">
                    <h3>Silver</h3>
                    <div class="progress-bar"><div class="progress" style="width: 15%;"></div></div>
                    <p class="next-step">Spend $1000 more to upgrade your tier to gold</p>
                </div>
                <div class="card-footer">
                    <span>Get more deals for loyal customer</span>
                    <i>&rsaquo;</i>
                </div>
            </div>
        </div>
        <?php endif; ?>
        <?php if($users['user_tier'] == "3"): ?>
        <div class="row row-tier-3">
            <div class="card gold">
                <div class="card-header">
                    <div class="user-info">
                        <div class="avatar"></div>
                        <span><?=$_SESSION['username']?></span>
                    </div>
                </div>
                <div class="card-body">
                    <h3>Gold</h3>
                    <div class="progress-bar"><div class="progress" style="width: 20%;"></div></div>
                    <p class="next-step">Spend $4000 more to upgrade your tier to diamond</p>
                </div>
                <div class="card-footer">
                    <span>Get more deals for loyal customer</span>
                    <i>&rsaquo;</i>
                </div>
            </div>
        </div>
        <?php endif; ?>
        <?php if($users['user_tier'] == "4"): ?>
        <div class="row row-tier-4">
            <div class="card diamond">
                <div class="card-header">
                    <div class="user-info">
                        <div class="avatar"></div>
                        <span><?=$_SESSION['username']?></span>
                    </div>
                </div>
                <div class="card-body">
                    <h3>Diamond</h3>
                    <div class="progress-bar"><div class="progress" style="width: 30%;"></div></div>
                </div>
                <div class="card-footer">
                    <span>Get more deals for loyal customer</span>
                    <i>&rsaquo;</i>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </div>
<section id="menu">
        <div id="text-menu">
            <div id="logo" onclick="window.location.href='../Pages/'">TRINITY</div>
            <div id="text">
                <span onclick="window.location.href='../Pages/'">Home</span>
                <span onclick="window.location.href='products.php?#product-section'">Shop</span>
                <span onclick="window.location.href='products.php?#product-section'">Collection</span>
                <span onclick="window.location.href='contact.php'">Contact</span>
            </div>
        </div>
        <input type="checkbox" id="menu-toggle" hidden>
        <div id="utility-menu">
            <label class="hamburger" for="menu-toggle">
                    <svg viewBox="0 0 32 32">
                        <path class="line line-top-bottom" d="M27 10 13 10C10.8 10 9 8.2 9 6 9 3.5 10.8 2 13 2 15.2 2 17 3.8 17 6L17 26C17 28.2 18.8 30 21 30 23.2 30 25 28.2 25 26 25 23.8 23.2 22 21 22L7 22"></path>
                        <path class="line" d="M7 16 27 16"></path>
                    </svg>
            </label>
            <svg class="icon" viewBox="0 0 640 512" aria-hidden="true" onclick="window.location.href='cart.php'">
                <path fill="currentColor" d="M24 0C10.7 0 0 10.7 0 24s10.7 24 24 24h45.3c3.9 0 7.2 2.8 7.9 6.6l52.1 286.3C135.5 375.1 165.3 400 200.1 400H456c13.3 0 24-10.7 24-24s-10.7-24-24-24H200.1c-11.6 0-21.5-8.3-23.6-19.7l-5.1-28.3h303.6c30.8 0 57.2-21.9 62.9-52.2L568.9 85.9C572.6 66.2 557.5 48 537.4 48H124.7l-.4-2C119.5 19.4 96.3 0 69.2 0H24zm184 512a48 48 0 1 0 0-96 48 48 0 1 0 0 96zm224 0a48 48 0 1 0 0-96 48 48 0 1 0 0 96z"/>
            </svg>
            <?php if(isset($_SESSION['username'])): ?>
                <p onclick="window.location.href='user.php'" id="menu-Username"><?=$_SESSION['username']?></p>
            <?php else: ?>
                    <input type="submit" value="Login" id="login-input" onclick="window.location.href='reglog.php'" hidden>
                    <label for="login-input">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" viewBox="0 0 448 512">
                            <path d="M144 128a80 80 0 1 1 160 0 80 80 0 1 1 -160 0zm208 0a128 128 0 1 0 -256 0 128 128 0 1 0 256 0zM48 480c0-70.7 57.3-128 128-128l96 0c70.7 0 128 57.3 128 128l0 8c0 13.3 10.7 24 24 24s24-10.7 24-24l0-8c0-97.2-78.8-176-176-176l-96 0C78.8 304 0 382.8 0 480l0 8c0 13.3 10.7 24 24 24s24-10.7 24-24l0-8z"/>
                        </svg>
                    </label>
            <?php endif; ?>
        </div>
<div id="fast-menu">
    <div class="menu-item">
        <div class="menu-title">TRINITY</div>
            <div class="submenu">
                <div class="submenu-item">T-shirt
                    <div class="sub-sub" onclick="window.location.href='products.php?category=men&name=Basic T-shirt#product-header'">Basic</div>
                    <div class="sub-sub" onclick="window.location.href='products.php?category=men&name=Oversize T-shirt#product-header'">Oversize</div>
            </div>
            <div class="submenu-item">Polo shirt
                <div class="sub-sub" onclick="window.location.href='products.php?category=men&name=Basic Polo#product-header'">Basic</div>
                <div class="sub-sub" onclick="window.location.href='products.php?category=men&name=Logo Polo#product-header'">Logo</div>
            </div>
            <div class="submenu-item">Hoodie
                <div class="sub-sub" onclick="window.location.href='products.php?category=men&name=Hoodie#product-header'">Signature</div>
            </div>
        </div>
    </div>
    <div class="menu-item">
        <div class="menu-title">TRINITY LADIES</div>
        <div class="submenu">
            <div class="submenu-item">T-shirt
                <div class="sub-sub" onclick="window.location.href='products.php?category=women&name=Basic T-shirt#product-header'">Basic</div>
                <div class="sub-sub" onclick="window.location.href='products.php?category=women&name=Oversize T-shirt#product-header'">Oversize</div>
            </div>
            <div class="submenu-item">Blouse
                <div class="sub-sub" onclick="window.location.href='products.php?category=women&name=Classic Blouse#product-header'">Classic</div>
                <div class="sub-sub" onclick="window.location.href='products.php?category=women&name=Wrap Blouse#product-header'">Warp</div>
            </div>
            <div class="submenu-item">Crop top
                <div class="sub-sub" onclick="window.location.href='products.php?category=women&name=Basic CropTop#product-header'">Basic</div>
                <div class="sub-sub" onclick="window.location.href='products.php?category=women&name=Tank CropTop#product-header'">Tank</div>
            </div>
        </div>
    </div>
    <div class="menu-item">
        <div class="menu-title">GIFT VOUNCHER</div>
        <div class="submenu">
            <div onclick="window.location.href='voucher.php'">Check voucher</div>
        </div>
    </div>
    <div class="menu-item">
        <div class="menu-title">TRINITY TIER</div>
        <div class="submenu">
            <div onclick="window.location.href='userTier.php'">Check your shopping tier</div>
        </div>
    </div>
    <div class="menu-item">
        <div class="menu-title">ABOUT</div>
    </div>
</div>
</section>
<footer class="footer-2">
  <div class="footer-container">
    <div class="footer-left">
      <p class="footer-label">CONTACT US</p>
      <h2 class="footer-title">
        Let’s Discuss Your <br> Style. With Us
      </h2>
      <button class="footer-btn">
        Schedule a call now →
      </button>
      <p class="footer-email-label">OR EMAIL US AT</p>
      <div class="footer-email">
        triple3tbusiness@gmail.com
        <span>📋</span>
      </div>
    </div>

    <div class="footer-right">
      <div class="footer-col">
        <p class="footer-col-title">QUICK LINKS</p>
        <a href="#">Home</a>
        <a href="#">Case Studies</a>
        <a href="#">Gallery</a>
        <a href="#">Blogs</a>
        <a href="#">About Us</a>
      </div>
      <div class="footer-col">
        <p class="footer-col-title">INFORMATION</p>
        <a href="#">Terms of Service</a>
        <a href="#">Privacy Policy</a>
        <a href="#">Cookies Settings</a>
      </div>
    </div>
  </div>

  <div class="footer-bottom">
    <p>Copyright (c) 2026 trinity-newfed</p>

    <div class="footer-social">
      <span>f</span>
      <span>t</span>
      <span>ig</span>
      <span>in</span>
    </div>
  </div>
</footer>
</body>
<script>
    cons
    const email = <?= isset($_SESSION['username']) ? json_encode($_SESSION['username']) : '""' ?>;
      let username1 = email.replace("@gmail.com", "");
      const userWelcome = document.getElementById("menu-Username");
      const menuTitles = document.querySelectorAll(".menu-title");


      if(userWelcome){
            userWelcome.textContent = "Hi, " + username1;
        }
        menuTitles.forEach(title =>{
                title.addEventListener("click", ()=>{
                    const parent = title.parentElement;
                    parent.classList.toggle("active");
            });
        });
        const submenuItems = document.querySelectorAll(".submenu-item");
            submenuItems.forEach(item =>{
                item.addEventListener("click",(e)=>{
                    e.stopPropagation();
                    item.classList.toggle("active");
            });
        });
</script>
</html>