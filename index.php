<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

// Handle preflight OPTIONS request
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

// Include your compute.php or database connection class
include 'compute.php';

// Check if function is set - handle both regular POST and FormData
$postData = $_POST;

// Check if request is coming as JSON
$contentType = isset($_SERVER["CONTENT_TYPE"]) ? $_SERVER["CONTENT_TYPE"] : '';
if (strpos($contentType, 'application/json') !== false) {
    $jsonData = file_get_contents('php://input');
    $postData = json_decode($jsonData, true) ?: [];
}

if (!isset($postData['function'])) {
    echo json_encode(["error" => "No function specified"]);
    exit; // Stop execution if no function is provided
}

$function = $postData['function']; // Get function from appropriate source

// Handle different functions
switch ($function) {
    case 'addUser':
        // Extract user data
        $names = $postData["names"];
        $email = $postData["email"];
        $phoneNumber = $postData["phoneNumber"];
        $password = $postData["password"];

        // Logging data to confirm it's being received
        error_log("Received data - Names: $names, Email: $email, Phone: $phoneNumber");

        // Insert data into the database
        $sql = "INSERT INTO bursary.users(`names`, `email`, `phoneNumber`, `password`) 
                VALUES ('$names','$email','$phoneNumber','$password')";

        compute::instance()->execute($sql);

        // Return success response
        echo json_encode(["success" => true, "message" => "User added successfully"]);
        break;

    case 'LoginUser':
        // Extract login data
        $email = isset($postData["email"]) ? $postData["email"] : '';
        $password = isset($postData["password"]) ? $postData["password"] : '';

        // Log login attempt
        error_log("Login attempt - Email: $email");

        // Query to check user credentials
        $sql = "SELECT * FROM bursary.users WHERE email='$email' AND password='$password'";
        $result = compute::instance()->fetch($sql, false, true);

        if ($result) {
            // User found with matching credentials
            echo json_encode([
                "success" => true,
                "message" => "Login successful",
                "user" => $result
            ]);
        } else {
            // No matching user found
            echo json_encode([
                "success" => false,
                "message" => "Invalid email or password"
            ]);
        }
        break;

    case 'getUsers':
        // Fetch users from the database
        $sql = "SELECT * FROM `users`";
        compute::instance()->fetch($sql);
        break;

    case 'deleteUser':
        // Delete user based on email
        $email = $postData["email"];
        $sql = "DELETE FROM `users` WHERE `email`='$email'";
        compute::instance()->execute($sql);
        echo json_encode(["success" => true, "message" => "User deleted successfully"]);
        break;

    case 'updateUser':
        // Update user data
        $names = $postData["names"];
        $email = $postData["email"];
        $phoneNumber = $postData["phoneNumber"];
        $password = $postData["password"];

        $sql = "UPDATE `users` SET `names`='$names', `phoneNumber`='$phoneNumber', `email`='$email', `password`='$password' WHERE `email`='$email'";
        compute::instance()->execute($sql);
        echo json_encode(["success" => true, "message" => "User updated successfully"]);
        break;

    default:
        // Handle invalid function call
        echo json_encode(["error" => "Invalid function"]);
        break;
}
?>