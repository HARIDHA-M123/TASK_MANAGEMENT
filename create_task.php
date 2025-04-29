<?php
session_start();
require_once 'config/database.php';

try {
    $database = new Database();
    $db = $database->getConnection();
    
    // Get the admin user_id
    $query = "SELECT user_id FROM users WHERE email = 'admin@example.com' LIMIT 1";
    $stmt = $db->prepare($query);
    $stmt->execute();
    $admin = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$admin) {
        throw new Exception("Admin user not found");
    }
    
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $title = $_POST['title'];
        $description = $_POST['description'];
        $project_id = $_POST['project_id'];
        $assigned_to = $_POST['assigned_to'];
        $deadline = $_POST['deadline'];
        $created_by = $admin['user_id']; // Use the admin user_id
        $current_status = 'Discussion 1';
        
        // Start transaction
        $db->beginTransaction();
        
        // Insert task
        $query = "INSERT INTO tasks (title, description, project_id, assigned_to, created_by, deadline, current_status) 
                 VALUES (:title, :description, :project_id, :assigned_to, :created_by, :deadline, :current_status)";
        
        $stmt = $db->prepare($query);
        $stmt->bindParam(":title", $title);
        $stmt->bindParam(":description", $description);
        $stmt->bindParam(":project_id", $project_id);
        $stmt->bindParam(":assigned_to", $assigned_to);
        $stmt->bindParam(":created_by", $created_by);
        $stmt->bindParam(":deadline", $deadline);
        $stmt->bindParam(":current_status", $current_status);
        $stmt->execute();
        
        $task_id = $db->lastInsertId();
        
        // Insert initial status log
        $query = "INSERT INTO task_status_log (task_id, status, changed_by, comments) 
                 VALUES (:task_id, :status, :changed_by, 'Task created')";
        $stmt = $db->prepare($query);
        $stmt->bindParam(":task_id", $task_id);
        $stmt->bindParam(":status", $current_status);
        $stmt->bindParam(":changed_by", $created_by);
        $stmt->execute();
        
        // Commit transaction
        $db->commit();
        
        header("Location: dashboard.php");
        exit();
    }
} catch (Exception $e) {
    if (isset($db) && $db->inTransaction()) {
        $db->rollBack();
    }
    echo "Error: " . $e->getMessage();
    exit();
}

// If not POST request, redirect to dashboard
header("Location: dashboard.php");
exit();
?> 