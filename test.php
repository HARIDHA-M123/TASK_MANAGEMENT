<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Test PHP is working
echo "PHP is working!<br>";

// Test database connection
try {
    require_once 'config/database.php';
    $database = new Database();
    $db = $database->getConnection();
    echo "Database connection successful!<br>";
} catch (Exception $e) {
    echo "Database connection failed: " . $e->getMessage() . "<br>";
}

// Test file permissions
$test_file = 'test_write.txt';
if (file_put_contents($test_file, 'test')) {
    echo "File write permissions are working!<br>";
    unlink($test_file); // Clean up
} else {
    echo "File write permissions failed!<br>";
}

// Display PHP info
phpinfo();
?>