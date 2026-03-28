<?php
$host = "localhost";
$user = "root";
$password = "";
$dbname = "TF_Database";

$conn = new mysqli($host, $user, $password, $dbname);

session_start();
$username = $_SESSION['username'] ?? null;


$sql = $conn->prepare("SELECT * FROM user_policy_agreement
                       WHERE username = ? AND policy_id = 'privacy'");
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
    <title>Trinity - Privacy Policy</title>
    <link rel="stylesheet" href="../Css/legal.css">
    <link rel="icon" type="image/png" href="../Pictures/Banners/logo.png">
</head>
<body>
    <img src="../Pictures/Banners/privacy-policy.png" alt="" style="width: 100vw; 
                                                                         height: 100%; 
                                                                         position: fixed; 
                                                                         object-fit: cover; 
                                                                         top: 0; 
                                                                         object-position: center center;
                                                                         ">
    <div class="container">
        <div class="left-modal">
            <span onclick="window.location.href='#head'">Top</span>
            <div onclick="window.location.href='#collect'">1. Information We Collect</div>
            <div onclick="window.location.href='#use'">2. How We Use Your Information</div>
            <div onclick="window.location.href='#ai'">3. AI Data Processing</div>
            <div onclick="window.location.href='#share'">4. Data Sharing</div>
            <div onclick="window.location.href='#data'">5. Data Retention</div>
            <div onclick="window.location.href='#account'">6. Account Deletion & Soft Delete</div>
            <div onclick="window.location.href='#right'">7. Your Rights</div>
            <div onclick="window.location.href='#security'">8. Data Security</div>
            <div onclick="window.location.href='#change'">9. Changes To This Policy</div>
            <div onclick="window.location.href='#contact'">10. Contact</div>
        </div>
        <div class="right-modal" id="head">
            <h1>PRIVACY POLICY</h1>
            <span>Last updated: March 2026</span>
            <span>At Trinity, we value your privacy as much as your experience. This Privacy Policy explains how we<br>
                  collect, use, and protect your information when you use our platform.
            </span>

            <!--Collect-->
            <div class="subsection" id="collect">
                <h2>1. Information We Collect</h2>
                <span>We may collect the following types of information:</span>
                <h4>Personal Information</h4>
                <p>• Name, email address, phone number</p>
                <p>• Account credentials</p>
                <h4>Usage Data</h4>
                <p>• Pages visited, interactions, and preferences</p>
                <p>• Device and browser information</p>
                <h4>Uploaded Content</h4>
                <p>• Images uploaded for AI-powered features (e.g., virtual try-on)</p>
            </div>

            <!--Use-->
            <div class="subsection" id="use">
                <h2>2. How We Use Your Information</h2>
                <span>We use your information to:</span>
                <p>• Provide and improve our services</p>
                <p>• Process orders and manage accounts</p>
                <p>• Enhance AI features and user experience</p>
                <p>• Communicate important updates</p>
                <h5>*We do not sell your personal data to third parties.</h5>
            </div>

            <!--AI-->
            <div class="subsection" id="ai">
                <h2>3. AI Data Processing</h2>
                <span>Images uploaded for AI features may be:</span>
                <p>• Processed to generate results</p>
                <p>• Temporarily stored for system improvement</p>
                <h5>*We take reasonable measures to ensure your data is handled securely.</h5>
            </div>

            <!--Share-->
            <div class="subsection" id="share">
                <h2>4. Data Sharing</h2>
                <span>We may share limited data with:</span>
                <p>• Payment providers (for transactions)</p>
                <p>• Delivery partners (for order fulfillment)</p>
                <h5>*All third parties are required to protect your data.</h5>
            </div>

            <!--Data-->
            <div class="subsection" id="data">
                <h2>5. Data Retention</h2>
                <span>We retain your data only as long as necessary to:</span>
                <p>• Maintain your account</p>
                <p>• Comply with legal obligations</p>
                <p>• Improve our services</p>
            </div>

            <!--Account-->
            <div class="subsection" id="account">
                <h2>6. Account Deletion & Soft Delete</h2>
                <span>You have the right to request account deletion at any time.</span>
                <h4>Soft Delete Policy</h4>
                <p>• When you delete your account, your data is not immediately removed from our system</p>
                <p>• Your account will be marked as “inactive” (soft deleted)</p>
                <p>• Personal identifiers (e.g., name, email) may be anonymized</p>
                <h4>Retention Period</h4>
                <span>Your data may be retained for a limited period (e.g., 30 days) for:</span>
                <p>• Recovery requests</p>
                <p>• Fraud prevention</p>
                <p>• Legal compliance</p>
                <h5>*After this period, your data may be permanently deleted.</h5>
            </div>

            <!--Right-->
            <div class="subsection" id="right">
                <h2>7. Your Rights</h2>
                <span>You have the right to:</span>
                <p>• Access your personal data</p>
                <p>• Request correction or deletion</p>
                <p>• Withdraw consent for data usage</p>
            </div>

            <!--Security-->
            <div class="subsection" id="security">
                <h2>8. Data Security</h2>
                <span>We implement appropriate security measures to protect your data.<br>
                      However, no system is completely secure.
                </span>
            </div>

            <!--Change-->
            <div class="subsection" id="change">
                <h2>9. Changes to This Policy</h2>
                <span>We may update this Privacy Policy from time to time.<br>
                      Continued use of Trinity means you accept these changes.
                </span>
            </div>

            <!--Contact-->
            <div class="subsection" id="contact">
                <h2>10. Contact</h2>
                <span>
                    If you have any questions about this Privacy Policy, please contact us at:
                    triple3tbusiness@gmail.com
                </span>
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
        <a href="term-of-service.php">Terms of Service</a>
        <a href="#head">Privacy Policy</a>
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
        <input type="hidden" value="privacy" name="policy_id">
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