<?php
include 'config/conn.php';
$id = $_GET['id'];
$message = $_GET['message'];
	$selectQuery = "SELECT * FROM `users`;";
	$stmt = $conn->prepare($selectQuery);
	$stmt->execute();
	$row = $stmt->fetch(PDO::FETCH_ASSOC);
	
if (isset($_POST['submit'])) {
  $fullName = $_POST['full_name'];
  $email    = $_POST['email'];
	$phone    = $_POST['phone'];

$updateQuery = "UPDATE users SET `full_name` = '$fullName' , `email` = '$email' , `phone` = '$phone'  WHERE `id` = '$id';";
$stmt = $conn->prepare($updateQuery);
$stmt->execute();

header("Location: add_users?message=$message");

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
      <input type="text" name="full_name" class="form-control w-30" value="<?= $row['full_name'] ?>"required >
      <br>
        <input type="text" name="email" class="form-control w-30" value="<?= $row['email'] ?>" required>
        <br>
      	<input type="text" name="phone" class="form-control w-30" value="<?= $row['phone'] ?>" required>
        <br>
      	<input type="submit" name="submit" class="form-control w-10 mx-5 mx-5" >
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