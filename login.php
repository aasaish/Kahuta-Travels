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

// Initialize error message variable
$errorMsg = '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Prepare and execute the SQL query
    $sql = "SELECT * FROM Users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            // Log the user in and create a session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            header("Location: reservation.html");
            exit();
        } else {
            $errorMsg = "Invalid email or password.";
        }
    } else {
        $errorMsg = "Invalid email or password.";
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
    <title>Login</title>

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

        .login-container {
            background-color: rgba(255, 255, 255, 0.4);
            padding: 40px;
            border-radius: 40px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            width: 520px;
        }

        .login-container h2 {
            margin-bottom: 30px;
            color: #000;
            text-align: center;
            font-size: 40px;
        }

        .login-container label {
            display: block;
            margin-bottom: 10px;
            font-weight: bold;
            font-size: 20px;
        }

        .login-container input {
            width: calc(100% - 20px);
            padding: 15px;
            margin-bottom: 20px;
            border: 1px solid rgba(0, 0, 0, 0.2); /* Light border for better visibility */
            border-radius: 5px;
            font-size: 18px;
            background-color: rgba(255, 255, 255, 0.4); /* Semi-transparent background */
            color: #333; /* Text color */
        }

        .login-container button {
    width: 100%;
    padding: 18px;
    background-color: #000; /* Black background color */
    color: #fff; /* White text color */
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 20px;
}


.login-container button:hover {
    background-color: #808080; /* Grey background color on hover */
}

        .login-container .error {
            color: red;
            font-size: 16px;
            margin-bottom: 20px;
            text-align: center;
        }

        .login-container .signup-link {
            text-align: center;
            margin-top: 20px;
            font-size: 20px;
        }

        .login-container .signup-link a {
            color: #007bff;
            text-decoration: none;
        }

        .login-container .signup-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="login-container">
        <h2>Login</h2>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" id="loginForm">
            <?php if (!empty($errorMsg)) : ?>
                <div class="error"><?php echo $errorMsg; ?></div>
            <?php endif; ?>
            <label for="email">Email</label>
            <input type="email" id="email" name="email" required>

            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>

            <button type="submit">Log In</button>
        </form>
        <div class="signup-link">
            <p>Don't have an account? <a href="signup.php">Sign up</a></p>
        </div>
    </div>
</body>

</html>
