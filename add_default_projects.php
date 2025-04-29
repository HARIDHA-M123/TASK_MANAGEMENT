<?php
require_once 'config/database.php';

try {
    $database = new Database();
    $db = $database->getConnection();
    
    // Check if projects already exist
    $query = "SELECT COUNT(*) as count FROM projects";
    $stmt = $db->prepare($query);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($result['count'] == 0) {
        // Add default projects
        $projects = [
            ['name' => 'Website Development', 'description' => 'Main company website development project'],
            ['name' => 'Mobile App', 'description' => 'Mobile application development project'],
            ['name' => 'Database Migration', 'description' => 'Legacy system database migration project'],
            ['name' => 'API Integration', 'description' => 'Third-party API integration project'],
            ['name' => 'System Maintenance', 'description' => 'Regular system maintenance and updates']
        ];
        
        $query = "INSERT INTO projects (project_name, description, created_by) VALUES (:name, :description, 1)";
        $stmt = $db->prepare($query);
        
        foreach ($projects as $project) {
            $stmt->bindParam(":name", $project['name']);
            $stmt->bindParam(":description", $project['description']);
            $stmt->execute();
        }
        
        echo "Default projects added successfully!<br>";
        echo "You can now create tasks with these projects.<br>";
        echo "<a href='dashboard.php'>Go to Dashboard</a>";
    } else {
        echo "Projects already exist in the database.<br>";
        echo "<a href='dashboard.php'>Go to Dashboard</a>";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?> 