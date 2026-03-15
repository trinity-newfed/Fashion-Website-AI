<?php
include "../Database/createdatabase.php";
session_start();

$product = $conn
  ->query("SELECT * FROM products")
  ->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="../Css/home.css">
    <link rel="icon" type="image/png" href="../Pictures/Banners/logo.png">
    <link
      href="https://fonts.googleapis.com/css2?family=Birthstone&family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap"
      rel="stylesheet"/>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300..700;1,300..700&display=swap" rel="stylesheet">
</head>
<body>
<section id="head">
    <div id="head-slider">
    <div id="head-banner-container">
        <img src="../Pictures/Banners/BannerImg-1.png">
        <div id="hero-text">
            <h1>NEW<br>COLLECTION</h1>
            <p>Timeless essentials for the modern wardrobe</p>
            <button onclick="window.location.href='products.php'">Shop Now</button>
        </div>
    </div>
    <div id="head-banner-container-2">
        <div>
            <img src="../Pictures/Banners/BannerImg-2.png">
            <div id="hero-text-2">
            <p>DISCOVER THE NEW</p>
            <h1>COLLECTION</h1>
            <div class="title"></div>
            <p>MODERN STREETWEAR <br>POWERED BY AI STYLING</p>
        </div>
        <button id="scroll-btn" onclick="window.location.href='products.php'">Scroll to explore</button>
        </div>
        <div></div>
    </div>  
    </div>

    <button id="next-btn">
        <svg class="icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
            <path d="M566.6 278.6c12.5-12.5 12.5-32.8 0-45.3l-128-128c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L466.7 224 32 224c-17.7 0-32 14.3-32 32s14.3 32 32 32l434.7 0-73.4 73.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0l128-128z"/>
        </svg>
    </button>
</section>
    <div class="territory">
        <div class="line"></div>
        <span>CATEGORY</span>
        <p>Discover pieces that define your style</p>
        <div class="line"></div>
    </div>
    <div id="category">
                <div>
                    <img onclick="window.location.href='products.php?category=all&name=T-shirt#product-header'" src="../Pictures/Icon/T-shirt.png" id="icon-1" alt="">
                    <label for="icon-1" onclick="window.location.href='products.php?category=all&name=T-shirt#product-header'">T-SHIRT</label>
                </div>
                <div>
                    <img onclick="window.location.href='products.php?category=all&name=Polo#product-header'" src="../Pictures/Icon/Polo.png" id="icon-2" alt="">
                    <label onclick="window.location.href='products.php?category=all&name=Polo#product-header'" for="icon-2">POLO</label>
                </div>
                <div>
                    <img onclick="window.location.href='products.php?category=all&name=Hoodie#product-header'" src="../Pictures/Icon/Hoodie.png" id="icon-3" alt="">
                    <label onclick="window.location.href='products.php?category=all&name=Hoodie#product-header'" for="icon-3">HOODIE</label>
                </div>
                <div>
                    <img onclick="window.location.href='products.php?category=all&name=Blouse#product-header'" src="../Pictures/Icon/Blouse.png" id="icon-4" alt="">
                    <label onclick="window.location.href='products.php?category=all&name=Blouse#product-header'" for="icon-4">BLOUSE</label>
                </div>
                <div>
                    <img onclick="window.location.href='products.php?category=all&name=Crop Top#product-header'" src="../Pictures/Icon/CropTop.png" id="icon-5" alt="">
                    <label onclick="window.location.href='products.php?category=all&name=Crop Top#product-header'" for="icon-5">CROPTOP</label>
                </div>
            </div>
    <section id="body">
        <div id="body-content-container">
            <div id="newest-collection">
                <div>
                    <img id="b-img1" src="../Pictures/Banners/Background-2.png">
                    <img id="b-img2" style="z-index: 3; bottom: 2.5%; right: 2.5%; width: 100%; height: 100%; max-width: 500px; max-height: 697px; object-fit: cover; object-position: center 10%; position: absolute;" src="../Pictures/Banners/Beige-Demo.png" alt="">
                    <img id="b-img3" style="z-index: 3; bottom: 20.8%; right: 6.5%; width: 100%; height: 100%; max-width: 400px; max-height: 500px; object-fit: cover; object-position: center 10%; position: absolute;" src="../Pictures/Banners/White-Demo.png" alt="">
                    <img style="filter: contrast(120%) saturate(110%); bottom: 0; right: 10%; width: 100%; height: 100%; max-width: 300px; max-height: 800px; object-fit: cover; object-position: center 10%; position: absolute;" src="../Pictures/Banners/Bg-Model-1.png">
                    <span>Try on with AI</span>
                    <p>Upload your photo and experience <br> virtual fiting powered by AI</p>
                    <button onclick="window.location.href='products.php#product-section'">Try now</button>
                </div>
            </div>
            <div class="territory">
                <span>
                    Popular Styles
                </span>
            </div>
        </div>
    </section>
    <section id="footer">
        <span>Featured Products</span>
        <p>Discover styles you can instantly try with AI</p>
        <div>
            <?php foreach($product as $p): ?>
                <?php if($p['product_name'] == "Beige Coat"): ?>
            <div>
                <img src="../<?=$p['product_img']?>" alt="" id="f-img1">
                <span><?=$p['product_name']?></span>
                <p>$<?=$p['product_price']?></p>
                <button onclick="window.location.href='products.php#product-<?=$p['id']?>'">Try with AI</button>
            </div>
                <?php endif; ?>
                <?php if($p['product_name'] == "Black Coat"): ?>
            <div>
                <img src="../<?=$p['product_img']?>" alt="" id="f-img2">
                <span><?=$p['product_name']?></span>
                <p>$<?=$p['product_price']?></p>
                <button onclick="window.location.href='products.php#product-<?=$p['id']?>'">View Product</button>
            </div>
                <?php endif; ?>
                <?php if($p['product_name'] == "White Basic Polo"): ?>
            <div>
                <img src="../<?=$p['product_img']?>" alt="" id="f-img3">
                <span><?=$p['product_name']?></span>
                <p>$<?=$p['product_price']?></p>
                <button onclick="window.location.href='products.php#product-<?=$p['id']?>'">Try with AI</button>
            </div>
                <?php endif; ?>
                <?php if($p['product_name'] == "Black Classic Blouse"): ?>
            <div>
                <img src="../<?=$p['product_img']?>" alt="" id="f-img4">
                <span><?=$p['product_name']?></span>
                <p>$<?=$p['product_price']?></p>
                <button onclick="window.location.href='products.php#product-<?=$p['id']?>'">View Product</button>
            </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    </section>
<section id="menu">
        <div id="text-menu">
            <div id="logo" onclick="window.location.href='#head'">TRINITY</div>
            <div id="text">
                <span onclick="window.location.href='#head'">Home</span>
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
                <p onclick="window.location.href='user.php'">Hi, <?=$_SESSION['username']?></p>
                <?php if(!empty($_SESSION['img'])): ?>
                    <div id="user-account" onclick="window.location.href='user.php'">
                        <img id="user-avatar" src="../upload/<?= htmlspecialchars($_SESSION['img']) ?>" alt="avatar">
                    </div>
                <?php endif; ?>
            <?php else: ?>
                    <input type="submit" value="Login" id="login-input" onclick="window.location.href='log.php'" hidden>
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
                    <div class="sub-sub" onclick="window.location.href='products.php?category=men&name=Basic T-shirt'">Basic</div>
                    <div class="sub-sub" onclick="window.location.href='products.php?category=men&name=Oversize T-shirt'">Oversize</div>
            </div>
            <div class="submenu-item">Polo shirt
                <div class="sub-sub" onclick="window.location.href='products.php?category=men&name=Basic Polo'">Basic</div>
                <div class="sub-sub" onclick="window.location.href='products.php?category=men&name=Logo Polo'">Logo</div>
            </div>
            <div class="submenu-item">Hoodie
                <div class="sub-sub" onclick="window.location.href='products.php?category=men&name=Hoodie'">Signature</div>
            </div>
        </div>
    </div>
    <div class="menu-item">
        <div class="menu-title">TRINITY LADIES</div>
        <div class="submenu">
            <div class="submenu-item">T-shirt
                <div class="sub-sub" onclick="window.location.href='products.php?category=women&name=Basic T-shirt'">Basic</div>
                <div class="sub-sub" onclick="window.location.href='products.php?category=women&name=Oversize T-shirt'">Oversize</div>
            </div>
            <div class="submenu-item">Blouse
                <div class="sub-sub" onclick="window.location.href='products.php?category=women&name=Classic Blouse'">Classic</div>
                <div class="sub-sub" onclick="window.location.href='products.php?category=women&name=Wrap Blouse'">Warp</div>
            </div>
            <div class="submenu-item">Crop top
                <div class="sub-sub" onclick="window.location.href='products.php?category=women&name=Basic CropTop'">Basic</div>
                <div class="sub-sub" onclick="window.location.href='products.php?category=women&name=Tank CropTop'">Tank</div>
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
            <div>Check your shopping tier</div>
        </div>
    </div>
    <div class="menu-item">
        <div class="menu-title">ABOUT</div>
    </div>
</div>
</section>
<section id="footer-2">
            <div class="footer-info" id="fi-1">
                <h2>POLICY</h2>
                <p>Term of delivery</p>
                <p>Term of return</p>
                <p>Purchase policy</p>
            </div>

            <div class="footer-info" id="fi-2">
                <h2>ABOUT US</h2>
                <p>Trinity</p>
                <p>Leadership Team</p>
            </div>

            <div class="footer-info" id="fi-3">
                <h2>GET LATEST DEALS AND MORE</h2>
                <span>Email: triple3tbusiness@gmail.com</span>
                <span>Hotline: 0909.xxx.xxx</span>
                <input placeholder="Contact us...">
            </div>


            <div class="footer-info" id="fi-4">
                <h2>SUPPORT</h2>
                <span>Direct chat</span>
                <span>Hotline: 0808.xxx.xxx</span>
                <div style="display: grid; place-items: center;">
                    <h2>Follow up</h2>
                    <input placeholder="Enter your email...">
                </div>
            </div>

            <div class="footer-info" id="fi-5" style="position: absolute; bottom: 5%; width: 100%; height: 10%; border-top: 1px solid gray;">
                <h1>CONTACT US</h1>
            </div>
</section>
    <script>
        const head = document.getElementById("head");
        const body = document.getElementById("body");
        const footer = document.getElementById("footer");       
        const slider = document.getElementById("head-slider");
        const nextBtn = document.getElementById("next-btn");
        let index = 0;
        let bannerInterval = setInterval(() => {
            index++;
            if(index > 1){
                index = 0;
            }
            nextBtn.classList.toggle("rotate");
            slider.style.transform = `translateX(-${index * 100}%)`;
        }, 8000);

        nextBtn.addEventListener("click", () =>{
            clearInterval(bannerInterval);
            index++;
            if(index > 1){
                index = 0;
            }

            bannerInterval = setInterval(() => {
                index++;
                if(index > 1){
                    index = 0;
                }
                nextBtn.classList.toggle("rotate");
                slider.style.transform = `translateX(-${index * 100}%)`;
            }, 8000);

            nextBtn.classList.toggle("rotate");
            slider.style.transform = `translateX(-${index * 100}%)`;
        });



        let num = 0;
        const bodyObserve = new IntersectionObserver(entries =>{
            entries.forEach(entry =>{
                if(entry.isIntersecting){
                    console.log(num);
                setInterval(() => {
                    if(num < 3){
                        num++;
                        if(num == 1){
                            document.getElementById("body-content-container").classList.add("b-show");
                            document.querySelector("#newest-collection span").classList.add("b-show");
                            document.querySelector("#newest-collection p").classList.add("b-show");
                            document.querySelector("#newest-collection button").classList.add("b-show");
                        }else if(num == 2){
                            document.getElementById("b-img3").classList.add("b-show");
                        }else if(num == 3){
                            document.getElementById("b-img2").classList.add("b-show");
                            document.getElementById("b-img3").classList.remove("b-show");
                        }
                    }
                }, 2000);
                }
            });
        });
        const footerObserve = new IntersectionObserver(entries =>{
            entries.forEach(entry =>{
                if(entry.isIntersecting){
                    
                }
            });
        },{
            threshold: 0.5
        });

        bodyObserve.observe(body);
        footerObserve.observe(footer);



        const menuTitles = document.querySelectorAll(".menu-title");
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
</body>
</html>