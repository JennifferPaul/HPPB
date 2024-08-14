<?php
session_start();
require("config.php");

// Redirect to login if not authenticated
if (!isset($_SESSION['auser'])) {
    header("location:index.php");
    exit();
}

// Handle Commit and Delete Actions
if (isset($_POST['commit_agent'])) {
    $agent_id = $_POST['agent_id'];

    // Fetch agent data
    $query = mysqli_query($con, "SELECT * FROM user WHERE uid = '$agent_id'");
    $agent = mysqli_fetch_assoc($query);

    if ($agent) {
        // Check if agent already exists in permanent_agent table
        $check_query = mysqli_query($con, "SELECT * FROM permanent_agent WHERE uid = '$agent_id'");
        $existing_agent = mysqli_fetch_assoc($check_query);

        if ($existing_agent) {
            // Update existing record in permanent_agent table
            $update_stmt = $con->prepare("UPDATE permanent_agent SET uname = ?, uemail = ?, uphone = ?, upass = ?, utype = ?, uimage = ? WHERE uid = ?");
            $update_stmt->bind_param("ssssssi", $agent['uname'], $agent['uemail'], $agent['uphone'], $agent['upass'], $agent['utype'], $agent['uimage'], $agent_id);
            $update_result = $update_stmt->execute();

            if ($update_result) {
                // Update user table to set committed flag
                $update_user_stmt = mysqli_query($con, "UPDATE user SET committed = 1 WHERE uid = '$agent_id'");

                if ($update_user_stmt) {
                    $msg = "<p class='alert alert-success'>Agent Updated Successfully</p>";
                } else {
                    $msg = "<p class='alert alert-danger'>Error updating user committed status</p>";
                }
            } else {
                $msg = "<p class='alert alert-danger'>Error updating existing agent record: " . $con->error . "</p>";
            }
        } else {
            // Insert new record into permanent_agent table
            $insert_stmt = $con->prepare("INSERT INTO permanent_agent (uid, uname, uemail, uphone, upass, utype, uimage) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $insert_stmt->bind_param("issssss", $agent['uid'], $agent['uname'], $agent['uemail'], $agent['uphone'], $agent['upass'], $agent['utype'], $agent['uimage']);
            $insert_result = $insert_stmt->execute();

            if ($insert_result) {
                // Update user table to set committed flag
                $update_user_stmt = mysqli_query($con, "UPDATE user SET committed = 1 WHERE uid = '$agent_id'");

                if ($update_user_stmt) {
                    $msg = "<p class='alert alert-success'>Agent Committed Successfully</p>";
                } else {
                    $msg = "<p class='alert alert-danger'>Error updating user committed status</p>";
                }
            } else {
                $msg = "<p class='alert alert-danger'>Error inserting into permanent_agent table: " . $con->error . "</p>";
            }
        }
    } else {
        $msg = "<p class='alert alert-danger'>Agent not found</p>";
    }
} elseif (isset($_POST['delete_agent'])) {
    $agent_id = $_POST['agent_id'];

    // Delete agent from user table
    $delete_user_stmt = $con->prepare("DELETE FROM user WHERE uid = ?");
    $delete_user_stmt->bind_param("i", $agent_id);
    $delete_user_result = $delete_user_stmt->execute();

    if ($delete_user_result) {
        // Delete agent from permanent_agent table
        $delete_permanent_stmt = $con->prepare("DELETE FROM permanent_agent WHERE uid = ?");
        $delete_permanent_stmt->bind_param("i", $agent_id);
        $delete_permanent_result = $delete_permanent_stmt->execute();

        if ($delete_permanent_result) {
            $msg = "<p class='alert alert-success'>Agent Deleted Successfully</p>";
        } else {
            $msg = "<p class='alert alert-danger'>Error deleting agent from permanent_agent table: " . $delete_permanent_stmt->error . "</p>";
        }
    } else {
        $msg = "<p class='alert alert-danger'>Error deleting agent from user table: " . $delete_user_stmt->error . "</p>";
    }
}

// Fetch agents from user table
$query = mysqli_query($con, "SELECT * FROM user WHERE utype='agent'");
$cnt = 1;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <title>LM Homes | Admin</title>

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
</head>

<body>
    <?php include("header.php"); ?>
    <!-- Main Wrapper -->
    <div class="page-wrapper">
        <div class="content container-fluid">

            <!-- Page Header -->
            <div class="page-header">
                <div class="row">
                    <div class="col">
                        <h3 class="page-title">Agent</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                            <li class="breadcrumb-item active">Agent</li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- /Page Header -->

            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Agent List</h4>
                            <?php if (isset($msg)) echo $msg; ?>
                        </div>
                        <div class="card-body">
                            <table id="basic-datatable" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Contact</th>
                                        <th>Utype</th>
                                        <th>Image</th>
                                        <th>Action</th>
                                        <th>Commit</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($row = mysqli_fetch_assoc($query)) : ?>
                                        <tr>
                                            <td><?php echo $cnt; ?></td>
                                            <td><?php echo $row['uname']; ?></td>
                                            <td><?php echo $row['uemail']; ?></td>
                                            <td><?php echo $row['uphone']; ?></td>
                                            <td><?php echo $row['utype']; ?></td>
                                            <td><img src="user/<?php echo $row['uimage']; ?>" height="50px" width="50px"></td>
                                            <td>
                                                <form method="post">
                                                    <input type="hidden" name="agent_id" value="<?php echo $row['uid']; ?>">
                                                    <button type="submit" name="delete_agent" class="btn btn-danger">Delete</button>
                                                </form>
                                            </td>
                                            <td>
                                                <?php if ($row['committed'] == 1) : ?>
                                                    <button class="btn btn-success" disabled>Committed</button>
                                                <?php else : ?>
                                                    <form method="post">
                                                        <input type="hidden" name="agent_id" value="<?php echo $row['uid']; ?>">
                                                        <button type="submit" name="commit_agent" class="btn btn-primary">Commit</button>
                                                    </form>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php
                                        $cnt++;
                                    endwhile;
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

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
    <script src="assets/plugins/datatables/dataTables.select.min.js"></script>
    <script src="assets/plugins/datatables/dataTables.buttons.min.js"></script>
    <script src="assets/plugins/datatables/buttons.bootstrap4.min.js"></script>
    <script src="assets/js/init/datatables.init.js"></script>

    <!-- Custom JS -->
    <script src="assets/js/app.js"></script>

</body>

</html>
