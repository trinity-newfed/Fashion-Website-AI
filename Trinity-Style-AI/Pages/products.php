<?php
$host = "localhost";
$user = "root";
$password = "";
$dbname = "TF_Database";

$conn = new mysqli($host, $user, $password, $dbname);

session_start();
$username = $_SESSION['username'] ?? null;

$product = $conn
  ->query("SELECT * FROM products")
  ->fetch_all(MYSQLI_ASSOC);


$sql = $conn->prepare("SELECT * FROM user_policy_agreement
                       WHERE username = ?");
$sql->bind_param("s", $username);
$sql->execute();
$agreement = $sql->get_result();
$agree = $agreement->fetch_assoc();
$sql->close();
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Trinity Style - Products</title>
    <link rel="stylesheet" href="../Css/products.css">
    <link rel="icon" type="image/png" href="../Pictures/Banners/logo.png">
    <link
      href="https://fonts.googleapis.com/css2?family=Birthstone&family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap"
      rel="stylesheet"/>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300..700;1,300..700&display=swap" rel="stylesheet">
  </head>
  <body>
    <div id="alertNotice">
      <button id="closeAlertBtn">&times;</button>
      <h4></h4>
      <span></span>
  <div id="alert-div">
    <button class="alertBtn" id="OK-btn">OK</button>
    <button class="alertBtn" id="CANCEL-btn">CANCEL</button>
  </div>
  <form style="display: none;" id="tryon-form" action="http://127.0.0.1:5000/api/generate" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="username" value="<?=$_SESSION['username']?>">
    <input type="file" id="try-on-input" name="person" hidden required>
    <input type="hidden" name="cloth" id="cloth">
    <label id="fileChoose" for="try-on-input">Choose your file</label>
    <button id="genBtn" type="submit">Generate</button>
    <div id="progress-container">
      <span style="position: absolute;"></span>
      <div id="progress"></div>
    </div>
  </form>
  <?php if(!empty($agree) && $agree['policy_id'] == "ai_usage"): ?>
  <form action="../Database/user_policy_agree.php" id="agreementForm" method="POST">
    <input type="checkbox" name="policy_id" value="ai_usage" id="agreeAI" style="position: absolute; bottom: 3%; left: 1%;" required checked>
    <span for="agreeAI" style="position: absolute; bottom: 5%; left: 7.5%; font-size: clamp(.7rem, .8vw, 2rem);">I accept <a href="../legal/ai-usage-policy.php">Trinity AI service</a> policy</span>
  </form>
  <?php else: ?>
  <form action="../Database/user_policy_agree.php" id="agreementForm" method="POST">
    <input type="checkbox" name="policy_id" value="ai_usage" id="agreeAI" style="position: absolute; bottom: 3%; left: 1%;" required>
    <span for="agreeAI" style="position: absolute; bottom: 5%; left: 7.5%; font-size: clamp(.7rem, .8vw, 2rem);">I accept <a href="../legal/ai-usage-policy.php">Trinity AI service</a> policy</span>
  </form>
  <?php endif; ?>
</div>
    <div class="head">
      <div class="banner">
        <div class="banner-left">
          <div class="banner-content">
            <p class="sub-title">Spring / Summer 2026</p>
            <h1>
              Minimalist <br />
              & Timeless
            </h1>
            <p class="description">
              Explore the newest collection and experience minimal style, celebrating pure beauty and delicate craftsmanship with a single needle and thread
            </p>
            <a href="#product-section" class="btn-shop">View Details</a>
          </div>
        </div>
        <div class="banner-right"></div>
      </div>
    </div>
<div class="body">
      <section class="product-section" id="product-section">
        <div class="product-collection">
          <p class="product-subtitle">Collection</p>
          <h2 class="product-title">High Fashion</h2>
          <div class="line"></div>
          <div class="product-container">
          <?php foreach($product as $p): ?>
            <?php if($p['product_category'] == "collections"): ?>
            <div id="product-<?=$p['id']?>" class="product-card fixed" data-img="../<?=$p['product_img']?>" 
                                      data-name="<?=$p['product_name']?>" 
                                      data-price="<?=$p['product_price']?>"
                                      data-id="<?=$p['id']?>"
                                      data-category="<?=$p['product_category']?>"
                                      data-color="<?=$p['product_color']?>">

              <div class="image-box">
                <img
                  src="../<?=$p['product_img']?>"
                  alt="Product"
                />
                <div class="image-overlay">
                  <button class="details-btn">View Details</button>
                </div>
              </div>

              <div class="info-box">
                <span class="brand">TRINITY</span>
                <h2 class="title"><?=$p['product_name']?></h2>

                <div class="price-wrapper">
                  <span class="new-price">$<?=$p['product_price']?></span>
                </div>
              </div>
            </div>
            <?php endif; ?>
          <?php endforeach; ?>
          </div>
        </div>
        </div>
        <div class="product-header" id="product-header">
          <p class="product-subtitle">Shop Wardrobe</p>
            <h2 class="product-title">ALL</h2>
            <div class="line"></div>
            <select name="" id="sort" style="width: fit-content; height: 30px; margin-top: 5px;">
              <option value="">--Sort--</option>
              <option value="price_desc">Highest</option>
              <option value="price_asc">Lowest</option>
              <option value="name_asc">A to Z</option>
              <option value="name_desc">Z to A</option>
            </select>
        <div class="product-container" id="normal">
          <?php foreach($product as $p): ?>
            <?php if($p['product_category'] != "collections"): ?>
            <div id="product-<?=$p['id']?>" class="product-card" data-img="../<?=$p['product_img']?>" 
                                      data-name="<?=$p['product_name']?>" 
                                      data-price="<?=$p['product_price']?>"
                                      data-id="<?=$p['id']?>"
                                      data-category="<?=$p['product_category']?>"
                                      data-category="<?=$p['product_category']?>"
                                      data-color="<?=$p['product_color']?>">
              <div class="image-box">
                <img
                  src="../<?=$p['product_img']?>"
                  alt="Product"
                />
                <div class="image-overlay">
                  <button class="details-btn">View Details</button>
                </div>
              </div>

              <div class="info-box">
                <span class="brand">TRINITY</span>
                <h2 class="title"><?=$p['product_name']?></h2>

                <div class="price-wrapper">
                  <span class="new-price">$<?=$p['product_price']?></span>
                </div>
              </div>
            </div>
            <?php endif; ?>
          <?php endforeach; ?>
          </div>
        </div>
      </section>
<div id="product-modal">
  <div class="modal-container">
    <div class="modal-left">
      <img id="modal-img" src="" alt="">
    </div>
    <div class="modal-right">
      <span class="close-modal">&times;</span>
      <p class="modal-brand">TRINITY</p>
      <h2 id="modal-name"></h2>
      <p id="modal-price"></p>
      <div class="size-select">
        <p>Size</p>
        <div class="sizes">
          <label for="S-size-<?=$p['id']?>">S</label>
          <label for="M-size-<?=$p['id']?>">M</label>        
          <label for="L-size-<?=$p['id']?>">L</label>        
          <label for="XL-size-<?=$p['id']?>">XL</label>
        </div>
      </div>
          <div id="form-container">
            <form action="../Database/add_item_to_cart.php" method="POST" style="display: grid;" id="addCartForm"> 
                    <input type="hidden" name="username" value="<?=htmlspecialchars($username)?>">    
                    <input type="hidden" name="product_id" id="modal-product-id">
                    <input type="hidden" name="product_category" id="modal-product-category">
                    <input type="hidden" name="product_color" id="modal-product-color">
                    <input type="hidden" name="product_name" id="modal-product-name">
                    <input type="hidden" name="product_type" id="modal-product-type">
                    <input type="radio" name="cart_size" value="S" id="S-size-<?=$p['id']?>" hidden checked>
                    <input type="radio" name="cart_size" value="M" id="M-size-<?=$p['id']?>" hidden>
                    <input type="radio" name="cart_size" value="L" id="L-size-<?=$p['id']?>" hidden>
                    <input type="radio" name="cart_size" value="XL" id="XL-size-<?=$p['id']?>" hidden> 
                    <button class="modal-add add-cart-btn-big" type="submit">ADD TO CART</button>
          </form>
      <div style="align-self: end; position: relative;" id="Try-on-form">
        <button class="modal-try" type="submit">Try with AI✨</button>
        <div id="tooltip-explain">
          <h3>Virtual AI Try On</h3>
          <span>This is an feature for customers to try on our product</span>
        </div>
            </div>
          </div>
      <div id="modal-detail" onclick="window.location.href='Trinity-Style-AI/Pages/detail.php?id=<?=$p['id']?>'">Details</div>
    </div>
  </div>
  </div>  
</div>
<section id="menu">
        <div id="text-menu">
            <div id="logo" onclick="window.location.href='../Pages/'">TRINITY</div>
            <div id="text">
                <span onclick="window.location.href='../Pages/'">Home</span>
                <span onclick="window.location.href='#product-section'">Shop</span>
                <span onclick="window.location.href='#product-section'">Collection</span>
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
                <p onclick="window.location.href='user.php'" id="menu-Username" style="cursor: pointer;"><?=$_SESSION['username']?></p>
                <?php if(!empty($_SESSION['img'])): ?>
                    <div id="user-account" onclick="window.location.href='user.php'">
                        <img id="user-avatar" src="../upload/<?= htmlspecialchars($_SESSION['img']) ?>" alt="avatar">
                    </div>
                <?php endif; ?>
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
                    <div class="sub-sub" data-category="men" data-name="Basic T-shirt" onclick="window.location.href='#product-header'">Basic</div>
                    <div class="sub-sub" data-category="men" data-name="Oversize T-shirt" onclick="window.location.href='#product-header'">Oversize</div>
            </div>
            <div class="submenu-item">Polo shirt
                <div class="sub-sub" data-category="men" data-name="Basic Polo" onclick="window.location.href='#product-header'">Basic</div>
                <div class="sub-sub" data-category="men" data-name="Logo Polo" onclick="window.location.href='#product-header'">Logo</div>
            </div>
            <div class="submenu-item">Hoodie
                <div class="sub-sub" data-category="men" data-name="Signature" onclick="window.location.href='#product-header'">Signature</div>
            </div>
        </div>
    </div>
    <div class="menu-item">
        <div class="menu-title">TRINITY LADIES</div>
        <div class="submenu">
            <div class="submenu-item">T-shirt
                <div class="sub-sub" data-category="women" data-name="Basic T-shirt" onclick="window.location.href='#product-header'">Basic</div>
                <div class="sub-sub" data-category="women" data-name="Oversize T-shirt" onclick="window.location.href='#product-header'">Logo</div>
            </div>
            <div class="submenu-item">Blouse
                <div class="sub-sub" data-category="women" data-name="Classic Blouse" onclick="window.location.href='#product-header'">Classic</div>
                <div class="sub-sub" data-category="women" data-name="Wrap Blouse" onclick="window.location.href='#product-header'">Wrap</div>
            </div>
            <div class="submenu-item">Crop top
                <div class="sub-sub" data-category="women" data-name="Basic CropTop" onclick="window.location.href='#product-header'">Basic</div>
                <div class="sub-sub" data-category="women" data-name="Tank CropTop" onclick="window.location.href='#product-header'">Tank</div>
            </div>
        </div>
    </div>
    <div class="menu-item">
        <div class="menu-title">GIFT VOUNCHER</div>
        <div class="submenu">
            <div onclick="window.location.href='voucher.php'" style="cursor: pointer;">Check voucher</div>
        </div>
    </div>
    <div class="menu-item">
        <div class="menu-title">TRINITY TIER</div>
        <div class="submenu">
            <div onclick="window.location.href='userTier.php'" style="cursor: pointer;">Check your shopping tier</div>
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

      <button class="footer-btn" onclick="window.location.href='contact.php'">
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
        <a href="../Pages/">Home</a>
        <a href="products.php">Products</a>
        <a href="cart.php">Cart</a>
        <a href="voucher.php">Vouchers</a>
        <a href="userTier.php">User Tier</a>
        <a href="#">About Us</a>
      </div>
      <div class="footer-col">
        <p class="footer-col-title">INFORMATION</p>
        <a href="../legal/term-of-service.php">Terms of Service</a>
        <a href="../legal/privacy-policy.php">Privacy Policy</a>
        <a href="../legal/delivery-policy.php">Delivery Policy</a>
        <a href="../legal/ai-usage-policy.php">AI Usage Policy</a>
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
    <script>
      console.log("JS START");

setTimeout(() => {
  console.log("TIMEOUT OK");
}, 2000);
      const email = <?= isset($_SESSION['username']) ? json_encode($_SESSION['username']) : '""' ?>;
      let username1 = email.replace("@gmail.com", "");
      const userWelcome = document.getElementById("menu-Username");
      const isLogin = <?=isset($_SESSION['username']) ? 'true' : 'false'?>;
      const products = document.querySelectorAll(".product-card");
      const conModal = document.querySelector(".modal-container");
      const modal = document.getElementById("product-modal");
      const modalImg = document.getElementById("modal-img");
      const modalName = document.getElementById("modal-name");
      const modalPrice = document.getElementById("modal-price");
      const closeBtn = document.querySelector(".close-modal");
      const modalProductId = document.getElementById("modal-product-id");
      const modalProductCategory = document.getElementById("modal-product-category");
      const modalProductColor = document.getElementById("modal-product-color");
      const modalProductName = document.getElementById("modal-product-name");
      const modalProductType = document.getElementById("modal-product-type");
      const try_on = document.getElementById("Try-on-form");
      const try_on_input = document.getElementById("cloth");
      const addCart = document.querySelectorAll(".add-cart-btn-big");
      const sizeAdd = document.querySelectorAll(".sizes label");
      const alert = document.getElementById("alertNotice");
      const alertName = document.querySelector("#alertNotice h4");
      const alertContent = document.querySelector("#alertNotice span");
      const alertOkBtn = document.getElementById("OK-btn");
      const alertCancelBtn = document.getElementById("CANCEL-btn");
      const formTryOn = document.getElementById("tryon-form");
      const filter = document.querySelectorAll(".sub-sub");
      const params = new URLSearchParams(window.location.search);
      const category = params.get("category");
      const name = params.get("name");
      const sortSelect = document.getElementById("sort");
      const agreeForm = document.getElementById("agreementForm");
      const checked = document.getElementById("agreeAI");
      
      if(checked){
        if(checked.checked != true){
        genBtn.disabled = true;
        genBtn.style.background = "gray";
      }else{
        genBtn.disabled = false;
      }

      checked.addEventListener('change', function(){
        if(checked.checked == true){
          genBtn.disabled = false;
          genBtn.style.background = "";
        }else{
          genBtn.disabled = true;
          genBtn.style.background = "gray";
        }
      });

      agreeForm.addEventListener("submit", async function(e){
        e.preventDefault();
        const formData = new FormData(agreeForm);
        try{
          const res = await fetch("../Database/user_policy_agree.php",{
            method: "POST",
            body: formData
          });
        const text = await res.text();
        }catch(err){
        console.error(err);
        }
      });

      genBtn.addEventListener('click', function(){
        agreeForm.requestSubmit();
      });
      }

      
      if(userWelcome){
            userWelcome.textContent = "Hi, " + username1;
        }

      sizeAdd.forEach(label =>
        label.addEventListener('click', ()=>{
          sizeAdd.forEach(label =>{
            label.style.color = "black";
            label.style.background = "white";
          });
        label.style.color = "white";
        label.style.background = "black";
        })
      )

      const detailBtn = document.getElementById("modal-detail");
      let currentProductId = null;

      products.forEach(product => {
        const viewBtn = product.querySelector(".details-btn");
            viewBtn.addEventListener('click', ()=>{
              modalImg.src = product.dataset.img;
              modalName.textContent = product.dataset.name;
              modalPrice.textContent = "$" + product.dataset.price;
              modalProductId.value = product.dataset.id;
              modalProductCategory.value = product.dataset.category;
              modalProductColor.value = product.dataset.color;
              modalProductName.value = product.dataset.name;
              modalProductType.value = "default";
              currentProductId = product.dataset.id;
              try_on_input.value = product.dataset.img;
              modal.style.setProperty("display", "flex", "important");
            });
      });




      const title = document.querySelector("#product-header .product-title");
      filter.forEach(fil =>{
        fil.addEventListener('click', ()=>{
          const fType = fil.dataset.category;
          const fName = fil.dataset.name;
          title.textContent = fName;
          products.forEach(product =>{
            const pType = product.dataset.category;
            const pName = product.dataset.name;
            const show = pType === "collections" ||
            ((fType === "all" || pType === fType) && pName.includes(fName));
            product.style.display = show ? "" : "none";
          });
        });
      });

      if(name){
        title.textContent = name;
        products.forEach(product =>{
          const pType = product.dataset.category;
          const pName = product.dataset.name;
          const show =
          pType === "collections" || ((category === "all" || pType === category) && pName.includes(name));
          product.style.display = show ? "" : "none";
        });
      }


      let timer;
      const forms = document.getElementById("addCartForm");
      addCart.forEach(btn =>{
        btn.addEventListener('click', function(e){
        e.preventDefault();
        clearTimeout(timer);
        if(!isLogin){
          alert.classList.add("alert");
          closeAlert.style.opacity = "1";
          closeAlert.style.visibility = "visible";
          closeAlert.onclick = () =>{
            alert.classList.remove("alert");
          }
          alertName.textContent = "TRINITY";
          alertContent.textContent = "Please login first to use this feature!";
          alertOkBtn.onclick = () =>{
            window.location.href = "reglog.php";
          };
          alertCancelBtn.onclick = () =>{
            alert.classList.remove("alert");
          };
          timer = setTimeout(function(){
              alert.classList.remove("alert");
          }, 5000);
          return;
        }else{
          fetch("../Database/add_item_to_cart.php", {
          method: "POST",
          body: new FormData(forms)
        })
        .then(res => res.text())
        .then(data => {
          console.log("SERVER:", data);
          clearTimeout(timer);
          alert.classList.add("alert");
          alertName.textContent = "TRINITY";
          alertContent.textContent = "Add item to cart success, view it?";
          document.getElementById("fileChoose").style.display = "none";
          document.getElementById("genBtn").style.display = "none";
          agreeForm.style.display = "none";
          document.getElementById("progress-container").style.display = "none";
          if(alert.classList.contains("tryon") || alert.classList.contains("tryon-close")){
            alert.classList.add("temp");
            alert.classList.remove("tryon");
            alert.classList.remove("tryon-close");
          }
          alertOkBtn.onclick = () => {
            window.location.href = "cart.php";
          };
          alertCancelBtn.style.display = "none";
          alertOkBtn.style.display = "";
          timer = setTimeout(function(){
              alert.classList.remove("alert");
          }, 5000);
        });
        }
        });
      });

      modal.addEventListener('click', function(e){
        if(e.target === modal){
          modal.style.display = "none";
          alert.classList.remove("alert");
          if(alert.classList.contains("tryon")){
            alert.classList.remove("tryon");
            alert.classList.add("tryon-close");
          }
        }
      });

      detailBtn.onclick = function(){
        if(currentProductId){
          window.location.href = "detail.php?id=" + currentProductId;
        }
      };

      closeBtn.addEventListener('click', ()=>{
        modal.style.display = "none";
      });

      try_on.addEventListener('click', function(e){
        clearTimeout(timer);
        if(!isLogin){
          alert.classList.add("alert");
          alertName.textContent = "TRINITY";
          alertContent.textContent = "Please login first to use this feature!";
          closeAlert.style.opacity = "1";
          closeAlert.style.visibility = "visible";
          closeAlert.onclick = () =>{
            alert.classList.remove("alert");
          }
          alertOkBtn.onclick =  ()=>{
            window.location.href = "reglog.php";
          };
          alertCancelBtn.onclick = ()=>{
            alert.classList.remove("alert");
          };
          timer = setTimeout(function(){
              alert.classList.remove("alert");
            }, 5000);
        }else if(isLogin){
          clearTimeout(timer);
          timer = null;
            if(!alert.classList.contains("tryon-close") && !alert.classList.contains("tryon")){
              alertName.textContent = "TRINITY VIRTUAL AI TRY ON";
              alertContent.textContent = "";
              alertOkBtn.style.display = "none";
              formTryOn.style.display = "flex";
              closeAlert.style.opacity = "1";
              closeAlert.style.visibility = "visible";
              alertCancelBtn.textContent = "Stop";
              document.getElementById("fileChoose").style.display = "";
              document.getElementById("genBtn").style.display = "";
              agreeForm.style.display = "";
              if(alert.classList.contains("temp")){
                document.getElementById("progress-container").style.display = "flex";
                document.getElementById("fileChoose").style.display = "none";
                document.getElementById("genBtn").style.display = "none";
                agreeForm.style.display = "none";
              }
              alertCancelBtn.style.display = "";
              closeAlert.onclick = () =>{
                alert.classList.remove("alert");
              }
              alert.classList.add("alert");
              alertCancelBtn.onclick = ()=>{
                
              };
            }
        }
      });

      const closeAlert = document.getElementById("closeAlertBtn");

      closeAlert.addEventListener('click', ()=>{
        if(alert.classList.contains("tryon")){
          alert.classList.remove("tryon");
          alert.classList.add("tryon-close");
        }
      });

      alert.addEventListener('click', function(e){
        if(alert.classList.contains("tryon-close") && e.target != closeAlert){
            alert.classList.add("tryon");
            alert.classList.remove("tryon-close");
        }
      });
      

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
      const menu = document.getElementById("menu-toggle");
        menu.addEventListener('click', ()=>{
          document.getElementById("fast-menu").classList.toggle("open");
      });


      const form = document.querySelector("#tryon-form");

        form.addEventListener("submit", async function(e){
          e.preventDefault();
          document.getElementById("progress-container").style.display = "flex";
          document.getElementById("fileChoose").style.display = "none";
          document.getElementById("genBtn").style.display = "none";
          agreeForm.style.display = "none";
          document.getElementById("alertNotice").classList.remove("alert");
          document.getElementById("alertNotice").classList.add("tryon");
          const formData = new FormData(this);
          const res = await fetch("http://127.0.0.1:5000/api/generate",{
          method: "POST",
          body: formData
      });
      const data = await res.json();
      if(data.status === "success"){
        const goUser = confirm("Redirect to user page for result?");
      if(goUser){
        window.location.href = data.redirect;
      }
      }
      });
      
      const username = <?php echo json_encode($username); ?>;
      let abc = 0;
      let animationInterval = null;

      if(username){
        setInterval(async () =>{
          try{
            const res = await fetch(`http://localhost:5000/api/progress/${username}`);
            const data = await res.json();

            if(data.progress < 2){
              document.querySelector("#progress-container span").classList.add("animation");
            } 
            else if(data.progress > 2){
              let percent = data.progress + data.progress / 4.75; 
              document.getElementById("progress").style.width = `${percent}%`;
              if(alert.classList.contains("tryon-close")){
                alert.querySelector("h4").style.opacity = "1";
                alert.querySelector("h4").style.visibility = "visible";
                alert.querySelector("h4").textContent = `${parseFloat(percent.toFixed(2))}%`;
              }
            }
          }catch(err){
            console.error(err);
          }
        }, 10000);
      }




const container = document.getElementById("normal");

sortSelect.addEventListener("change", () => {
  let normalProducts = Array.from(container.querySelectorAll(".product-card"));
  let value = sortSelect.value;
  normalProducts.sort((a, b) => {
    let priceA = parseFloat(a.dataset.price || 0);
    let priceB = parseFloat(b.dataset.price || 0);
    let nameA = (a.dataset.name || "").toLowerCase();
    let nameB = (b.dataset.name || "").toLowerCase();
    switch(value){
      case "price_asc": return priceA - priceB;
      case "price_desc": return priceB - priceA;
      case "name_asc": return nameA.localeCompare(nameB);
      case "name_desc": return nameB.localeCompare(nameA);
      default: return 0;
    }
  });
  container.innerHTML = "";
  normalProducts.forEach(p => container.appendChild(p));
});
    </script>
  </body>
</html>
