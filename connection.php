<?php
// Database configuration with port support
$db_host = getenv('DB_HOST') ?: 'localhost';
$db_port = getenv('DB_PORT') ?: '3306'; // Default MySQL port
$db_user = getenv('DB_USER') ?: 'root';
$db_pass = getenv('DB_PASS') ?: '';
$db_name = getenv('DB_NAME') ?: 'demo';

// Create connection with port
$connection = mysqli_connect($db_host, $db_user, $db_pass, $db_name, $db_port);

// Check connection
if (!$connection) {
    // Log error for debugging
    error_log("Database connection failed: " . mysqli_connect_error());
    
    // Return JSON response for API calls
    if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
        header('Content-Type: application/json');
        echo json_encode(['error' => 'Database connection failed']);
        exit;
    }
    
    // Show user-friendly error for regular requests
    die("We're experiencing technical difficulties. Please try again later.");
}

// Set charset to ensure proper encoding
mysqli_set_charset($connection, "utf8mb4");

// Function to safely close the connection
function closeConnection() {
    global $connection;
    if ($connection) {
        mysqli_close($connection);
    }
}

// Register shutdown function to ensure connection is closed
register_shutdown_function('closeConnection');
?>
