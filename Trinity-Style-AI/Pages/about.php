<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>About Us</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;600;700&display=swap" rel="stylesheet" />
    <style>
      body {
        margin: 0; padding: 0;
        font-family: "Montserrat", sans-serif;
        overflow: hidden; 
      }
      .body {
        width: 100vw;
        height: 100vh;
        background: url(../Pictures/Banners/about.png) no-repeat center / cover;
        display: flex;
        flex-direction: column;
        justify-content: center; 
        padding-left: 10%; 
        box-sizing: border-box;
        transition: .4s;
      }
      .brand {
        position: absolute;
        top: 20px; left: 20px;
        font-weight: bold;
        font-size: 1.5rem;
        color: #000;
      }
      .title-container {
        position: relative;
        margin-bottom: 40px;
      }
      .title-container p {
        font-size: clamp(30px, 5vw, 60px); 
        font-weight: bold;
        color: rgb(40, 40, 133);
        text-transform: uppercase;
        margin: 0;
      }
      .line {
        width: 100px;
        height: 4px;
        background-color: rgb(40, 40, 133);
        margin-top: 10px;
        border-radius: 10px;
      }
      .description {
        font-size: 16px;
        line-height: 1.8;
        max-width: 450px;
        color: #555;
        text-align: justify;
        font-style: italic;
        margin-bottom: 30px;
      }
      .btn {
        text-transform: uppercase;
        width: 160px;
        height: 45px;
        color: white;
        background-color: rgb(40, 40, 133);
        border: none;
        border-radius: 25px;
        cursor: pointer;
        transition: 0.4s;
        font-weight: 700;
      }
      .btn:hover {
        background-color: #000;
        transform: scale(1.05);
      }

      @media (max-width: 1024px) {
        .body {
          background-position: 70% center; 
        }
        .description {
          max-width: 40%; 
        }
      }
      @media (max-width: 768px) {
        .body {
          padding-left: 5%;
          padding-right: 5%;
          align-items: center; 
          text-align: center;
          background-image: linear-gradient(rgba(255,255,255,0.7), rgba(255,255,255,0.7)), url(../Pictures/Banners/about.png); /* Làm mờ nhẹ ảnh nền để đọc chữ dễ hơn */
        }
        .description {
          max-width: 100%;
          font-size: 14px;
          text-align: center;
        }
        .line {
          margin: 10px auto; 
        }
      }
    </style>
  </head>
  <body>
    <div class="brand">Trinity</div>
    <div class="body">
      <div class="title-container">
        <p>About Us</p>
        <div class="line"></div>
      </div>
      <p class="description">
        Our collections are meticulously designed for the modern connoisseur,
        utilizing the finest fabrics and unparalleled craftsmanship sourced from
        around the globe. Each garment tells a story of prestige and excellence.
      </p>
      <button class="btn">Learn More</button>
    </div>
  </body>
</html>