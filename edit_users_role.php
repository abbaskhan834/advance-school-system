<?php
include "config/conn.php"; 

$id = $_POST['id'];
$role_name = $_POST['role_name'];

try {

    $sql = "UPDATE users_role SET role_name = :role_name WHERE id = :id";
    
    $stmt = $conn->prepare($sql);

    $stmt->bindParam(':role_name', $role_name);
    $stmt->bindParam(':id', $id);

    $stmt->execute();

    // echo "success";

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>