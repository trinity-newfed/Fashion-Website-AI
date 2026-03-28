<?php
$host = "localhost";
$user = "root";
$password = "";
$dbname = "TF_Database";

$conn = new mysqli($host, $user, $password, $dbname);

session_start();
$username = $_SESSION['username'] ?? null;


$sql = $conn->prepare("SELECT * FROM user_policy_agreement
                       WHERE username = ? AND policy_id = 'delivery'");
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
    <title>Trinity - Delivery Policy</title>
    <link rel="stylesheet" href="../Css/legal.css">
    <link rel="icon" type="image/png" href="../Pictures/Banners/logo.png">
</head>
<body>
        <img src="../Pictures/Banners/delivery-policy.jpeg" alt="" style="width: 100vw; 
                                                                         height: 100%; 
                                                                         position: fixed; 
                                                                         object-fit: cover; 
                                                                         top: 0; 
                                                                         object-position: center center;
                                                                         ">
    <div class="container">
        <div class="left-modal">
            <span onclick="window.location.href='#head'">Top</span>
            <div onclick="window.location.href='#processing'">1. Order Processing</div>
            <div onclick="window.location.href='#method'">2. Shipping Methods</div>
            <div onclick="window.location.href='#time'">3. Estimated Delivery Time</div>
            <div onclick="window.location.href='#fee'">4. Shipping Fees</div>
            <div onclick="window.location.href='#track'">5. Order Tracking</div>
            <div onclick="window.location.href='#issue'">6. Delivery Issues</div>
            <div onclick="window.location.href='#fail'">7. Failed Deliveries</div>
            <div onclick="window.location.href='#risk'">8. Risk of Loss</div>
            <div onclick="window.location.href='#internation'">9. International Shipping</div>
            <div onclick="window.location.href='#change'">10. Changes To This Policy</div>
            <div onclick="window.location.href='#contact'">11. Contact</div>
        </div>
        <div class="right-modal" id="head">
            <h1>DELIVERY POLICY</h1>
            <span>Last updated: March 2026</span>
            <span>At Trinity, we are committed to delivering your orders with reliability and care.</span>

            <!--Processing-->
            <div class="subsection" id="processing">
                <h2>1. Order Processing</h2>
                <span>All orders are processed within 1–3 business days after confirmation.<br>
                      Orders are not processed on weekends or public holidays.
                </span>
                <h5>*Once your order is confirmed, you will receive a notification with delivery details.</h5>
            </div>

            <!--Method-->
            <div class="subsection" id="method">
                <h2>2. Shipping Methods</h2>
                <span>We work with trusted third-party delivery partners to ensure your order arrives safely.<br>
                      Available shipping options may vary depending on your location and will be displayed at checkout.
                </span>
            </div>

            <!--Time-->
            <div class="subsection" id="time">
                <h2>3. Estimated Delivery Time</h2>
                <span>Delivery times are estimates and may vary:</span>
                <p>• <b>Standard Delivery:</b> 3–7 business days</p>
                <p>• <b>Express Delivery:</b> 1-3 business days</p>
                <h5>*Delays may occur due to external factors such as weather, logistics issues, or high demand periods.</h5>
            </div>

            <!--Fee-->
            <div class="subsection" id="fee">
                <h2>4. Shipping Fees</h2>
                <span>Shipping fees are calculated at checkout based on:</span>
                <p>• Delivery location</p>
                <p>• Selected shipping method</p>
                <h5>*Promotional offers such as free shipping may apply during special campaigns.</h5>
            </div>

            <!--Track-->
            <div class="subsection" id="track">
                <h2>5. Order Tracking</h2>
                <span>Once your order has been shipped, you will receive a tracking number.<br>
                      You can use this information to monitor the delivery status in real time.
                </span>
            </div>

            <!--Issue-->
            <div class="subsection" id="issue">
                <h2>6. Delivery Issues</h2>
                <span>If you experience any issues with your delivery, please contact us promptly.</span>
                <h4>Common issues include:</h4>
                <p>• Delayed delivery</p>
                <p>• Incorrect address</p>
                <p>• Failed delivery attempts</p>
                <h5>*We will make reasonable efforts to assist and resolve the issue.</h5>
            </div>

            <!--Failed-->
            <div class="subsection" id="fail">
                <h2>7. Failed Deliveries</h2>
                <h4>If a delivery attempt fails due to:</h4>
                <p>• Incorrect or incomplete address</p>
                <p>• Recipient unavailable</p>
                <h4>The order may be:</h4>
                <p>• Re-attempted by the carrier</p>
                <p>• Returned to us</p>
                <h5>*Additional shipping fees may apply for re-delivery.</h5>
            </div>

            <!--Risk-->
            <div class="subsection" id="risk">
                <h2>8. Risk of Loss</h2>
                <span>Once an order has been successfully delivered, the risk of loss or damage transfers to you.</span>
            </div>

            <!--Internation-->
            <div class="subsection" id="internation">
                <h2>9. International Shipping</h2>
                <span>For international orders:</span>
                <p>• Delivery times may vary significantly</p>
                <p>• Additional customs duties or taxes may apply</p>
                <h5>*These fees are the responsibility of the customer.</h5>
            </div>

            <!--Change-->
            <div class="subsection" id="change">
                <h2>10. Changes to This Policy</h2>
                <span>
                    We may update this Delivery Policy at any time.<br>
                    Continued use of Trinity means you accept these changes.
                </span>
            </div>
            <div class="subsection" id="contact">
                <h2>11. Contact</h2>
                <span>
                    For any delivery-related inquiries, please contact:<br>
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
        <a href="privacy-policy.php">Privacy Policy</a>
        <a href="#head">Delivery Policy</a>
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
        <input type="hidden" value="delivery" name="policy_id">
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