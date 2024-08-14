<?php
session_start();
require("config.php");

if (!isset($_SESSION['auser'])) {
    header("location:index.php");
    exit(); // Ensure script stops executing if user is not authenticated
}

// Handle commit action
if (isset($_GET['action']) && $_GET['action'] == 'commit' && isset($_GET['id'])) {
    $property_id = $_GET['id'];

    // Perform update to set committed in property table
    $update_property = mysqli_query($con, "UPDATE property SET committed = 1 WHERE pid = $property_id");

    // Insert into permanent_property table (Assuming structure based on previous information)
    if ($update_property) {
        $query_select_property = mysqli_query($con, "SELECT * FROM property WHERE pid = $property_id");
        if ($property = mysqli_fetch_assoc($query_select_property)) {
            $title = mysqli_real_escape_string($con, $property['title']);
            $pcontent = mysqli_real_escape_string($con, $property['pcontent']);
            $type = mysqli_real_escape_string($con, $property['type']);
            $bhk = mysqli_real_escape_string($con, $property['bhk']);
            $stype = mysqli_real_escape_string($con, $property['stype']);
            $bedroom = mysqli_real_escape_string($con, $property['bedroom']);
            $bathroom = mysqli_real_escape_string($con, $property['bathroom']);
            $balcony = mysqli_real_escape_string($con, $property['balcony']);
            $kitchen = mysqli_real_escape_string($con, $property['kitchen']);
            $hall = mysqli_real_escape_string($con, $property['hall']);
            $floor = mysqli_real_escape_string($con, $property['floor']);
            $size = mysqli_real_escape_string($con, $property['size']);
            $price = mysqli_real_escape_string($con, $property['price']);
            $location = mysqli_real_escape_string($con, $property['location']);
            $city = mysqli_real_escape_string($con, $property['city']);
            $state = mysqli_real_escape_string($con, $property['state']);
            $feature = mysqli_real_escape_string($con, $property['feature']);
            $pimage = mysqli_real_escape_string($con, $property['pimage']);
            $pimage1 = mysqli_real_escape_string($con, $property['pimage1']);
            $pimage2 = mysqli_real_escape_string($con, $property['pimage2']);
            $pimage3 = mysqli_real_escape_string($con, $property['pimage3']);
            $pimage4 = mysqli_real_escape_string($con, $property['pimage4']);
            $uid = mysqli_real_escape_string($con, $property['uid']);
            $status = mysqli_real_escape_string($con, $property['status']);
            $added_date = date('Y-m-d H:i:s');

            $insert_permanent_property = mysqli_query($con, "INSERT INTO permanent_property (title, pcontent, type, bhk, stype, bedroom, bathroom, balcony, kitchen, hall, floor, size, price, location, city, state, feature, pimage, pimage1, pimage2, pimage3, pimage4, uid, status, added_date) 
                                                             VALUES ('$title', '$pcontent', '$type', '$bhk', '$stype', $bedroom, $bathroom, $balcony, $kitchen, $hall, '$floor', $size, $price, '$location', '$city', '$state', '$feature', '$pimage', '$pimage1', '$pimage2', '$pimage3', '$pimage4', $uid, '$status', '$added_date')");
            if ($insert_permanent_property) {
                $msg = "Property committed successfully!";
            } else {
                $msg = "Error: " . mysqli_error($con);
            }
        } else {
            $msg = "Property not found.";
        }
    } else {
        $msg = "Error updating property status: " . mysqli_error($con);
    }

    // Redirect back to propertyview.php with a message
    header("location: propertyview.php?msg=" . urlencode($msg));
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <title>Ventura - Data Tables</title>

    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.png">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">

    <!-- Fontawesome CSS -->
    <link rel="stylesheet" href="assets/css/font-awesome.min.css">

    <!-- Feathericon CSS -->
    <link rel="stylesheet" href="assets/css/feathericon.min.css">

    <!-- Datatables CSS -->
    <link rel="stylesheet" href="assets/plugins/datatables/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="assets/plugins/datatables/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="assets/plugins/datatables/select.bootstrap4.min.css">
    <link rel="stylesheet" href="assets/plugins/datatables/buttons.bootstrap4.min.css">

    <!-- Main CSS -->
    <link rel="stylesheet" href="assets/css/style.css">

    <!--[if lt IE 9]>
        <script src="assets/js/html5shiv.min.js"></script>
        <script src="assets/js/respond.min.js"></script>
    <![endif]-->
</head>

<body>

    <!-- Main Wrapper -->
    <!-- Header -->
    <?php include("header.php"); ?>
    <!-- /Sidebar -->

    <!-- Page Wrapper -->
    <div class="page-wrapper">
        <div class="content container-fluid">

            <!-- Page Header -->
            <div class="page-header">
                <div class="row">
                    <div class="col">
                        <h3 class="page-title">Property</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                            <li class="breadcrumb-item active">Property</li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- /Page Header -->

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">

                            <h4 class="header-title mt-0 mb-4">Property View</h4>
                            <?php
                            if (isset($_GET['msg']))
                                echo '<div class="alert alert-info">' . $_GET['msg'] . '</div>';
                            ?>
                            <table id="datatable-buttons" class="table table-striped dt-responsive nowrap">
                                <thead>
                                    <tr>
                                        <!-- <th>P ID</th> -->
                                        <th>Title</th>
                                        <th>Type</th>
                                        <th>BHK</th>
                                        <th>S/R</th>

                                        <th>Area</th>
                                        <th>Price</th>
                                        <th>Location</th>
                                        <th>Status</th>

                                        
                                        <th>Actions</th>

                                    </tr>
                                </thead>

                                <tbody>
                                    <?php
                                    $query = mysqli_query($con, "SELECT * FROM property");
                                    while ($row = mysqli_fetch_assoc($query)) {
                                    ?>

                                        <tr>
                                            <!-- <td><?php echo $row['pid']; ?></td> -->
                                            <td><?php echo $row['title']; ?></td>
                                            <td><?php echo $row['type']; ?></td>
                                            <td><?php echo $row['bhk']; ?></td>
                                            <td><?php echo $row['stype']; ?></td>

                                            <td><?php echo $row['size']; ?></td>
                                            <td><?php echo $row['price']; ?></td>
                                            <td><?php echo $row['location']; ?></td>
                                            
                                            <td>
                                                <?php
                                                if ($row['committed'] == 1) {
                                                    echo '<span class="btn btn-success disabled">Committed</span>';
                                                } else {
                                                    echo '<a href="propertyview.php?action=commit&id=' . $row['pid'] . '" class="btn btn-primary">Commit</a>';
                                                }
                                                ?>
                                            </td>

                                            
                                            <td>
                                                <a href="propertydelete.php?id=<?php echo $row['pid']; ?>" class="btn btn-danger">Delete</a>
                                            </td>
                                        </tr>
                                    <?php
                                    }
                                    ?>
                                </tbody>
                            </table>

                        </div> <!-- end card body-->
                    </div> <!-- end card -->
                </div><!-- end col-->
            </div>
            <!-- end row-->

        </div>
    </div>
    <!-- /Main Wrapper -->

    <!-- jQuery -->
    <script src="assets/js/jquery-3.2.1.min.js"></script>

    <!-- Bootstrap Core JS -->
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>

    <!-- Slimscroll JS -->
    <script src="assets/plugins/slimscroll/jquery.slimscroll.min.js"></script>

    <!-- Datatables JS -->
    <script src="assets/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="assets/plugins/datatables/dataTables.bootstrap4.min.js"></script>
    <script src="assets/plugins/datatables/dataTables.responsive.min.js"></script>
    <script src="assets/plugins/datatables/responsive.bootstrap4.min.js"></script>

    <!-- Custom JS -->
    <script src="assets/js/script.js"></script>

</body>

</html>
