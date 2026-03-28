<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Limited Collection</title>
    <link
      href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;700&family=Montserrat:wght@300;400;600&display=swap"
      rel="stylesheet"
    />
    <style>
     /* .banner {
        position: relative;
        display: flex;
        width: 100%;
        height: 600px;
        background-color: powderblue;
      } */
      body {
        background-color: #0f0f0f;
        margin: 0;
        padding: 0;
        font-family: "Montserrat", sans-serif;
      }

      .product-section {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        padding: 50px 20px;
        max-width: 1200px;
        margin: 0 auto;
      }

      .product-card {
        background-color: #1a1a1a;
        width: 350px;
        position: relative;
        transition: all 0.5s ease;
        cursor: pointer;
      }

      .product-card:hover {
        border-color: #c5a059;
        transform: translateY(-10px);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.5);
      }

      .image-box {
        width: 100%;
        height: 380px;
        overflow: hidden;
        position: relative;
      }

      .image-box img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: all 0.5s ease;
      }

      .product-card:hover .image-box img {
        transform: scale(1.05);
      }

      .badge {
        position: absolute;
        top: 20px;
        left: 20px;
        color: #c5a059;
        font-size: 10px;
        letter-spacing: 2px;
        text-transform: uppercase;
        font-weight: 600;
        border-bottom: 1px solid #c5a059;
        padding-bottom: 5px;
        z-index: 10;
      }

      .content {
        padding: 30px;
        text-align: center;
      }

      .brand {
        color: #888888;
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 3px;
        margin-bottom: 10px;
        display: block;
      }

      .title {
        color: #ffffff;
        font-family: "Cinzel", serif;
        font-size: 22px;
        margin-bottom: 15px;
        font-weight: 400;
      }

      .buy-btn {
        background: transparent;
        border: 1px solid #c5a059;
        color: #c5a059;
        padding: 12px 35px;
        text-transform: uppercase;
        font-size: 11px;
        font-weight: 600;
        letter-spacing: 1px;
        cursor: pointer;
        transition: all 0.4s ease;
      }

      .buy-btn:hover {
        background-color: #c5a059;
        color: #000000;
      }

      .product-card::after {
        content: "";
        position: absolute;
        top: 10px;
        right: 10px;
        bottom: 10px;
        left: 10px;
        pointer-events: none;
      }
      @media (max-width: 1024px)
      {
        .product-section {
          flex-direction: row;
          gap: 10px;
        }
      }
    </style>
  </head>
  <body>
    <div class="banner"><!-- Kiếm hộ t cái banner --></div>
    <div class="body">
      <section class="product-section">
        <div class="product-card">
          <div class="image-box">
            <span class="badge">Limited Edition</span>
            <div class="img"></div>
          </div>

          <div class="content">
            <span class="brand">Trinity</span>
            <h2 class="title">Luong Minh Tri</h2>
            <button class="buy-btn">Khám phá ngay</button>
          </div>
        </div>

        <div class="product-card">
          <div class="image-box">
            <span class="badge">New Arrival</span>
            <div class="img"></div>
          </div>

          <div class="content">
            <span class="brand">Trinity</span>
            <h2 class="title">Ly Ngoc Duy Tan</h2>
            <button class="buy-btn">Khám phá ngay</button>
          </div>
        </div>

        <div class="product-card">
          <div class="image-box">
            <span class="badge">Exclusive</span>
            <div class="img"></div>
          </div>

          <div class="content">
            <span class="brand">Trinity</span>
            <h2 class="title">Bui Quoc Trung</h2>
            <button class="buy-btn">Khám phá ngay</button>
          </div>
        </div>
      </section>
    </div>
  </body>
</html>
