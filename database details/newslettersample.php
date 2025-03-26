<!-- HTML -->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Newsletter Subscription</title>
  <style>
    /* CSS */
    body {
      font-family: Arial, sans-serif;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
      background-color: #f3f4f6;
    }
    
    .subscription-container {
      display: flex;
      align-items: center;
      justify-content: center;
      text-align: center;
      flex-direction: column;
      background: #ffffff;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }
    
    h1 {
      color: #333333;
    }
    
    input {
      width: 80%;
      padding: 10px;
      margin: 10px 0;
      border: 1px solid #ccc;
      border-radius: 5px;
    }
    
    button {
      padding: 10px 20px;
      background-color: #007bff;
      color: #ffffff;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }
    
    button:hover {
      background-color: #0056b3;
    }
    
    #message {
      margin-top: 10px;
    }
  </style>
</head>
<body>
  <div class="subscription-container">
    <h1>Subscribe to Our Newsletter</h1>
    <form id="subscription-form">
      <input type="text" id="name" placeholder="Enter your name" required>
      <input type="email" id="email" placeholder="Enter your email" required>
      <input type="tel" id="phone" placeholder="Enter your phone number" required><br>
      <button type="submit">Subscribe</button>
    </form>
    <p id="message"></p>
  </div>
  <script>
    // JavaScript
    document.getElementById('subscription-form').addEventListener('submit', function(event) {
      event.preventDefault(); // Prevent page reload
      const nameInput = document.getElementById('name');
      const emailInput = document.getElementById('email');
      const phoneInput = document.getElementById('phone');
      const message = document.getElementById('message');
      
      if (validateForm(nameInput.value, emailInput.value, phoneInput.value)) {
        message.textContent = "Thank you for subscribing, " + nameInput.value + "!";
        message.style.color = "green";
        nameInput.value = "";
        emailInput.value = "";
        phoneInput.value = ""; // Clear inputs
      } else {
        message.textContent = "Please fill out all fields correctly.";
        message.style.color = "red";
      }
    });
    
    // Form validation function
    function validateForm(name, email, phone) {
      const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      const phoneRegex = /^\d{10}$/; // Basic phone number validation (10 digits)
      
      return name.trim() !== "" && emailRegex.test(email) && phoneRegex.test(phone);
    }
    document.getElementById('subscription-form').addEventListener('submit', function(event) {
  event.preventDefault(); // Prevent page reload

  // Collect form data
  const name = document.getElementById('name').value;
  const email = document.getElementById('email').value;
  const phone = document.getElementById('phone').value;

  // Send data to backend
  fetch('subscribe.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
    body: `name=${encodeURIComponent(name)}&email=${encodeURIComponent(email)}&phone=${encodeURIComponent(phone)}`
  })
  .then(response => response.text())
  .then(data => {
    console.log(data); // Display backend response
    document.getElementById('message').textContent = data;
  })
  .catch(error => {
    console.error('Error:', error);
  });
});

  </script>
  <?php
  // Database connection
  $host = 'localhost'; // Update with your host
  $dbname = 'your_database'; // Update with your database name
  $username = 'your_username'; // Update with your database username
  $password = 'your_password'; // Update with your database password
  
  try {
      $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  } catch (PDOException $e) {
      die("Database connection failed: " . $e->getMessage());
  }
  
  // Check if the request is POST
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
      $name = htmlspecialchars($_POST['name']);
      $email = htmlspecialchars($_POST['email']);
      $phone = htmlspecialchars($_POST['phone']);
  
      // Validate email
      if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
          echo "Invalid email format.";
          exit;
      }
  
      try {
          // Insert subscriber into database
          $stmt = $conn->prepare("INSERT INTO subscribers (name, email, phone) VALUES (:name, :email, :phone)");
          $stmt->bindParam(':name', $name);
          $stmt->bindParam(':email', $email);
          $stmt->bindParam(':phone', $phone);
          $stmt->execute();
  
          // Email details
          $to = $email;
          $subject = "Welcome to Our Newsletter!";
          $message = "Hi $name,\n\nThank you for subscribing to our newsletter!\nAs a special welcome, enjoy a 20% discount on your next purchase.\n\nUse code: WELCOME20\n\nBest Regards,\nTeam";
          $headers = "From: no-reply@example.com";
  
          // Send the email
          if (mail($to, $subject, $message, $headers)) {
              echo "Thank you for subscribing! A confirmation email with an offer has been sent to $email.";
          } else {
              echo "Subscription successful, but failed to send email.";
          }
      } catch (PDOException $e) {
          if ($e->getCode() == 23000) { // Duplicate entry error
              echo "You are already subscribed.";
          } else {
              echo "Error: " . $e->getMessage();
          }
      }
  } else {
      echo "Invalid request.";
  }
  ?>
  
</body>
</html>
