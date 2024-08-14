<?php 
include("config.php");

$error = "";
$msg = "";

if(isset($_POST['reg'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $pass = $_POST['pass'];
    $utype = $_POST['utype'];
    $agentId = ($_POST['utype'] == 'agent') ? $_POST['agentId'] : null;

    $uimage = $_FILES['uimage']['name'];
    $temp_name1 = $_FILES['uimage']['tmp_name'];
    $pass = sha1($pass); // Using sha1 for password hashing (consider more secure options)

    // Check if email already exists
    $query = "SELECT * FROM user WHERE uemail='$email'";
    $res = mysqli_query($con, $query);
    $num = mysqli_num_rows($res);
    
    if($num > 0) {
        $error = "<p class='alert alert-warning'>Email Id already exists</p>";
    } else {
        // Validate all fields are filled
        if(!empty($name) && !empty($email) && !empty($phone) && !empty($pass) && !empty($uimage)) {
            // Prepare and bind SQL statement
            $stmt = $con->prepare("INSERT INTO user (uname, uemail, uphone, upass, utype, uimage, agentId) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssssi", $name, $email, $phone, $pass, $utype, $uimage, $agentId);

            // Execute the statement
            if($stmt->execute()) {
                $msg = "<p class='alert alert-success'>Registered successfully.</p>";
                move_uploaded_file($temp_name1, "admin/user/$uimage");
            } else {
                $error = "<p class='alert alert-warning'>Registration failed. Please try again.</p>";
            }

            $stmt->close(); // Close the statement
        } else {
            $error = "<p class='alert alert-warning'>Please fill all the fields.</p>";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<link rel="shortcut icon" href="images/favicon.ico">

<!-- Fonts -->
<link href="https://fonts.googleapis.com/css?family=Muli:400,400i,500,600,700&amp;display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Comfortaa:400,700" rel="stylesheet">

<!-- CSS Links -->
<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="css/bootstrap-slider.css">
<link rel="stylesheet" type="text/css" href="css/jquery-ui.css">
<link rel="stylesheet" type="text/css" href="css/layerslider.css">
<link rel="stylesheet" type="text/css" href="css/color.css">
<link rel="stylesheet" type="text/css" href="css/owl.carousel.min.css">
<link rel="stylesheet" type="text/css" href="css/font-awesome.min.css">
<link rel="stylesheet" type="text/css" href="fonts/flaticon/flaticon.css">
<link rel="stylesheet" type="text/css" href="css/style.css">
<link rel="stylesheet" type="text/css" href="css/login.css">

<title>Real Estate PHP</title>
</head>
<body>

<div id="page-wrapper">
    <div class="row">
        <?php include("include/header.php"); ?>
        
        <div class="page-wrappers login-body full-row bg-gray">
            <div class="login-wrapper">
                <div class="container">
                    <div class="loginbox">
                        <div class="login-right">
                            <div class="login-right-wrap">
                                <h1>Register</h1>
                                <p class="account-subtitle">Access to our dashboard</p>
                                <?php echo $error; ?><?php echo $msg; ?>
                                
                                <form method="post" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <input type="text" name="name" class="form-control" placeholder="Your Name*" required>
                                    </div>
                                    <div class="form-group">
                                        <input type="email" name="email" class="form-control" placeholder="Your Email*" required>
                                    </div>
                                    <div class="form-group">
                                        <input type="text" name="phone" class="form-control" placeholder="Your Phone*" maxlength="10" required>
                                    </div>
                                    <div class="form-group">
                                        <input type="password" name="pass" class="form-control" placeholder="Your Password*" required>
                                    </div>

                                    <div class="form-check-inline">
                                        <label class="form-check-label">
                                            <input type="radio" class="form-check-input" name="utype" value="user" checked>User
                                        </label>
                                    </div>
                                    <div class="form-check-inline">
                                        <label class="form-check-label">
                                            <input type="radio" class="form-check-input" name="utype" value="agent"> Agent
                                        </label>
                                    </div>
                                    

                                    <div class="form-group">
                                        <label for="agent">Choose an agent:</label>
                                        <select name="agentId" id="agent" class="form-control">
                                            <option value="">Select an agent</option>
                                            <?php
                                            // Fetch agents from the database
                                            $query = "SELECT uid, uname FROM user WHERE utype = 'agent'";
                                            $result = mysqli_query($con, $query);
                                            while ($row = mysqli_fetch_assoc($result)) {
                                                echo "<option value='{$row['uid']}'>{$row['uname']}</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-form-label"><b>User Image</b></label>
                                        <input class="form-control" name="uimage" type="file" required>
                                    </div>
                                    
                                    <button class="btn btn-success" name="reg" value="Register" type="submit">Register</button>
                                </form>
                                
                                <div class="login-or">
                                    <span class="or-line"></span>
                                    <span class="span-or">or</span>
                                </div>
                                
                                <div class="text-center dont-have">Already have an account? <a href="login.php">Login</a></div>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <?php include("include/footer.php"); ?>
        
        <a href="#" class="bg-secondary text-white hover-text-secondary" id="scroll"><i class="fas fa-angle-up"></i></a>
    </div>
</div>

<script src="js/jquery.min.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/jquery-ui.js"></script>
<script src="js/layerslider.js"></script>
<script src="js/jquery.jscrollpane.min.js"></script>
<script src="js/jquery.countdown.min.js"></script>
<script src="js/jquery.fancybox.min.js"></script>
<script src="js/jquery.magnific-popup.min.js"></script>
<script src="js/price_slider.js"></script>
<script src="js/micromodal.js"></script>
<script src="js/jquery.slicknav.js"></script>
<script src="js/lightbox.js"></script>
<script src="js/owl.carousel.min.js"></script>
<script src="js/jquery.counterup.min.js"></script>
<script src="js/jquery.waypoints.min.js"></script>
<script src="js/slick.min.js"></script>
<script src="js/jquery.filterizr.min.js"></script>
<script src="js/jquery.mCustomScrollbar.concat.min.js"></script>
<script src="js/bootstrap-slider.min.js"></script>
<script src="js/tmpl.js"></script>
<script src="js/countdown.js"></script>
<script src="js/mousewheel.js"></script>
<script src="js/wow.js"></script>
<script src="js/main.js"></script>
<script src="js/custom.js"></script>

</body>
</html>
