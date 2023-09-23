<?php
session_start();
include '../../includes/Operations.php';
$obj = new Operations();
$msg = ['error' => '', 'content' => ''];
// $_SESSION['username'] = 'Eunice';
// $_SESSION['accType'] = 'Staff';
//check login (accType, username)

// if (isset($_SESSION['Email'])) {
//     if ($_SESSION['userType'] == 'Admin') {
//         header('location: admin/index.php');
//     } elseif ($_SESSION['userType'] == 'Parent') {
//         header('location: parent/index.php');
//     } elseif ($_SESSION['userType'] == 'Teacher') {
//         header('location: teacher/index.php');
//     }
// }
if (isset($_POST['submit'])) {
    $obj->Firstname = $_POST['name'];
    $obj->Lastname = $_POST['name'];
    $obj->DateOfBirth = $_POST['date'];
    $obj->Gender = $_POST['gender'];
    $obj->Address = $_POST['address'];
    $obj->ContactNumber = $_POST['contact'];
    $obj->Email = $_POST['email'];
    $username = $_SESSION['Email'];
    $obj->createdby =  $obj->getAdminIDByEmail($username);
    $obj->created = $obj->getDateandTime();

    $res = $obj->createStudent();
    if ($res == STUDENT_CREATED) {
        $msg['error'] = false;
        $msg['content'] = 'Student created Successfully';
    } else {
        $msg['error'] = true;
        $msg['content'] = 'Student creation failed';
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>PARENT-TEACHER COMMUICATION PORTAL SYSTEM</title>
    <!-- General CSS Files -->
    <link rel="stylesheet" href="assets/css/app.min.css">
    <link rel="stylesheet" href="assets/bundles/jquery-selectric/selectric.css">
    <!-- Template CSS -->
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/components.css">
    <!-- Custom style CSS -->
    <link rel="stylesheet" href="assets/css/custom.css">
    <link rel='shortcut icon' type='image/x-icon' href='assets/img/logos.jpeg' />
</head>

<body>
    <?php
    include "../../includes/header.php";
    include "../../includes/navbar.php";
    ?>
    <div id="wrapper">
        <div class="content-page">
            <div class="content">

                <!-- Start Content-->
                <div class="container-fluid">
                </div>
                <!-- Form row -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="card-box">
                            <h4 class="header-title">Add Student</h4>
                            <form method="POST">
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="inputAddress2" class="col-form-label">FirstName</label>
                                        <input type="text" class="form-control" id="inputAddress2" placeholder="Enter Your FirstName" name="name">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="inputPassword4" class="col-form-label">LastName</label>
                                        <input type="text" class="form-control" id="inputPassword4" placeholder="Enter Your LastName" name="name">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputAddress" class="col-form-label">Address</label>
                                    <input type="text" class="form-control" id="inputAddress" placeholder="1234 Main St" name="address">
                                </div>
                                <div class="form-group ">
                                    <label for="inputEmail4" class="col-form-label">Email</label>
                                    <input type="email" class="form-control" id="inputEmail4" placeholder="nanashi@gmail.com" name="email">
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="inputCity" class="col-form-label">Contact</label>
                                        <input type="telephone" class="form-control" id="inputCity" name="contact">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="inputState" class="col-form-label">Gender</label>
                                        <select id="inputState" class="form-control" name="gender">
                                            <option>Choose</option>
                                            <option>Female</option>
                                            <option>Male </option>
                                            <option>Other</option>

                                        </select>
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label for="inputZip" class="col-form-label">Date Of Birth</label>
                                        <input type="date" class="form-control" id="inputZip" name="date">
                                    </div>
                                </div>
                        </div>

                        <button type="submit" class="btn btn-primary" name="submit">ADD STUDENT</button>
                        </form>
                    </div> <!-- end card-box -->
                </div> <!-- end col -->
            </div>
            <!-- end row -->
        </div>
    </div>
    </div>
    <?php
    include "../../includes/footer.php";
    ?>
    <!-- Right bar overlay-->
    <div class="rightbar-overlay"></div>

    <!-- Vendor js -->
    <script src="assets/js/vendor.min.js"></script>

    <!-- App js -->
    <script src="assets/js/app.min.js"></script>
    <!-- KNOB JS -->
    <script src="assets/libs/jquery-knob/jquery.knob.min.js"></script>
    <!-- Chart JS -->
    <script src="assets/libs/chart-js/Chart.bundle.min.js"></script>

    <!-- Jvector map -->
    <script src="assets/libs/jqvmap/jquery.vmap.min.js"></script>
    <script src="assets/libs/jqvmap/jquery.vmap.usa.js"></script>

    <!-- Datatable js -->
    <script src="assets/libs/datatables/jquery.dataTables.min.js"></script>
    <script src="assets/libs/datatables/dataTables.bootstrap4.min.js"></script>
    <script src="assets/libs/datatables/dataTables.responsive.min.js"></script>
    <script src="assets/libs/datatables/responsive.bootstrap4.min.js"></script>

    <!-- Dashboard Init JS -->
    <script src="assets/js/pages/dashboard.init.js"></script>

    <!-- App js -->
</body>

</html>