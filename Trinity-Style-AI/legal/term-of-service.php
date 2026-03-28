<?php
$host = "localhost";
$user = "root";
$password = "";
$dbname = "TF_Database";

$conn = new mysqli($host, $user, $password, $dbname);

session_start();
$username = $_SESSION['username'] ?? null;


$sql = $conn->prepare("SELECT * FROM user_policy_agreement
                       WHERE username = ? AND policy_id = 'terms'");
$sql->bind_param("s", $username);
$sql->execute();
$agreement = $sql->get_result();
$agree = $agreement->fetch_assoc();
$sql->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trinity - Term of Service</title>
    <link rel="stylesheet" href="../Css/legal.css">
    <link rel="icon" type="image/png" href="../Pictures/Banners/logo.png">
</head>
<body>
    <div class="container">
        <div class="left-modal">
            <span onclick="window.location.href='#head'">Top</span>
            <div onclick="window.location.href='#overview'">1. Overview</div>
            <div onclick="window.location.href='#eligibility'">2. Eligibility</div>
            <div onclick="window.location.href='#response'">3. User response</div>
            <div onclick="window.location.href='#order'">4. Orders</div>
            <div onclick="window.location.href='#ai'">5. AI Features</div>
            <div onclick="window.location.href='#property'">6. Intellectual Property</div>
            <div onclick="window.location.href='#limit'">7. Limitation of Liability</div>
            <div onclick="window.location.href='#policies'">8. Related Policies</div>
            <div onclick="window.location.href='#change'">9. Changes</div>
            <div onclick="window.location.href='#contact'">10. Contact</div>
        </div>
        <div class="right-modal" id="head">
            <h1>TERMS OF SERVICE</h1>
            <span>Last updated: March 2026</span>
            <span>Welcome to Trinity — where technology meets fashion.<br>
                  By accessing or using our platform, you agree to be bound by these Terms.
            </span>
            <div class="subsection" id="overview">
                <h2>1. Overview</h2>
                <span>Trinity provides a digital fashion experience, including product browsing, purchasing, and AI-powered virtual try-on services.
                      We reserve the right to refine or discontinue any part of the service at our discretion.
                </span>
            </div>
            <div class="subsection" id="eligibility">
                <h2>2. Eligibility</h2>
                <span>You must be legally capable of entering binding agreements to use our services.</span>
            </div>
            <div class="subsection" id="response">
                <h2>3. User Responsibility</h2>
                <span>You agree to:</span>
                <p>Provide accurate account information</p>
                <p>Maintain the confidentiality of your credentials</p>
                <p>Use the platform in a lawful and respectful manner</p>
            </div>
            <div class="subsection" id="order">
                <h2>4. Orders</h2>
                <span>All orders are subject to acceptance and availability.<br>
                      We may cancel or refuse any order at our sole discretion.
                </span>
            </div>
            <div class="subsection" id="ai">
                <h2>5. AI Features</h2>
                <span>Our platform may include AI-generated outputs for visual experiences.</span>
                <span>By using these features, you acknowledge:</span>
                <p>Outputs are for reference only</p>
                <p>Results may not be perfectly accurate</p>
                <p>You are responsible for content you upload</p>
            </div>
            <div class="subsection" id="property">
                <h2>6. Intellectual Property</h2>
                <span>All content, visuals, and technology on Trinity are owned or licensed by us.<br>
                      Unauthorized use is strictly prohibited.
                </span>
            </div>
            <div class="subsection" id="limit">
                <h2>7. Limitation of Liability</h2>
                <span>Trinity is provided “as is” without warranties of any kind.<br>
                      We are not liable for indirect or consequential damages.
                </span>
            </div>
            <div class="subsection" id="policies">
                <h2>8. Related Policies</h2>
                <span>Your use of Trinity is also governed by our:</span>
                <p>Privacy Policy</p>
                <p>AI Usage Policy</p>
                <p>Delivery Policy</p>
            </div>
            <div class="subsection" id="change">
                <h2>9. Changes</h2>
                <span>We may update these Terms at any time. Continued use constitutes acceptance.</span>
            </div>
            <div class="subsection" id="contact">
                <h2>10. Contact</h2>
                <span>triple3tbusiness@gmail.com</span>
            </div>
        </div>
    </div>
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
        <a href="../Pages/products.php">Products</a>
        <a href="../Pages/cart.php">Cart</a>
        <a href="../Pages/voucher.php">Vouchers</a>
        <a href="../Pages/userTier.php">User Tier</a>
        <a href="#">About Us</a>
      </div>
      <div class="footer-col">
        <p class="footer-col-title">INFORMATION</p>
        <a href="#head">Terms of Service</a>
        <a href="privacy-policy.php">Privacy Policy</a>
        <a href="delivery-policy.php">Delivery Policy</a>
        <a href="ai-usage-policy.php">AI Usage Policy</a>
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
<?php if(!empty($agree)): ?>
<?php else: ?>
    <div class="modal-accept">
        <span>By continuing, you agree to our AI Usage Policy and Terms of Service.</span>
        <button class="btn" id="accept">Accept</button>
        <button class="btn decline" id="decline">Decline</button>
    </div>
    <form action="../Database/user_policy_agree.php" method="POST" id="form">
        <input type="hidden" value="terms" name="policy_id">
    </form>
<?php endif; ?>
</body>
<script>
    let timer = setTimeout(() => {
        document.querySelector(".modal-accept").classList.add("show");
    }, 5000);
    document.getElementById("decline").addEventListener('click', ()=>{
        clearTimeout(timer);
        document.querySelector(".modal-accept").classList.remove("show");
    });

    document.getElementById("accept").addEventListener('click', ()=>{
        clearTimeout(timer);
        document.getElementById("form").submit();
    });
</script>
</html>