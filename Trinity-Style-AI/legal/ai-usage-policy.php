<?php
$host = "localhost";
$user = "root";
$password = "";
$dbname = "TF_Database";

$conn = new mysqli($host, $user, $password, $dbname);

session_start();
$username = $_SESSION['username'] ?? null;


$sql = $conn->prepare("SELECT * FROM user_policy_agreement
                       WHERE username = ? AND policy_id = 'ai_usage'");
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
    <title>Trinity - AI Usage</title>
    <link rel="stylesheet" href="../Css/legal.css">
    <link rel="icon" type="image/png" href="../Pictures/Banners/logo.png">
</head>
<body>
    <img src="../Pictures/Banners/AI-usage.png" alt="" style="width: 100vw; 
                                                                         height: 100%; 
                                                                         position: fixed; 
                                                                         object-fit: cover; 
                                                                         top: 0; 
                                                                         object-position: center center;
                                                                         ">
    <div class="container">
        <div class="left-modal">
            <span onclick="window.location.href='#head'">Top</span>
            <div onclick="window.location.href='#intro'">1. Introduction</div>
            <div onclick="window.location.href='#scope'">2. Scope of AI Features</div>
            <div onclick="window.location.href='#response'">3. User Responsibilities</div>
            <div onclick="window.location.href='#prohibit'">4. Prohibited Uses</div>
            <div onclick="window.location.href='#limit'">5. Accuracy & Limitations</div>
            <div onclick="window.location.href='#data'">6. Data Usage & Privacy</div>
            <div onclick="window.location.href='#property'">7. Intellectual Property</div>
            <div onclick="window.location.href='#content'">8. Content Moderation</div>
            <div onclick="window.location.href='#change'">9. Changes to This Policy</div>
            <div onclick="window.location.href='#contact'">10. Contact</div>
        </div>
        <div class="right-modal" id="head">
            <h1>AI Usage Policy</h1>
            <span>Last updated: March 2026</span>
            <span>At Trinity, we value your privacy as much as your experience. This Privacy Policy explains how we<br>
                  collect, use, and protect your information when you use our platform.
            </span>

            <!--Collect-->
            <div class="subsection" id="intro">
                <h2>1. Introduction</h2>
                <span>This AI Usage Policy outlines how artificial intelligence (“AI”) features are used within our platform. 
                      By accessing or using any AI-powered functionality, you agree to comply with the terms described in this policy.
                </span>
                <span>Our AI tools are designed to enhance user experience, provide recommendations, and support creative and functional tasks.
                      However, responsible use is required at all times.
                </span>
            </div>

            <!--Use-->
            <div class="subsection" id="scope">
                <h2>2. Scope of AI Features</h2>
                <span>Our platform may use AI for:</span>
                <p>• Content generation (e.g., text, images, recommendations)</p>
                <p>• Personalization of user experience</p>
                <p>• Automated decision support (non-binding)</p>
                <p>• Data analysis and predictions</p>
                <h5>*AI-generated outputs are provided for informational and creative purposes only and may not always be accurate, complete, or appropriate.</h5>
            </div>

            <!--AI-->
            <div class="subsection" id="response">
                <h2>3. User Responsibilities</h2>
                <span>When using AI features, you agree that you will:</span>
                <p>• Use AI tools in a lawful and ethical manner</p>
                <p>• Not generate or distribute harmful, abusive, misleading, or illegal content</p>
                <p>• Not attempt to exploit, reverse-engineer, or manipulate AI systems</p>
                <p>• Take responsibility for reviewing and validating AI-generated outputs before use</p>
                <h5>*You are solely responsible for any content you create or share using AI tools.</h5>
            </div>

            <!--Share-->
            <div class="subsection" id="prohibit">
                <h2>4. Prohibited Uses</h2>
                <span>You may not use AI features to:</span>
                <p>• Generate illegal, harmful, or fraudulent content</p>
                <p>• Create content that infringes on intellectual property rights</p>
                <p>• Produce hate speech, harassment, or discriminatory material</p>
                <p>• Impersonate individuals or entities deceptively</p>
                <p>• Generate misinformation or deceptive content</p>
                <p>• Violate privacy or collect personal data without consent</p>
                <h5>*Violation of these rules may result in account suspension or termination.</h5>
            </div>

            <!--Data-->
            <div class="subsection" id="limit">
                <h2>5. Accuracy & Limitations</h2>
                <span>AI systems:</span>
                <p>• May produce incorrect or outdated information</p>
                <p>• Do not provide professional advice (legal, medical, financial, etc.)</p>
                <p>• Operate based on patterns in data, not true understanding</p>
                <h5>*Users should independently verify important information before relying on AI outputs.</h5>
            </div>

            <!--Account-->
            <div class="subsection" id="data">
                <h2>6. Data Usage & Privacy</h2>
                <span>We may process user inputs to:</span>
                <p>• Improve AI performance</p>
                <p>• Ensure safety and compliance</p>
                <p>• Personalize user experience</p>
                <h5>*We are committed to protecting your data. 
                     Please refer to our Privacy Policy for more details on how your information is collected and used.
                </h5>
            </div>

            <!--Right-->
            <div class="subsection" id="property">
                <h2>7. Intellectual Property</h2>
                <p>• AI-generated content may not be unique and could resemble existing materials</p>
                <p>• You are responsible for ensuring that your use of AI-generated content does not infringe on third-party rights</p>
                <p>• We do not guarantee ownership or exclusivity of AI-generated outputs</p>
            </div>

            <!--Security-->
            <div class="subsection" id="content">
                <h2>8. Content Moderation</h2>
                <span>We reserve the right to:</span>
                <p>• Monitor AI usage to ensure compliance</p>
                <p>• Filter, restrict, or remove harmful or inappropriate outputs</p>
                <p>• Limit or disable AI features for users who violate this policy</p>
            </div>

            <!--Change-->
            <div class="subsection" id="change">
                <h2>9. Changes to This Policy</h2>
                <span>We may update this AI Usage Policy at any time.<br> 
                      Continued use of AI features after changes indicates your acceptance of the updated terms.
                </span>
            </div>

            <!--Contact-->
            <div class="subsection" id="contact">
                <h2>10. Contact</h2>
                <span>
                    If you have any questions regarding this policy or AI usage on our platform, please contact us at:
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
        <input type="hidden" value="ai_usage" name="policy_id">
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