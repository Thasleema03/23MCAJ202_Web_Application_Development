<?php
$name = $email = "";
$nameErr = $emailErr = $passwordErr = $confirmPasswordErr = "";
$successMessage = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = isset($_POST["name"]) ? trim($_POST["name"]) : "";
    $email = isset($_POST["email"]) ? trim($_POST["email"]) : "";
    $password = isset($_POST["password"]) ? $_POST["password"] : "";
    $confirmPassword = isset($_POST["confirmPassword"]) ? $_POST["confirmPassword"] : "";

    // Name Validation
    if (empty($name)) {
        $nameErr = "Name is required.";
    } elseif (!preg_match("/^[A-Za-z ]{3,}$/", $name)) {
        $nameErr = "Enter a valid name (only letters & spaces, min 3 characters).";
    }

    // Email Validation
    if (empty($email)) {
        $emailErr = "Email is required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $emailErr = "Invalid email format.";
    }

    // Password Validation
    if (empty($password)) {
        $passwordErr = "Password is required.";
    } elseif (!preg_match("/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{6,}$/", $password)) {
        $passwordErr = "Password must be at least 6 characters, include a letter, number & special character.";
    }

    // Confirm Password Validation
    if (empty($confirmPassword)) {
        $confirmPasswordErr = "Confirm Password is required.";
    } elseif ($password !== $confirmPassword) {
        $confirmPasswordErr = "Passwords do not match.";
    }

    // If no errors, show success message
    if (empty($nameErr) && empty($emailErr) && empty($passwordErr) && empty($confirmPasswordErr)) {
        $successMessage = "Registration Successful!";
        // Clear the form values after successful submission
        $name = $email ="";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
    
    <style>
        body {
            font-family: "Poppins", Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: linear-gradient(to right,rgb(6, 78, 56),rgb(3, 105, 110)); 
            margin: 0;
            color: #ffffff;
        }

        .container {
            width: 90%;
            max-width: 400px;
            padding: 25px;
            background: rgb(19, 18, 18); 
            border-radius: 10px;
            text-align: center;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }

        h1 {
            color: #ffffff;
            font-weight: 600;
            margin-bottom: 20px;
        }

        label {
            font-size: 16px;
            font-weight: 500;
            color: #ffffff;
            display: block;
            text-align: left;
            margin: 8px 0 4px;
        }

        input {
            width: 100%;
            padding: 12px;
            margin: 6px 0;
            border: 1px solid #ccc; 
            border-radius: 6px;
            font-size: 14px;
            background: #333; 
            color: white; 
            transition: 0.3s;
            box-sizing: border-box;
        }

        input:focus {
            border-color: #00ffcc; 
            outline: none;
            box-shadow: 0 0 6px rgba(0, 255, 200, 0.7);
        }

        .error {
            color: red;
            font-size: 14px;
            text-align: left;
            display: block;
            margin-top: -5px;
        }

        .success {
            color: limegreen;
            font-size: 16px;
            text-align: center;
            margin-bottom: 10px;
        }

        button {
            width: 100%;
            padding: 12px;
            margin-top: 15px;
            background: #0c5a3e;
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: 0.3s;
        }

        button:hover {
            background: #0a4128; 
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Registration Form</h1>
    
    <!-- Display success message if set -->
    <?php if ($successMessage): ?>
        <p class="success"><?php echo $successMessage; ?></p>
    <?php endif; ?>

    <!-- Registration Form -->
    <form action="" method="POST">
        <label for="name">Full Name:</label>
        <input type="text" name="name" value="<?php echo htmlspecialchars($name); ?>">
        <span class="error"><?php echo $nameErr; ?></span>

        <label for="email">Email:</label>
        <input type="email" name="email" value="<?php echo htmlspecialchars($email); ?>">
        <span class="error"><?php echo $emailErr; ?></span>

        <label for="password">Password:</label>
        <input type="password" name="password">
        <span class="error"><?php echo $passwordErr; ?></span>

        <label for="confirmPassword">Confirm Password:</label>
        <input type="password" name="confirmPassword">
        <span class="error"><?php echo $confirmPasswordErr; ?></span>

        <button type="submit">Register</button>
    </form>
</div>

</body>
</html>
