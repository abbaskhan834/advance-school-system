<?php
session_start();
include 'config/conn.php';
$MSG = $_GET['message'] ?? '';


if (isset($_POST['submit'])) {

    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    $selectQuery = "SELECT * FROM users WHERE email = :email";
    $stmt = $conn->prepare($selectQuery);
    $stmt->bindParam(':email', $email);
    $stmt->execute();

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        if (password_verify($password, $user['password'])) {

            if($user['is_active'] != 1){
                $msg = "error--Your account is de-activated or deleted.";
                header("location:congrats?goto_page=index&message=$msg");
                exit;
            }


            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['user_email'] = $user['email'];

            header("Location: dashboard.php");
            exit();

        } else {
            $msg = "error--Email or password is not valide.";
            header("location:congrats?goto_page=index&message=$msg");
            exit;
        }
    } else {
        $msg =  "error--Email or password is not valide.";
        header("location:congrats?goto_page=index&message=$msg");
    }
}

?>

<!DOCTYPE html>
<html lang="en" class="h-100">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>school management system</title>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="assets/images/favicon.png">

    <?php
    include 'config/css_links.php'; 
     ?>

</head>

<body class="h-100">
    <?php 
        include "./config/alerts.php";
    ?>

    <div class="authincation h-100">
        <div class="container-fluid h-100">
            <div class="row justify-content-center h-100 align-items-center">
                <div class="col-md-5">
                    <div class="authincation-content">
                        <div class="row no-gutters">
                            <div class="col-xl-12">
                                <div class="auth-form">
                                    <h4 class="text-center mb-4">Sign in your account</h4>
                                    <form method="post">
                                        <div class="form-group">
                                            <label><strong>Email</strong></label>
                                            <input type="email" class="form-control" name="email"
                                                value="khan@534571gmail.com">
                                        </div>
                                        <div class="form-group">
                                            <label><strong>Password</strong></label>
                                            <input type="password" class="form-control" name="password" value="123">
                                        </div>
                                        <div class="form-row d-flex justify-content-between mt-4 mb-2">
                                            <div class="form-group">
                                            </div>
                                        </div>
                                        <div class="text-center">
                                            <button type="submit" name="submit"
                                                class="btn btn-primary btn-block">Login</button>
                                        </div>
                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <?php
    include 'config/js_links.php'; 
     ?>

</body>

</html>