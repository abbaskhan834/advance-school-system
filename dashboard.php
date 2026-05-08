<?php
session_start();
include 'config/conn.php';

if (!isset($_SESSION['user_id'])) {
  header("Location: index.php");
}

 ?>


<!DOCTYPE html>
<html lang="en">

<head>
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

          
        <marquee><h1>wellcome to <mark>School Management System</mark></h1></marquee>
        </div>
               
                    
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