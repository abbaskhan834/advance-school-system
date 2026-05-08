<?php
include 'config/conn.php';
$MSG = $_GET['message'] ?? '';



if (isset($_POST['submit'])) {
     $rollName = $_POST['role_name'];

     try {
      $exist = "select count(*) as count from `users_role` where `role_name` = :name";

      $stmt = $conn->prepare($exist);
      $stmt->execute([':name' => $rollName]);
      $count = $stmt->fetchColumn();
     
      if($count > 0){
        header("location:congrats?goto_page=user_role&message=error--{$rollName} already exists.");
        exit;
      }
      
       $insertQuery = "INSERT INTO users_role(`role_name`)VALUES('$rollName');";
       $stmt = $conn->prepare($insertQuery);

       $stmt->execute();

       header("location:congrats?goto_page=user_role&message=success--Role submited successfully.");
        exit;
     } catch (Exception $e) {
       header("location:congrats?goto_page=user_role&message=error--Something wents wrong, Please try leter.");
       exit;
     }

   }
      
$selectQuery = "SELECT * FROM `users_role`";
$stmt = $conn->prepare($selectQuery);
$stmt->execute();
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

    <?php 
        include "./config/alerts.php";
    ?>

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
                <!-- Button trigger modal -->
                <div class="text-right">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                        Add User Role
                    </button>
                </div>

                <div class="col-12" style="margin-top: 20px;">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">User Role</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="example2" class="display" style="width:100%">
                                    <thead>
                                        <tr style="color: black">
                                            <th>id</th>
                                            <th>User Role</th>
                                            <th>Edit</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                          $count = 1; 
                                          while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                           ?>
                                        <tr>
                                            <td><?= $count++ ?></td>
                                            <td><?= $row['role_name'] ?></td>
                                            <td>
                                                <a href="edit_users_role?id=<?= $row['id'] ?>">
                                                    <i class="fa fa-edit btn btn-success"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        <?php
                                            } 
                                          ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">User Role</h5>
                            <button type="button" class="btn btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form method="post">
                            <div class="modal-body">
                                <input type="text" name="role_name" class="form-control col-6" placeholder="Add Role">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
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