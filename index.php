<?php 
ini_set('session.cache_limiter','public');
session_cache_limiter(false);
session_start();
include("config.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Real Estate PHP</title>
    <!-- CSS Stylesheets -->
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/bootstrap-slider.css">
    <link rel="stylesheet" type="text/css" href="css/jquery-ui.css">
    <link rel="stylesheet" type="text/css" href="css/layerslider.css">
    <link rel="stylesheet" type="text/css" href="css/color.css" id="color-change">
    <link rel="stylesheet" type="text/css" href="css/owl.carousel.min.css">
    <link rel="stylesheet" type="text/css" href="css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="fonts/flaticon/flaticon.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" href="./chatbot-deployment/standalone-frontend/style.css"> <!-- Include chatbox CSS -->
</head>
<body>
   
    <div id="page-wrapper">
        <div class="row"> 
            <!-- Header -->
            <?php include("include/header.php"); ?>
            <!-- Banner -->
            <div class="overlay-black w-100 slider-banner1 position-relative" style="background-image: url('images/banner/rshmpg.jpg'); background-size: cover; background-position: center center; background-repeat: no-repeat;">
                <div class="container h-100">
                    <div class="row h-100 align-items-center">
                        <div class="col-lg-12">
                            <div class="text-white">
                                <h1 class="mb-4"><span class="text-success">Let us</span><br>Guide you Home</h1>
                                <form method="post" action="propertygrid.php">
                                    <div class="row">
                                        <div class="col-md-6 col-lg-2">
                                            <div class="form-group">
                                                <select class="form-control" name="type">
                                                    <option value="">Select Type</option>
                                                    <option value="apartment">Apartment</option>
                                                    <option value="flat">Flat</option>
                                                    <option value="building">Building</option>
                                                    <option value="house">House</option>
                                                    <option value="villa">Villa</option>
                                                    <option value="office">Office</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-lg-2">
                                            <div class="form-group">
                                                <select class="form-control" name="stype">
                                                    <option value="">Select Status</option>
                                                    <option value="rent">Rent</option>
                                                    <option value="sale">Sale</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-8 col-lg-6">
                                            <div class="form-group">
                                                <input type="text" class="form-control" name="city" placeholder="Enter City" required>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-4 col-lg-2">
                                            <div class="form-group">
                                                <button type="submit" name="filter" class="btn btn-success w-100">Search Property</button>
                                            </div>
                                        </div>
                                        
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Recent Properties -->
            <div class="full-row bg-gray">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <h2 class="text-secondary double-down-line text-center mb-5">Recent Property</h2>
                        </div>
                    </div>
                    <div class="text-box-one">
                        <div class="row">
                        <?php
$query = mysqli_query($con, "SELECT property.*, user.uname,user.utype,user.uimage FROM `property`,`user` WHERE property.uid=user.uid ORDER BY date DESC LIMIT 9");
while($row = mysqli_fetch_array($query)) {
    $status = $row['status'];
    $sold = ($status == 'sold') ? true : false;
?>
                            
                            <div class="col-md-6 col-lg-4">
                                <div class="featured-thumb hover-zoomer mb-4">
                                    <div class="overlay-black overflow-hidden position-relative">
                                        <img src="admin/property/<?php echo $row['18']; ?>" alt="pimage">
                                        <div class="featured bg-success text-white">New</div>
                                        <?php if ($sold) { ?>
                <div class="sale bg-danger text-white text-capitalize"><?php echo $status; ?></div>
            <?php } else { ?>
                <div class="sale bg-success text-white text-capitalize">For <?php echo $row['5']; ?></div>
            <?php } ?>
                                        <div class="price text-primary"><b>₹<?php echo $row['13']; ?> </b><span class="text-white"><?php echo $row['12']; ?> Sqft</span></div>
                                    </div>
                                    <div class="featured-thumb-data shadow-one">
                                        <div class="p-3">
                                            <h5 class="text-secondary hover-text-success mb-2 text-capitalize"><a href="propertydetail.php?pid=<?php echo $row['0']; ?>"><?php echo $row['1']; ?></a></h5>
                                            <span class="location text-capitalize"><i class="fas fa-map-marker-alt text-success"></i> <?php echo $row['14']; ?></span>
                                        </div>
                                        <div class="bg-gray quantity px-4 pt-4">
                                            <ul>
                                                <li><span><?php echo $row['12']; ?></span> Sqft</li>
                                                <li><span><?php echo $row['6']; ?></span> Beds</li>
                                                <li><span><?php echo $row['7']; ?></span> Baths</li>
                                                <li><span><?php echo $row['9']; ?></span> Kitchen</li>
                                                <li><span><?php echo $row['8']; ?></span> Balcony</li>
                                            </ul>
                                        </div>
                                        <div class="p-4 d-inline-block w-100">
                                            <div class="float-left text-capitalize"><i class="fas fa-user text-success mr-1"></i>By : <?php echo $row['uname']; ?></div>
                                            <div class="float-right"><i class="far fa-calendar-alt text-success mr-1"></i> <?php echo date('d-m-Y', strtotime($row['date'])); ?></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Why Choose Us -->
          <!--  <div class="full-row living bg-one overlay-secondary-half" style="background-image: url('images/01.jpg'); background-size: cover; background-position: center center; background-repeat: no-repeat;">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 col-lg-6">
                            <div class="living-list pr-4">
                                <h3 class="pb-4 mb-3 text-white">Why Choose Us</h3>
                                <ul>
                                    <li class="mb-4 text-white d-flex"> 
                                        <i class="flaticon-reward flat-medium float-left d-table mr-4 text-success" aria-hidden="true"></i>
                                        <div class="pl-2">
                                            <h5 class="mb-3">Top Rated</h5>
                                            <p>We would like to sell you the best home....</p>
                                        </div>
                                    </li>
                                    <li class="mb-4 text-white d-flex"> 
                                        <i class="flaticon-real-estate flat-medium float-left d-table mr-4 text-success" aria-hidden="true"></i>
                                        <div class="pl-2">
                                            <h5 class="mb-3">Experience Quality</h5>
                                            <p>We would like to sell you the best home....</p>
                                        </div>
                                    </li>
                                    <li class="mb-4 text-white d-flex"> 
                                        <i class="flaticon-seller flat-medium float-left d-table mr-4 text-success" aria-hidden="true"></i>
                                        <div class="pl-2">
                                            <h5 class="mb-3">Experienced Agents</h5>
                                            <p>We would like to sell you the best home....</p>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>  -->
            <!-- How it work -->
             <!--
            <div class="full-row">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <h2 class="text-secondary double-down-line text-center mb-5">How it works</h2>
                        
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="howitwork-img text-center mb-4">
                                <img src="images/how-it-works-1.png" alt="How It Works 1">
                            </div>
                            <div class="howitwork-text pr-3">
                                <h4 class="mb-3 text-success">Find Your Property</h4>
                                <p></p>We would like to sell you the best home....</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="howitwork-img text-center mb-4">
                                <img src="images/how-it-works-2.png" alt="How It Works 2">
                            </div>
                            <div class="howitwork-text pr-3">
                                <h4 class="mb-3 text-success">Discuss with Agent</h4>
                                <p>We would like to sell you the best home....</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="howitwork-img text-center mb-4">
                                <img src="images/how-it-works-3.png" alt="How It Works 3">
                            </div>
                            <div class="howitwork-text pr-3">
                                <h4 class="mb-3 text-success">Finalize the Deal</h4>
                                <p>We would like to sell you the best home....</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="howitwork-img text-center mb-4">
                                <img src="images/how-it-works-4.png" alt="How It Works 4">
                            </div>
                            <div class="howitwork-text pr-3">
                                <h4 class="mb-3 text-success">Move into Your New Home</h4>
                                <p>We would like to sell you the best home....</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>  
            -->
            <!-- Contact Us -->
            <div class="full-row overlay-secondary bg-gray">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <h2 class="text-center text-secondary mb-5">Contact Us</h2>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <form method="post" action="sendmessage.php">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <input type="text" class="form-control" name="name" placeholder="Your Name" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <input type="email" class="form-control" name="email" placeholder="Your Email" required>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <textarea class="form-control" name="message" placeholder="Your Message" required></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-success w-100">Send Message</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-6">
                            <div class="contact-info">
                                <h4 class="mb-4 text-success">Contact Information</h4>
                                <p><i class="fas fa-map-marker-alt text-success mr-3"></i> Puducherry</p>
                                <p><i class="fas fa-phone-alt text-success mr-3"></i> +91  9025457634</p>
                                <p><i class="fas fa-envelope text-success mr-3"></i> jennifferpaul07@gmail.com</p>
                                <ul class="social-list">
                                    <li><a href="#"><i class="fab fa-facebook-f text-success"></i></a></li>
                                    <li><a href="#"><i class="fab fa-twitter text-success"></i></a></li>
                                    <li><a href="#"><i class="fab fa-linkedin-in text-success"></i></a></li>
                                    <li><a href="#"><i class="fab fa-instagram text-success"></i></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Footer -->
            <?php include("include/footer.php"); ?>
        </div>
    </div>
    <!-- Chatbox -->
    <div class="container">
    <div class="chatbox">
        <div class="chatbox__support">
            <div class="chatbox__header">
                <div class="chatbox__image--header">
                    <img src="https://img.icons8.com/color/48/000000/circled-user-female-skin-type-5--v1.png" alt="Support Agent Image">
                </div>
                <div class="chatbox__content--header">
                    <h4 class="chatbox__heading--header">Chat Support</h4>
                    <p class="chatbox__description--header">Hi. My name is Jenniffer. How can I help you?</p>
                </div>
            </div>
            <div class="chatbox__messages">
                <!-- This is where dynamically added messages will appear -->
            </div>
            <div class="chatbox__footer">
                <input type="text" placeholder="Write a message...">
                <button class="chatbox__send--footer send__button">Send</button>
            </div>
            <div class="chatbox__button" >
                <button>
                    <img src="./chatbot-deployment/standalone-frontend/images/chatbox-icon.svg" alt="Chatbox Toggle Icon">
                </button>
            </div>
        </div>
    </div>
</div>

    <!-- JS Scripts -->

    <script>
     

        

        // Event listener for voice search button
        
    </script>
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/jquery-ui.min.js"></script>
    <script src="js/jquery.color.js"></script>
    <script src="js/bootstrap-slider.min.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <script src="js/jquery.layzr.js"></script>
    <script src="js/velocity.min.js"></script>
    <script src="js/velocity.ui.min.js"></script>
    <script src="js/jquery.mb.YTPlayer.min.js"></script>
    <script src="js/jquery.ajaxchimp.min.js"></script>
    <script src="js/theme.js"></script>
    <!-- Chatbox JavaScript -->
    
    <a href="http://localhost:5000/chatbot" target="_blank" style="position: fixed; bottom: 20px; right: 20px; z-index: 9999;">
        <svg width="36" height="29" viewBox="0 0 36 29" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M28.2857 10.5714C28.2857 4.88616 21.9576 0.285714 14.1429 0.285714C6.32813 0.285714 0 4.88616 0 10.5714C0 13.8259 2.08929 16.7388 5.34375 18.6272C4.66071 20.2946 3.77679 21.0781 2.9933 21.9621C2.77232 22.2232 2.51116 22.4643 2.59152 22.846C2.65179 23.1875 2.93304 23.4286 3.23438 23.4286C3.25446 23.4286 3.27455 23.4286 3.29464 23.4286C3.89732 23.3482 4.47991 23.2478 5.02232 23.1071C7.05134 22.5848 8.93973 21.721 10.6071 20.5357C11.7321 20.7366 12.9174 20.8571 14.1429 20.8571C21.9576 20.8571 28.2857 16.2567 28.2857 10.5714ZM36 15.7143C36 12.3594 33.7902 9.38616 30.3951 7.51786C30.6964 8.50223 30.8571 9.52679 30.8571 10.5714C30.8571 14.1674 29.0089 17.4821 25.654 19.933C22.5402 22.183 18.4621 23.4286 14.1429 23.4286C13.5603 23.4286 12.9576 23.3884 12.375 23.3482C14.8862 24.9955 18.221 26 21.8571 26C23.0826 26 24.2679 25.8795 25.3929 25.6786C27.0603 26.8638 28.9487 27.7277 30.9777 28.25C31.5201 28.3906 32.1027 28.4911 32.7054 28.5714C33.0268 28.6116 33.3281 28.3504 33.4085 27.9888C33.4888 27.6071 33.2277 27.3661 33.0067 27.1049C32.2232 26.221 31.3393 25.4375 30.6563 23.7701C33.9107 21.8817 36 18.9888 36 15.7143Z" fill="#581B98"/>
        </svg>
    </a>
    <script src="./chatbot-deployment/standalone-frontend/app.js"></script>
</body>
</html>
