<?php
include "./config/conn.php";
// $MSG = $_GET['message'] ?? '';

if (!isset($_GET['id'])) {
    header("Location: add_users.php");
    exit;
}

$id = $_GET['id'];

$stmt = $conn->prepare("SELECT is_active FROM users WHERE id = :id");
$stmt->bindParam(':id', $id);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// toggle logic
if ($user['is_active'] == 1) {
	$newStatus  = 0;
   $msg = "block";
    
}else{
	$newStatus = 1;
   $msg = "unblock";
    
}

$update = $conn->prepare("UPDATE users SET is_active = :status WHERE id = :id");
$update->bindParam(':status', $newStatus);
$update->bindParam(':id', $id);
$update->execute();

header("Location: add_users?msg=$msg");
exit;
?>