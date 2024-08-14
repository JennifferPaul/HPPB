<?php
session_start();
require("config.php");

if (!isset($_SESSION['auser'])) {
    header("location:index.php");
    exit();
}
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

    <!-- Main Wrapper -->
    <!-- Header -->
    <?php include("header.php"); ?>

    <!-- Page Wrapper -->
    <div class="page-wrapper">
        <div class="content container-fluid">

            <!-- Page Header -->
            <div class="page-header">
                <div class="row">
                    <div class="col">
                        <h3 class="page-title">User</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                            <li class="breadcrumb-item active">User</li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- /Page Header -->

            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">User List</h4>
                            <?php if (isset($_GET['msg'])) echo $_GET['msg']; ?>
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
                                    <?php
                                    $query = mysqli_query($con, "SELECT * FROM user WHERE utype='user'");
                                    $cnt = 1;
                                    while ($row = mysqli_fetch_assoc($query)) {
                                    ?>
                                        <tr>
                                            <td><?php echo $cnt; ?></td>
                                            <td><?php echo $row['uname']; ?></td>
                                            <td><?php echo $row['uemail']; ?></td>
                                            <td><?php echo $row['uphone']; ?></td>
                                            <td><?php echo $row['utype']; ?></td>
                                            <td><img src="user/<?php echo $row['uimage']; ?>" height="50px" width="50px"></td>
                                            <td>
                                                <a href="userdelete.php?id=<?php echo $row['uid']; ?>">
                                                    <button class="btn btn-danger">Delete</button>
                                                </a>
                                            </td>
                                            <td>
                                                <?php if (isset($row['committed']) && $row['committed'] == 1): ?>
                                                    <button class="btn btn-success" disabled>Committed</button>
                                                <?php else: ?>
                                                    <button class="btn btn-primary" data-href="commit.php?id=<?php echo $row['uid']; ?>" onclick="return handleCommit(this);">Commit</button>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php
                                        $cnt++;
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    
    <!-- Custom JS -->
    <script src="assets/js/script.js"></script>

    <script>
        function handleCommit(button) {
            button.innerHTML = 'Committing...'; // Change button text
            button.disabled = true; // Disable button

            // Perform AJAX call to commit.php here for async handling
            fetch(button.dataset.href)
                .then(response => response.text())
                .then(responseText => {
                    // Handle response here, if needed
                    button.innerHTML = 'Committed'; // Change button text after success
                    button.classList.remove('btn-primary'); // Optionally, remove primary class
                    button.classList.add('btn-success'); // Add success class
                    button.disabled = true; // Ensure button stays disabled
                })
                .catch(error => {
                    console.error('Commit error:', error);
                    button.innerHTML = 'Commit'; // Revert button text on error
                    button.disabled = false; // Re-enable button
                });

            return false; // Prevent default link behavior
        }
    </script>

</body>
</html>

                                                <?php
												$cnt=$cnt+1;
												 
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
		<script src="assets/plugins/datatables/buttons.html5.min.js"></script>
		<script src="assets/plugins/datatables/buttons.flash.min.js"></script>
		<script src="assets/plugins/datatables/buttons.print.min.js"></script>
		
		<!-- Custom JS -->
		<script  src="assets/js/script.js"></script>
		
    </body>
</html>