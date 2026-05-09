<?php
session_start();
include 'config/conn.php';
$MSG = $_GET['message'] ?? '';

if (!isset($_SESSION['user_id'])) {
  header("Location: index.php");
}

$userStmt = $conn->prepare("SELECT * FROM users");
$userStmt->execute();

$roleStmt = $conn->prepare("SELECT * FROM users_role");
$roleStmt->execute();


if (isset($_POST['submit'])) {

    $roleId   = $_POST['role_id'];
    $name     = $_POST['full_name'];
    $email    = $_POST['email'];
    $phone    = $_POST['phone'];
    $password = $_POST['password'];
    $password = password_hash($password, PASSWORD_BCRYPT);

    /* IMAGE UPLOAD */
    $profile_pic = "";

    if (!empty($_FILES['profile_pic']['name'])) {

        $imageName = time() . "_" . $_FILES['profile_pic']['name'];
        $tmpName   = $_FILES['profile_pic']['tmp_name'];

        $folder = "upload_user_pic/" . $imageName;

        move_uploaded_file($tmpName, $folder);

        $profile_pic = $imageName;
    }

    try {

        $conn->beginTransaction();

        $insertQuery = "INSERT INTO users(role_id, full_name,email,phone,password,profile_pic)
                        VALUES(:role_id,:name,:email,:phone,:password,:profile_pic);";

        $stmt = $conn->prepare($insertQuery);

        $stmt->execute([
            ':role_id'     => $roleId,
            ':name'        => $name,
            ':email'       => $email,
            ':phone'       => $phone,
            ':password'    => $password,
            ':profile_pic' => $profile_pic
        ]);
        $conn->commit();

        header("Location:congrats?goto_page=add_users&message=success--User added successfully.");
        exit();

    } catch (Exception $e) {
        $conn->rollback();
        header("Location:congrats?goto_page=add_users&message=error--Somethings wents wrongs, Please try leter.");
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
                <!-- Button -->
                <div class="text-right">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#userModal">
                        Add User
                    </button>
                </div>
                <div class="col-12" style="margin-top: 20px;">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Users</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="example2" class="display" style="width:100%">
                                    <thead>
                                        <tr style="color: black">
                                            <th>id</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                            <th>profile</th>
                                            <th style="padding-left:50px">edit</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        $page = "add_users.php";
                                        $table = "users";
                                            $count = 1;
                                            while ($row = $userStmt->fetch(PDO::FETCH_ASSOC)) {              
                                        ?>
                                        <tr>
                                            <td><?= $count++ ?></td>
                                            <td><?= $row['full_name'] ?></td>
                                            <td><?= $row['email'] ?></td>
                                            <td><?= $row['phone'] ?></td>
                                            <td>
                                                <img src="upload_user_pic/<?= $row['profile_pic'] ?>"
                                                    style="height: 50px ; width: 50px">
                                                </td>
                                            <td>
                                                <a href="edit_add_users?id=<?=$row['id'] ?>">
                                                    <i class="fa fa-edit btn btn-primary"></i>
                                                </a>
                                                <a href="generic_delete.php?page=<?=$page?>&table=<?=$table?>&id=<?=$row['id']?>" onclick="return deleteConfirm(this);">
                                                    <i class="fa fa-trash btn btn-danger"></i>
                                                </a>
                                                <?php if ($row['is_active'] == 0): ?>
                                                
                                                <a href="toggle_users?id=<?= $row['id']; ?>"
                                                    class="btn btn-danger btn-sm" onclick="return blockConfirm(this);">
                                                    <i class="fa fa-lock"> </i>
                                                </a>
                                                <?php else: ?>
                                                <a href="toggle_users?id=<?= $row['id']; ?>"
                                                    class="btn btn-success btn-sm" onclick="return unblockConfirm(this);">
                                                    <i class="fa fa-unlock"></i>
                                                </a>
                                                <?php endif; ?>
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

            <!-- <-- Small Modal -->
            <div class="modal fade" id="userModal" tabindex="-1">
                <div class="modal-dialog modal-md">
                    <div class="modal-content">

                        <!-- Header -->
                        <div class="modal-header">
                            <h5 class="modal-title">User Form</h5>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>

                        <!-- Body -->
                        <div class="modal-body">

                            <form method="post" enctype="multipart/form-data">

                                <!-- First Row -->
                                <div class="form-row">
                                    <div class="col-md-6 mb-3">
                                        <label>Name</label>
                                        <input type="text" class="form-control" name="full_name" placeholder="Name"
                                            required>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label>Email</label>
                                        <input type="email" class="form-control" id="email" name="email" placeholder="Email"
                                            required value="">
                                            <small id="emailError" style="color:red;"></small>
                                    </div>
                                </div>

                                <!-- Second Row -->
                                <div class="form-row">
                                    <div class="col-md-6 mb-3">
                                        <label>Phone</label>
                                        <input type="text" class="form-control" name="phone" placeholder="Phone"
                                            required>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label>Password</label>
                                        <input type="password" class="form-control" name="password"
                                            placeholder="Password" required>
                                    </div>
                                    <select name="role_id" class="form-control" required>
                                        <option value="">Select Role</option>
                                        <?php while($fetch = $roleStmt->fetch(PDO::FETCH_ASSOC)) { ?>
                                        <option value="<?= $fetch['id'] ?>">
                                            <?= $fetch['role_name'] ?>

                                        </option>

                                        <?php } ?>

                                    </select>
                                </div>

                                <!-- Third Row -->
                                <div class="form-group">
                                    <label>Profile</label>
                                    <input type="file" class="form-control" name="profile_pic" required>
                                </div>

                                <!-- Button -->
                                <center><button type="submit" name="submit"  id="submitBtn" class="btn btn-secondary btn-block col-2">
                                        Submit
                                    </button></center>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
       include 'config/footer.php'; 
        ?>
    </div>


    <?php
    include 'config/js_links.php'; 
     ?>


</body>

</html>




<script>

function deleteConfirm(el) {
  Swal.fire({
    title: 'Are you sure?',
    text: "you want to delete data!",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#d33',
    cancelButtonColor: '#3085d6',
    confirmButtonText: 'Yes, delete it!',
    cancelButtonText: 'Cancel'
  }).then((result) => {
    if (result.isConfirmed) {
      window.location.href = el.href; 
    }
  });

  return false;   
}
</script>

 </script>
  <?php if (isset($_GET['msg']) && $_GET['msg'] == 'deleted') { ?>
  <script>
  Swal.fire({
    icon: 'success',
    title: 'Deleted!',
    text: 'User deleted successfully',
    confirmButtonColor: '#28a745'
  });
  </script>
  <?php 
  } 
  ?>

</script>
<!-- block button -->
<script>
function blockConfirm(el) {
  Swal.fire({
    title: 'Are you sure?',
    text: "you want to activated this user!",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#d33',
    cancelButtonColor: '#3085d6',
    confirmButtonText: 'Yes, activated it!',
    cancelButtonText: 'Cancel'
  }).then((result) => {
    if (result.isConfirmed) {
      window.location.href = el.href; 
    }
  });

  return false;   
}
</script>

 </script>
  <?php if (isset($_GET['msg']) && $_GET['msg'] == 'block') { ?>
  <script>
  Swal.fire({
    icon: 'warning',
    title: 'deactivated!',
    text: 'User deactivated successfully',
    confirmButtonColor: '#28a745'
  });
  </script>
  <?php 
  } 
  ?>

</script>
<!-- unblock button -->
<script>
function unblockConfirm(el) {
  Swal.fire({
    title: 'Are you sure?',
    text: "you want to deactivated this user!",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#d33',
    cancelButtonColor: '#3085d6',
    confirmButtonText: 'Yes, deactivated it!',
    cancelButtonText: 'Cancel'
  }).then((result) => {
    if (result.isConfirmed) {
      window.location.href = el.href; 
    }
  });

  return false;   
}
</script>

 </script>
  <?php if (isset($_GET['msg']) && $_GET['msg'] == 'unblock') { ?>
  <script>
  Swal.fire({
    icon: 'success',
    title: 'activated!',
    text: 'User activated successfully',
    confirmButtonColor: '#28a745'
  });
  </script>
  <?php 
  } 
  ?>
</script>





