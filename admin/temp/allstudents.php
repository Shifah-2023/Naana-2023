<?php
session_start();
include '../../includes/Operations.php';
$obj = new Operations();
$msg = ['error' => '', 'content' => ''];

//Checking if logined - impLying username exists

//checking account type


//Delete a row
if (isset($_GET['id'])) {
    $obj->StudentID = $_GET['id'];
    $result = $obj->deleteStudent();
    echo $result;
}
?>
<?php include "../../includes/header.php";
include "../../includes/navbar.php";
?>
<!DOCTYPE html>
<html lang="en">

<!-- Mirrored from coderthemes.com/greeva/layouts/vertical-dark/tables-datatable.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 19 Sep 2023 04:15:03 GMT -->

<head>
    <!-- third party css -->
    <link href="assets/libs/datatables/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/libs/datatables/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/libs/datatables/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/libs/datatables/select.bootstrap4.min.css" rel="stylesheet" type="text/css" />

    <!-- App css -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/app.min.css" rel="stylesheet" type="text/css" />

</head>

<body>
    <?php ?>
    <div class="content-page">
        <div class="content">

            <!-- Start Content-->
            <div class="container-fluid">

                <!-- start page title -->
                <!-- <div class="row">
                    <div class="col-12">
                        <div class="page-title-box">
                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Greeva</a></li>
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Tables</a></li>
                                    <li class="breadcrumb-item active">Data Tables</li>
                                </ol>
                            </div>
                            <h4 class="page-title">Data Tables</h4>
                        </div>
                    </div>
                </div> -->
                <!-- end page title -->

                <?php
                $obj = new Operations();
                $result = $obj->retrieveAllStudents();
                ?>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="card-box">
                                <h4 class="header-title">ALL REGISTERED STUDENTS</h4>
                                <?php if (is_array($result)) { ?>
                                    <table id="datatable" class="table table-bordered dt-responsive nowrap">
                                        <tr>
                                            <th>S/N</th>
                                            <th>FIRST NAME</th>
                                            <th>LAST NAME</th>
                                            <th>DOB</th>
                                            <th>ADDRESS</th>
                                            <th>CONTACT</th>
                                            <th>EMAIL</th>
                                            <th>ACTION</th>
                                        </tr>
                                        <?php
                                        $t = 0;
                                        foreach ($result as $res) {
                                            $t++; ?>
                                            <tr>
                                                <td><?= $res['sn'] ?></td>
                                                <td><?= $res['Firstname'] ?></td>
                                                <td><?= $res['Lastname'] ?></td>
                                                <td><?= $res['DateOfBirth'] ?></td>
                                                <td><?= $res['Address'] ?></td>
                                                <td><?= $res['ContactNumber'] ?></td>
                                                <td><?= $res['Email'] ?></td>
                                                <td>
                                                    <a href="editstudent.php?id=<?= $res['StudentID'] ?>"><button class="btn btn-success">Edit</button></a>
                                                    <a href="allstudents.php?id=<?= $res['StudentID'] ?>
                                "><button class="btn btn-danger">Delete</button></a>
                                                </td>
                                            </tr>
                                        <?php
                                        }
                                        ?>
                                    </table> <?php } else {
                                                ?><center><?php
                                                            echo 'NO REGISTERED STUDENT. <a href="createstudent.php"><button class="btn btn-primary">CLICK HERE TO CREATE.</button></a>';
                                                            ?></center> <?php
                                                                    } ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                include '../../includes/footer.php';
                ?>

                <!-- Right bar overlay-->
                <div class="rightbar-overlay"></div>

                <!-- Vendor js -->
                <script src="assets/js/vendor.min.js"></script>

                <!-- datatable js -->
                <script src="assets/libs/datatables/jquery.dataTables.min.js"></script>
                <script src="assets/libs/datatables/dataTables.bootstrap4.min.js"></script>
                <script src="assets/libs/datatables/dataTables.responsive.min.js"></script>
                <script src="assets/libs/datatables/responsive.bootstrap4.min.js"></script>

                <script src="assets/libs/datatables/dataTables.buttons.min.js"></script>
                <script src="assets/libs/datatables/buttons.bootstrap4.min.js"></script>
                <script src="assets/libs/datatables/buttons.html5.min.js"></script>
                <script src="assets/libs/datatables/buttons.flash.min.js"></script>
                <script src="assets/libs/datatables/buttons.print.min.js"></script>

                <script src="assets/libs/datatables/dataTables.keyTable.min.js"></script>
                <script src="assets/libs/datatables/dataTables.select.min.js"></script>

                <!-- Datatables init -->
                <script src="assets/js/pages/datatables.init.js"></script>

                <!-- App js -->
                <script src="assets/js/app.min.js"></script>

</body>

</html>