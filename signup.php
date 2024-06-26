<?php
// Start the session
session_start();

// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$database = "Kahuta_travells";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Prepare and execute the SQL query
    $sql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $username, $email, $password);

    if ($stmt->execute()) {
        // Redirect to the login page or show a success message
        header("Location: login.php");
        exit();
    } else {
        echo "<script>alert('$sql')</script>";
        echo "<script>alert('$conn->error')</script>";
    }

    $stmt->close();
}

$conn->close();
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sign Up</title>

  <style>
    body {
      background-image: url("images/background.jpg");
      background-size: cover;
      background-position: center;
      background-repeat: no-repeat;
      font-family: Arial, sans-serif;
      background-color: #f4f4f4;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
    }

    .signup-container {
      background-color: rgba(255, 255, 255, 0.4);
      padding: 40px;
      border-radius: 40px;
      box-shadow: 0 0 15px rgba(61, 60, 60, 0.1);
      width: 520px;
    }

    .signup-container h2 {
      margin-bottom: 30px;
      color: #000;
      text-align: center;
      font-size: 40px;
    }

    .signup-container label {
      display: block;
      margin-bottom: 10px;
      font-weight: bold;
      font-size: 20px;
    }

    .signup-container input {
      width: calc(100% - 20px);
            padding: 15px;
            margin-bottom: 20px;
            border: 1px solid rgba(0, 0, 0, 0.2); /* Light border for better visibility */
            border-radius: 5px;
            font-size: 18px;
            background-color: rgba(255, 255, 255, 0.4); /* Semi-transparent background */
            color: #333; /* Text color */
    }

    .signup-container button {
    width: 100%;
    padding: 18px;
    background-color: #000; /* Black background color */
    color: #fff; /* White text color */
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 20px;
}


.signup-container button:hover {
    background-color: #808080; /* Grey background color on hover */
}

    .signup-container .error {
      color: red;
      font-size: 16px;
      margin-bottom: 20px;
      text-align: center;
    }

    .signup-container .login-link {
      text-align: center;
      margin-top: 20px;
      font-size: 20px;
    }

    .signup-container .login-link a {
      color: #007bff;
      text-decoration: none;
    }

    .signup-container .login-link a:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>
  <div class="signup-container" >
    <h2>Create Account</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" id="signupForm">
      <div class="error" id="error"></div>

     
        
      <label for="username">Username</label>
      <input type="text" id="username" name="username" required>

      <label for="email">Email</label>
      <input type="email" id="email" name="email" required>

      <label for="password">Password</label>
      <input type="password" id="password" name="password" required>

      <label for="confirmPassword">Confirm Password</label>
      <input type="password" id="confirmPassword" name="confirmPassword" required>

      <button type="submit">Sign Up</button>
    </form>
    <div class="login-link">
      <p>Already have an account? <a href="login.php">Log in here</a></p>
    </div>
  </div>
</body>


</html>