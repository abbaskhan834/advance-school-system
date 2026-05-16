<?php
include "config/conn.php"; 
$MSG = $_GET['message'] ?? '';
$id = $_POST['user_id'];
$role_name = $_POST['role_name'];

try {

    $sql = "UPDATE users_role SET role_name = :role_name WHERE id = :user_id";
    
    $stmt = $conn->prepare($sql);

    $stmt->bindParam(':role_name', $role_name);
    $stmt->bindParam(':user_id', $id);

    $stmt->execute();

    header("location:congrats?goto_page=user_role&message=success--user role updated successfully");
    exit;

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>