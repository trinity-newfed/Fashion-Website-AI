<?php
$host = "localhost";
$user = "root";
$password = "";
$dbname = "TF_Database";

$conn = new mysqli($host, $user, $password, $dbname);
if ($conn->connect_error) {
    die("Lỗi kết nối: " . $conn->connect_error);
}
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../Css/home.css">
</head>
<body>
    <section id="head">
        <div id="head-logo">
            <p>Trinity</p>
        </div>
        <div id="head-banner-container">
            <img src="../Pictures/Banners/bannerImg (1).png" alt="">
            <div id="banner-container">
                <div id="head-banner-text-container">
                    <h1>SUPER DEALS</h1>
                    <span>GET THE NEWEST COLLECTION</span>
                </div>
            </div>
        </div>
    </section>
    <div id="territory">
        <div class="line">______</div>
        <span>
            OUR NEW COLLECTION
        </span>
        <div class="line">______</div>
    </div>
    <section id="body">
        <div id="body-content-container">
            <div id="content-container">
                <h1>OUR NEWEST COLLECTION</h1>
                <span>GET SALE UP TO 20%</span>
            </div>
            <div id="image-container">
                <img src="../Pictures/Collections/Body_collection.png" alt="" id="s-img0">
            </div>
            <div id="slide-container">
                <div class="variant"><img src="../Pictures/Collections/Collection-1.png" alt="" id="s-img1"></div>
                <div class="variant"><img src="../Pictures/Collections/Collection-2.png" alt="" id="s-img2"></div>
                <div class="variant"><img src="../Pictures/Collections/Collection-3.png" alt="" id="s-img3"></div>
            </div>
            <div class="cta-group">
                <button class="shop-btn">SHOP NOW</button>
                <div class="play-btn">
                    <div class="circle">
                        <div class="triangle"></div>
                    </div>
                </div>
            </div>

        </div>
    </section>
    <div id="territory">
        <div class="line">______</div>
        <span>
            STYLE
        </span>
        <div class="line">______</div>
    </div>
    <section id="footer">
        <div id="footer-text">
            <span>where</span>
            <span>art takes<br>places</span>
        </div>
        <div id="designer">
            <div id="avatar-container">
                <div class="avatar"></div>
                <div class="avatar"></div>
            </div>
            <div id="content-text">Where personal style meets bold expression — discover curated fashion that empowers your identity, elevates your everyday moments, and defines who you are, only here at our digital destination for modern style</div>
        </div>
        <div id="explore">
            <div id="explore-advertise">
                <span>400K</span>
                <span>Worldwide</span>
            </div>
        </div>
        <div id="explore-button">
            <svg class="explore-icon" viewBox="0 0 384 512">
                <path d="M214.6 9.4c-12.5-12.5-32.8-12.5-45.3 0l-160 160c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L160 109.3V480c0 17.7 14.3 32 32 32s32-14.3 32-32V109.3l105.4 105.4c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3l-160-160z"/>
            </svg>
        </div>
        <div></div>
        <div id="footer-image-container">
            <img src="../Pictures/Banners/BannerImg (2).png" alt="">
        </div>
    </section>
    <section id="menu">
        <div id="text-menu">
            <div id="logo">T</div>
            <div id="text">
                <span>New Arrival</span>
                <span>Tops</span>
                <span id="t-bottoms">Bottoms</span>
                <span>Accesorires</span>
                <span>About</span>
            </div>
        </div>
        <div id="utility-menu">
            <svg class="icon" viewBox="0 0 640 512" aria-hidden="true">
                <path fill="currentColor" d="M24 0C10.7 0 0 10.7 0 24s10.7 24 24 24h45.3c3.9 0 7.2 2.8 7.9 6.6l52.1 286.3C135.5 375.1 165.3 400 200.1 400H456c13.3 0 24-10.7 24-24s-10.7-24-24-24H200.1c-11.6 0-21.5-8.3-23.6-19.7l-5.1-28.3h303.6c30.8 0 57.2-21.9 62.9-52.2L568.9 85.9C572.6 66.2 557.5 48 537.4 48H124.7l-.4-2C119.5 19.4 96.3 0 69.2 0H24zm184 512a48 48 0 1 0 0-96 48 48 0 1 0 0 96zm224 0a48 48 0 1 0 0-96 48 48 0 1 0 0 96z"/>
            </svg>
            <?php if(isset($_SESSION['username'])): ?>
                <p><?=$_SESSION['username']?></p>
                <?php if(!empty($_SESSION['img'])): ?>
                    <div id="user-account">
                        <img id="user-avatar" src="../upload/<?= htmlspecialchars($_SESSION['img']) ?>" alt="avatar">
                    </div>
                <?php endif; ?>
            <?php else: ?>
                <div id="login-btn">
                    <form action="../Database/createdatabase.php" method="post" style="width: 100%; height: 100%;">
                        <input type="submit" value="Login" style="width: 100%; height: 100%; background-color: transparent; border: none; color: white;">
                    </form>
                
                </div>
            <?php endif; ?>
        </div>
    </section>
    <script>

    </script>
</body>
</html>