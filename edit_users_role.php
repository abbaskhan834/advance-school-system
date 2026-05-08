<?php
include 'config/conn.php';
$id = $_GET['id'];
	$selectQuery = "SELECT * FROM `users_role`;";
	$stmt = $conn->prepare($selectQuery);
	$stmt->execute();
	$row = $stmt->fetch(PDO::FETCH_ASSOC);
	
if (isset($_POST['submit'])) {
	$roleName = $_POST['role_name'];

$updateQuery = "UPDATE users_role SET `role_name` = '$roleName' WHERE `id` = '$id';";
$stmt = $conn->prepare($updateQuery);
$stmt->execute();

header("Location: user_role");

 } 
 ?>
<!DOCTYPE html>
<html lang="en">

<head>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>school Management system</title>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="./images/favicon.png">
    
    <?php
    include 'config/css_links.php'; 
     ?>
</head>
<body>

<!-- preLoader -->
<?php
include'config/preLoader.php'; 
?>
    <div id="main-wrapper">
        <!-- navHeader  -->
         <?php 
        include 'config/navHeader.php';
         ?> 
        <!-- header -->
         <?php
        include 'config/header.php'; 
         ?>
        
        <?php
        include 'config/sidebar.php'; 
         ?>

     <div class="content-body">
      <div class="container-fluid">
      	<form method="post">
      	<input type="text" name="role_name" value="<?=$row['role_name'] ?>" required>
      	<input type="submit" name="submit">
      	</form>
       </div>
  </div>         
  </div>   
    </div>
       <?php
       include 'config/footer.php'; 
        ?>
    
    <?php
    include 'config/js_links.php'; 
     ?>

</body>

</html>