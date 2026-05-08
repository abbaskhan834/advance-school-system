<?php
include 'config/conn.php';

$id = $_GET['id'];
$page =$_GET['page'];
$table = $_GET['table'];

$deleteQuery = "DELETE FROM $table WHERE `id` = '$id';";
$stmt = $conn->prepare($deleteQuery);
$stmt->execute();

header("location: $page?msg=deleted");
exit;

 ?>