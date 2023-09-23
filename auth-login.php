<?php
session_start();
include './includes/Operations.php';
$obj = new Operations();
$msg = ['error' => '', 'content' => ''];

// Check if the login form is submitted
if (isset($_POST['login'])) {
    $obj->Email = $_POST['email'];
    $obj->Password = $_POST['password'];

    if ($obj->userLogin() == USER_AUTHENTICATED) {
        $_SESSION['Email'] = $obj->Email;

        // Set the 'userType' session variable based on user type
        if ($_POST['usertype'] == 'Admin') {
            $_SESSION['userType'] = 'Admin';
            // Redirect to the admin dashboard
            header('Location: ./admin/temp/index.php');
        } elseif ($_POST['usertype'] == 'Parent') {
            $_SESSION['userType'] = 'Parent';
            header('location: ./parent/temp/index.php');
        } elseif ($_POST['usertype'] == 'Teacher') {
            $_SESSION['userType'] = 'Teacher';
            header('location: ./teacher/temp/index.php');
        } else {
            // Handle invalid user type
            $msg['error'] = true;
            $msg['content'] = 'Invalid user type';
        }
        exit;
    } else {
        $msg['error'] = true;
        $msg['content'] = 'Invalid Login Credentials';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<!-- Rest of your HTML code remains the same -->

<!DOCTYPE html>
<html lang="en">

<!-- Mirrored from coderthemes.com/greeva/layouts/vertical-dark/auth-login.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 19 Sep 2023 04:15:16 GMT -->

<head>
    <meta charset="utf-8" />
    <title>P-TCS- Parent-Teacher Communication Portal</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
    <meta content="Coderthemes" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="assets/images/favicon.ico">

    <!-- App css -->
    <link href="Admin\temp\assets\css\bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="Admin\temp\assets\css\icons.min.css" rel="stylesheet" type="text/css" />
    <link href="Admin\temp\assets\css\app.min.css" rel="stylesheet" type="text/css" />
</head>

<body class="authentication-bg authentication-bg-pattern d-flex align-items-center">

    <div class="home-btn d-none d-sm-block">
        <a href="index.html"><i class="fas fa-home h2 text-white"></i></a>
    </div>

    <div class="account-pages w-100 mt-5 mb-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-5">
                    <div class="card">

                        <div class="card-body p-4">

                            <div class="text-center mb-4">
                                <a href="index.html">
                                    <span><img src="admin/temp/assets/images/logo-light.png" alt="" height="28"></span>
                                </a>
                            </div>

                            <form class="pt-2" method="POST">

                                <div class="form-group mb-3">
                                    <label for="emailaddress">Email address</label>
                                    <input class="form-control" type="email" name="email" id="emailaddress" required="" placeholder="Enter your email">
                                </div>

                                <div class="form-group mb-3">
                                    <a href="./admin/temp/auth-recoverpassword.php" class="text-muted float-right"><small>Forgot your password?</small></a>
                                    <label for="password">Password</label>
                                    <input class="form-control" type="password" name="password" required="" id="password" placeholder="Enter your password">
                                </div>
                                <div class="form-group mb-3">
                                    <select class=" form-control" data-toggle="select2" name="usertype">
                                        <option>Select UserType</option>
                                        <option value="Admin">Admin</option>
                                        <option value="Parent">Parent</option>
                                        <option value="Teacher">Teacher</option>
                                    </select>
                                </div> <!-- end col -->
                                <div class="custom-control custom-checkbox mb-3">
                                    <input type="checkbox" class="custom-control-input" id="checkbox-signin" checked>
                                    <label class="custom-control-label" for="checkbox-signin">Remember me</label>
                                </div>

                                <div class="form-group mb-0 text-center">
                                    <button class="btn btn-success btn-block" type="submit" name="login"> Log In </button>
                                </div>

                            </form>

                            <div class="row mt-3">
                                <div class="col-12 text-center">
                                    <p class="text-muted mb-0">Don't have an account? <a href="auth-register.php" class="text-dark ml-1"><b>Sign Up</b></a></p>
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
    <script src="Admin\temp\assets\js\vendor.min.js"></script>

    <!-- App js -->
    <script src="Admin\temp\assets\js\app.min.js"></script>

</body>

<!-- Mirrored from coderthemes.com/greeva/layouts/vertical-dark/auth-login.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 19 Sep 2023 04:15:16 GMT -->

</html>