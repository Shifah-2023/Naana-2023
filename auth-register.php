<?php
session_start();
date_default_timezone_set('Africa/Kampala');
include 'C:\xampp\htdocs\P-TCS\includes\Operations.php';
$obj = new Operations();
$msg = ['error' => '', 'content' => ''];
if (isset($_POST['submit'])) {
    $obj->Fullname = $_POST['fullname'];
    $obj->Email = $_POST['email'];
    $obj->Password = $_POST['password'];

    $res = $obj->createUsers();

    if ($res == USER_CREATED) {
        $msg['error'] = 'halo';
        $msg['content'] = 'User Created Successfully';
    } else {
        $msg['error'] = true;
        $msg['content'] = 'User Creation Failed';
    }
} ?>
<!DOCTYPE html>
<html lang="en">

<!-- Mirrored from coderthemes.com/greeva/layouts/vertical-dark/auth-register.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 19 Sep 2023 04:15:16 GMT -->

<head>
    <meta charset="utf-8" />
    <title>P-TCS- Parent-Teacher Communication Portal</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
    <meta content="Coderthemes" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="Admin\coderthemes.com\greeva\layouts\vertical-dark\assets\images\favicon.ico">

    <!-- App css -->
    <link href="Admin\coderthemes.com\greeva\layouts\vertical-dark\assets\css\bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="Admin\coderthemes.com\greeva\layouts\vertical-dark\assets\css\icons.min.css" rel="stylesheet" type="text/css" />
    <link href="Admin\coderthemes.com\greeva\layouts\vertical-dark\assets\css\app.min.css" rel="stylesheet" type="text/css" />

</head>

<body class="authentication-bg authentication-bg-pattern d-flex align-items-center">

    <div class="home-btn d-none d-sm-block">
        <a href="index.php"><i class="fas fa-home h2 text-white"></i></a>
    </div>

    <div class="account-pages w-100 mt-5 mb-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-5">
                    <div class="card">

                        <div class="card-body p-4">

                            <div class="text-center mb-4">
                                <a href="index.php">
                                    <span><img src="Admin\coderthemes.com\greeva\layouts\vertical-dark\assets\images\logo-light.png" alt="" height="28"></span>
                                </a>
                            </div>
                            <center>
                                <?php if ($msg['error'] != '') {
                                    if ($msg['error'] == 'halo') { ?>
                                        <div class="alert alert-success alert-dicorsosible show fade">
                                            <div class="alert-body">
                                                <button class="close" data-dicorsos="alert">
                                                    <span>&times;</span>
                                                </button>
                                                <?= $msg['content'] ?>
                                            </div>
                                        </div><?php } else { ?>
                                        <div class="alert alert-danger alert-dicorsosible show fade">
                                            <div class="alert-body">
                                                <button class="close" data-dicorsos="alert">
                                                    <span>&times;</span>
                                                </button>
                                                <?= $msg['content'] ?>
                                            </div>
                                        </div>
                                <?php }
                                        } ?>
                            </center>

                            <form class="pt-2" method="POST">

                                <div class="form-group mb-3">
                                    <label for="fullname">Full Name</label>
                                    <input class="form-control" type="text" id="fullname" name="fullname" placeholder="Enter your name" required>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="emailaddress">Email address</label>
                                    <input class="form-control" type="email" id="emailaddress" required placeholder="Enter your email" name="email">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="password">Password</label>
                                    <input class="form-control" type="password" required id="password" placeholder="Enter your password" name="password">
                                </div>

                                <div class="custom-control custom-checkbox mb-3">
                                    <input type="checkbox" class="custom-control-input" id="checkbox-signup">
                                    <label class="custom-control-label" for="checkbox-signup">I accept <a href="javascript: void(0);" class="text-dark">Terms and Conditions</a></label>
                                </div>

                                <div class="form-group mb-0 text-center">
                                    <button class="btn btn-success btn-block" type="submit" name="submit"> Sign Up </button>
                                </div>

                            </form>

                            <div class="row mt-3">
                                <div class="col-12 text-center">
                                    <p class="text-muted mb-0">Already have account? <a href="auth-login.php" class="text-dark ml-1"><b>Sign In</b></a></p>
                                </div> <!-- end col -->
                            </div>
                            <!-- end row -->

                        </div> <!-- end card-body -->
                    </div>
                    <!-- end card -->

                </div> <!-- end col -->
            </div>
            <!-- end row -->
        </div>
        <!-- end container -->
    </div>
    <!-- end page -->

    <!-- Vendor js -->
    <script src="Admin\coderthemes.com\greeva\layouts\vertical-dark\assets\js\vendor.min.js"></script>

    <!-- App js -->
    <script src="Admin\coderthemes.com\greeva\layouts\vertical-dark\assets\js\app.min.js"></script>

</body>

<!-- Mirrored from coderthemes.com/greeva/layouts/vertical-dark/auth-register.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 19 Sep 2023 04:15:16 GMT -->

</html>