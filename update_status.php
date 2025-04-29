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
        $task_id = $_POST['task_id'];
        $status = $_POST['status'];
        $comments = $_POST['comments'];
        $changed_by = $admin['user_id']; // Use the admin user_id
        
        // Start transaction
        $db->beginTransaction();
        
        // Update task status
        $query = "UPDATE tasks SET current_status = :status WHERE task_id = :task_id";
        $stmt = $db->prepare($query);
        $stmt->bindParam(":status", $status);
        $stmt->bindParam(":task_id", $task_id);
        $stmt->execute();
        
        // Log status change
        $query = "INSERT INTO task_status_log (task_id, status, changed_by, comments) 
                 VALUES (:task_id, :status, :changed_by, :comments)";
        $stmt = $db->prepare($query);
        $stmt->bindParam(":task_id", $task_id);
        $stmt->bindParam(":status", $status);
        $stmt->bindParam(":changed_by", $changed_by);
        $stmt->bindParam(":comments", $comments);
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