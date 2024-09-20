<?php
// Include the MikroTik API
require('routeros_api.class.php');

$host = '192.168.88.1';  // Your public IP address
$username = 'MuemaSW';
$password = 'init';

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect username and password from form
    $user = $_POST['username'];
    $pass = $_POST['password'];

    // Initialize MikroTik API client
    $API = new RouterosAPI();
    
       // Enable debug mode to get detailed error messages
    $API->debug = true;
    
    if ($API->connect($host, $username, $password)) {
        // Add a new user to the Hotspot
        $API->write('/ip/hotspot/user/add', false);
        $API->write('=name=' . $user, false);
        $API->write('=password=' . $pass, false);
        $API->write('=profile=default'); // Optional: You can define a profile

        $API->read();
        $API->disconnect();

        // Redirect the user back to the login page
        header('Location: http://192.168.88.1/login');
        exit;
    } else {
        echo "Failed to connect to MikroTik API.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            text-align: center;
            padding: 50px;
        }
        .container {
            width: 300px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            font-size: 24px;
            margin-bottom: 20px;
        }
        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #28a745;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin: 10px 0;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Register</h1>

    <form action="" method="POST">
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <input type="submit" value="Register">
    </form>
</div>

</body>
</html>
