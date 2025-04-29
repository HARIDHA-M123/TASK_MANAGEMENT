<?php
require_once 'config/database.php';

try {
    $database = new Database();
    $db = $database->getConnection();
    
    // Check if admin user already exists
    $query = "SELECT COUNT(*) as count FROM users WHERE email = 'admin@example.com'";
    $stmt = $db->prepare($query);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($result['count'] == 0) {
        // Add default admin user
        $name = 'Admin';
        $email = 'admin@example.com';
        $password = password_hash('admin123', PASSWORD_DEFAULT);
        $designation = 'Administrator';
        $team = 'Management';
        $employee_id = 'ADMIN001';
        
        $query = "INSERT INTO users (name, email, password, designation, team, employee_id) 
                 VALUES (:name, :email, :password, :designation, :team, :employee_id)";
        
        $stmt = $db->prepare($query);
        $stmt->bindParam(":name", $name);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":password", $password);
        $stmt->bindParam(":designation", $designation);
        $stmt->bindParam(":team", $team);
        $stmt->bindParam(":employee_id", $employee_id);
        
        if ($stmt->execute()) {
            echo "Admin user created successfully!<br>";
            echo "You can now add default projects.<br>";
            echo "<a href='add_default_projects.php'>Add Default Projects</a>";
        }
    } else {
        echo "Admin user already exists.<br>";
        echo "<a href='add_default_projects.php'>Add Default Projects</a>";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?> 