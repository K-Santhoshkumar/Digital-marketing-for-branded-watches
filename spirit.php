<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>SPIRIT</title>
    <script src="https://cdn.jsdelivr.net/npm/@supabase/supabase-js"></script>
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
    />
    <script defer src="logout.js"></script>
    <link rel="stylesheet" href="common.css" />
    <style>
      /* General Styles */
      body {
        font-family: Montserrat, sans-serif;
        margin: 0;
        padding: 0;
        background-color: #f8f9fa;
      }

      /* Main Container */
      .container {
        display: flex;
        gap: 20px;
        flex-wrap: wrap;
        justify-content: center;
        margin-top: 20px;
      }

      /* Product Card */
      .product {
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        width: 300px;
        position: relative;
        transition: transform 0.2s ease-in-out;
      }

      .product:hover {
        transform: scale(1.02);
      }

      .product-card {
        padding: 15px;
        text-align: center;
      }

      .name {
        font-size: 1.2em;
        margin-bottom: 5px;
      }

      .popup-btn {
        display: inline-block;
        padding: 8px 15px;
        background-color: #3498db;
        color: white;
        text-decoration: none;
        border-radius: 5px;
        font-size: 0.9em;
        cursor: pointer;
        border: none;
        transition: background 0.3s;
      }

      .popup-btn:hover {
        background-color: #217dbb;
      }

      /* Product Image */
      .product-img-container {
        height: 250px;
        display: flex;
        justify-content: center;
        align-items: center;
        overflow: hidden;
        margin-bottom: 10px;
      }

      .product-img {
        max-width: 100%;
        max-height: 100%;
        display: block;
      }

      /* ========== Popup Styling ========== */
      .popup-view {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.7);
        display: none;
        justify-content: center;
        align-items: center;
        z-index: 1000; /* Ensures popup is above everything */
      }

      /* Popup Content */
      .popup-card {
        background: white;
        width: 90%;
        max-width: 500px;
        padding: 20px;
        border-radius: 10px;
        position: relative;
        max-height: 90vh; /* Ensures it does not overflow */
        overflow-y: auto; /* Enables scrolling */
        z-index: 1001;
      }

      /* Close Button */
      .close-btn {
        position: absolute;
        top: 10px;
        right: 15px;
        font-size: 22px;
        background: none;
        border: none;
        cursor: pointer;
        color: #333;
        transition: color 0.3s;
      }

      .close-btn:hover {
        color: red;
      }

      /* Disable background scrolling when popup is open */
      body.popup-open {
        overflow: hidden;
      }

      /* Product Image in Popup */
      .product-img-container {
        width: 100%;
        max-height: 300px;
        display: flex;
        justify-content: center;
        align-items: center;
        overflow: hidden;
      }

      .popup-card img {
        width: 100%; /* Ensures it stretches fully */
        height: auto; /* Maintains aspect ratio */
        object-fit: contain; /* Fits image without cropping */
        border-radius: 5px;
      }

      /* Product Details */
      .info {
        margin-top: 15px;
        text-align: center;
        padding: auto;
        font-size: x-large;
      }

      .info h2 {
        margin: 10px 4px;
      }

      /* Buttons Inside Popup */
      .btns {
        margin-top: 0.4rem;
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
        gap: 10px;
      }

      .add-cart-btn,
      .add-wish {
        display: block;
        text-align: center;
        font-size: 1.2rem;
        padding: 10px;
        color: white;
        text-decoration: none;
        border-radius: 5px;
        width: 100%;
        transition: 0.3s;
      }

      .add-cart-btn {
        background: linear-gradient(45deg, #ff6a00, #ee0979);
      }

      .add-cart-btn:hover {
        background: linear-gradient(45deg, #ee0979, #ff6a00);
      }

      .add-wish {
        background: linear-gradient(45deg, #ee0979, #ff6a00);
      }

      .add-wish:hover {
        background: linear-gradient(45deg, #ff6a00, #ee0979);
      }

      /* Responsive Fixes */
      @media screen and (max-width: 600px) {
        .popup-card {
          width: 95%;
          max-height: 85vh;
        }
      }
    </style>
  </head>
  <body>
    <header>
      <div class="top-nav">
        <div class="left-nav">
          <a href="india.html">INDIA</a>
          <a href="customer.html">CUSTOMER CARE</a>
        </div>
        <div class="center-logo">
          <img src="./uploads/home/logo.jpg" alt="PARA" class="logo" />
          <br /><br />
          <span class="logo-text">LONGINES</span>
        </div>
        <div class="right-nav">
          <a href="user.html">USER INFO</a>
          <button id="logout-btn">LOGOUT</button>
        </div>
      </div>
      <nav class="bottom-nav">
        <ul>
          <li><a href="master.php">MASTER</a></li>
          <li><a href="conquest.php">CONQUEST</a></li>
          <li><a href="spirit.php">SPIRIT</a></li>
          <li><a href="elegance.php">ELEGANCE</a></li>
          <li><a href="heritage.php">HERITAGE</a></li>
        </ul>
      </nav>
      <p class="model-text">SPIRIT</p>
    </header>

    <?php
$dsn = "pgsql:host=db.eppxrgnnkrrlzoihgvhq.supabase.co;port=5432;dbname=postgres";
$username = "postgres";
$password = "Ksanthosh25";

try {
    $pdo = new PDO($dsn, $username, $password, [PDO::ATTR_ERRMODE =>
    PDO::ERRMODE_EXCEPTION]); $query = "SELECT id, model_name, image_url,
    gender_type, description, price, available_stocks, material_type FROM
    spirit_watches"; $stmt = $pdo->query($query); $watches =
    $stmt->fetchAll(PDO::FETCH_ASSOC); } catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage()); } ?>

    <main>
      <div class="container">
        <?php foreach ($watches as $index =>
        $watch): ?>
        <div class="product">
          <div class="product-card">
            <div class="product-img-container">
              <img
                src="<?= htmlspecialchars($watch['image_url']) ?>"
                class="product-img"
                alt="<?= htmlspecialchars($watch['model_name']) ?>"
              />
            </div>
            <h2 class="name"><?= htmlspecialchars($watch['model_name']) ?></h2>
            <button class="popup-btn" data-popup="<?= $index ?>">
              Quick View
            </button>
          </div>
        </div>

        <div class="popup-view" id="popup-<?= $index ?>">
          <div class="popup-card">
            <button class="close-btn" onclick="closePopup(<?= $index ?>)">
              <i class="fas fa-times"></i>
            </button>
            <div class="product-img-container">
              <img
                src="<?= htmlspecialchars($watch['image_url']) ?>"
                alt="<?= htmlspecialchars($watch['model_name']) ?>"
              />
            </div>
            <div class="info">
              <h2>
                <?= htmlspecialchars($watch['model_name']) ?>
                <br />
                <span
                  ><?= htmlspecialchars($watch['gender_type']) ?>
                  Watch</span
                >
              </h2>
              <p>
                Description:
                <?= htmlspecialchars($watch['description']) ?>
              </p>
              <span
                >ID:
                <?= htmlspecialchars($watch['id']) ?></span
              ><br />
              <span
                >Stock:
                <?= htmlspecialchars($watch['available_stocks']) ?>
                available</span
              ><br />
              <span>Price: Rs.<?= htmlspecialchars($watch['price']) ?></span
              ><br />
              <span
                >Type:
                <?= htmlspecialchars($watch['material_type']) ?></span
              ><br />
              <div class="btns">
                <a href="#" class="add-cart-btn">Add to cart</a>
                <a href="#" class="add-wish">Add to Wishlist</a>
              </div>
            </div>
          </div>
        </div>
        <?php endforeach; ?>
      </div>
    </main>

    <script>
      document.querySelectorAll(".popup-btn").forEach((button) => {
        button.addEventListener("click", function () {
          const popupId = this.getAttribute("data-popup");
          document.getElementById("popup-" + popupId).style.display = "flex";
          document.body.classList.add("popup-open"); // Disable page scrolling
        });
      });

      function closePopup(index) {
        document.getElementById("popup-" + index).style.display = "none";
        document.body.classList.remove("popup-open"); // Enable page scrolling
      }
    </script>
  </body>
</html>
