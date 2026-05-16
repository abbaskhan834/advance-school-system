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
       header("location:congrats?goto_page=user_role&message=error--Something went wrong, Please try later.");
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
                                    <th style="padding-left:30px">Edit</th>
                                </tr>
                            </thead>
                            <tbody>
                    <?php
                    $page = "user_role.php";
                    $table = "users_role";
                      $count = 1; 
                      while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                       ?>
                    <tr>
                        <td><?= $count++ ?></td>
                        <td><?= $row['role_name'] ?></td>
                        <td>
                     <a href="javascript:void(0)" class="btn btn-success m-1"onclick="openEditModal(
                        '<?= $row['id'] ?>',
                        '<?= $row['role_name'] ?>'
                        )"><i class="fa fa-edit"></i></a>  
                    </td>

                    <script>
                         function openEditModal(id , role_name) {
                         // id hidden input me set kar dein
                         document.getElementById("user_id").value = id;
                         document.getElementById("role_name").value = role_name;

                         // modal open
                         $('#editModal').modal('show'); 
                        }
                    </script>
    
                <div class="modal fade" id="editModal">
                    <div class="modal-dialog">
                        <div class="modal-content">

                    <form method="POST" action="edit_users_role">

                        <div class="modal-body">

                            <input type="hidden" name="user_id" id="user_id">

                            <input type="text" name="role_name" id="role_name" class="form-control">
                        </div>

                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary" onclick="updateRole()">
                                Update
                            </button>
                             </div>
                            </form>
                         </div>
                        </div>
                        </div>
                        </tr>
                         <?php
                             } 
                           ?>
        <!-- AJAX CALL FOR UPDATE USER ROLE -->
                     <script>
                     function updateRole() {

                         let id = document.getElementById("user_id").value;
                         let role_name = document.getElementById("role_name").value;

                         $.ajax({
                             url: "edit_users_role.php",
                             type: "POST",
                             data: {
                                 id: id,
                                 role_name: role_name
                             },
                             success: function(response) {
                                 header("location:congrats?goto_page=user_role&message=success--user added successfully")
                                 $('#editModal').modal('hide');
                                 location.reload();
                             }
                         });
                     }
                     </script>
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
