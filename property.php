<?php 
ini_set('session.cache_limiter','public');
session_cache_limiter(false);
session_start();
include("config.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Real Estate PHP</title>

    <!-- Required meta tags -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="Real Estate PHP">
    <meta name="keywords" content="">
    <meta name="author" content="Unicoder">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Muli:400,400i,500,600,700&amp;display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Comfortaa:400,700" rel="stylesheet">

    <!-- CSS Links -->
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/bootstrap-slider.css">
    <link rel="stylesheet" type="text/css" href="css/jquery-ui.css">
    <link rel="stylesheet" type="text/css" href="css/color.css" id="color-change">
    <link rel="stylesheet" type="text/css" href="css/owl.carousel.min.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>

<!-- Weather Information Section -->
<div class="weather-container">
    <h2>Current Weather</h2>
    <p id="temperature"></p>
    <p id="weather-description"></p>
</div>

<!-- Page Content -->
<div id="page-wrapper">
    <div class="row"> 
        <!-- Header -->
        <?php include("include/header.php"); ?>
        
        <!-- Property Grid -->
        <div class="full-row">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8">
                        <div class="row">
                            <?php 
                            $query = mysqli_query($con, "SELECT property.*, user.uname,user.utype,user.uimage FROM `property`,`user` WHERE property.uid=user.uid");
                            while($row = mysqli_fetch_array($query)) {
                                $status = $row['status'];
                                $statusLabel = $status == 'sold' ? 'Sold' : 'For ' . $row['5'];
                                $statusClass = $status == 'sold' ? 'bg-danger' : 'bg-success';
                            ?>
                            <div class="col-md-6">
                                <div class="featured-thumb hover-zoomer mb-4">
                                    <div class="overlay-black overflow-hidden position-relative"> 
                                        <img src="admin/property/<?php echo $row['18'];?>" alt="pimage">
                                        <div class="sale <?php echo $statusClass; ?> text-white"><?php echo $statusLabel; ?></div>
                                        <div class="price text-primary text-capitalize">₹<?php echo $row['13'];?> <span class="text-white"><?php echo $row['12'];?> Sqft</span></div>
                                    </div>
                                    <div class="featured-thumb-data shadow-one">
                                        <div class="p-4">
                                            <h5 class="text-secondary hover-text-success mb-2 text-capitalize"><a href="propertydetail.php?pid=<?php echo $row['0'];?>"><?php echo $row['1'];?></a></h5>
                                            <span class="location text-capitalize"><i class="fas fa-map-marker-alt text-success"></i> <?php echo $row['14'];?></span>
                                        </div>
                                        <div class="px-4 pb-4 d-inline-block w-100">
                                            <div class="float-left text-capitalize"><i class="fas fa-user text-success mr-1"></i>By : <?php echo $row['uname'];?></div>
                                            <div class="float-right"><i class="far fa-calendar-alt text-success mr-1"></i> <?php echo date('d-m-Y', strtotime($row['date']));?></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <!-- Instalment Calculator -->
                        <div class="sidebar-widget">
                            <h4 class="double-down-line-left text-secondary position-relative pb-4 my-4">Instalment Calculator</h4>
                            <form class="d-inline-block w-100" action="calc.php" method="post">
                                <label class="sr-only">Property Amount</label>
                                <div class="input-group mb-2 mr-sm-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">Rs. </div>
                                    </div>
                                    <input type="text" class="form-control" name="amount" placeholder="Property Price">
                                </div>
                                <label class="sr-only">Month</label>
                                <div class="input-group mb-2 mr-sm-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="far fa-calendar-alt"></i></div>
                                    </div>
                                    <input type="text" class="form-control" name="month" placeholder="Duration Year">
                                </div>
                                <label class="sr-only">Interest Rate</label>
                                <div class="input-group mb-2 mr-sm-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">%</div>
                                    </div>
                                    <input type="text" class="form-control" name="interest" placeholder="Interest Rate">
                                </div>
                                <button type="submit" value="submit" name="calc" class="btn btn-danger mt-4">Calculate Instalment</button>
                            </form>
                        </div>

                        <!-- Featured Property -->
                        <h4 class="double-down-line-left text-secondary position-relative pb-4 mb-4 mt-5">Featured Property</h4>
                        <ul class="property_list_widget">
                            <?php 
                            $query = mysqli_query($con, "SELECT * FROM `property` WHERE isFeatured = 1 ORDER BY date DESC LIMIT 3");
                            while($row = mysqli_fetch_array($query)) {
                                $status = $row['status'];
                                $statusLabel = $status == 'sold' ? 'Sold' : 'For ' . $row['5'];
                                $statusClass = $status == 'sold' ? 'bg-danger' : 'bg-success';
                            ?>
                            <li>
                                <img src="admin/property/<?php echo $row['18'];?>" alt="pimage">
                                <h6 class="text-secondary hover-text-success text-capitalize"><a href="propertydetail.php?pid=<?php echo $row['0'];?>"><?php echo $row['1'];?></a></h6>
                                <span class="font-14"><i class="fas fa-map-marker-alt icon-success"></i> <?php echo $row['14'];?></span>
                                <div class="price text-primary">$<?php echo $row['13'];?></div>
                                <div class="sale <?php echo $statusClass; ?> text-white"><?php echo $statusLabel; ?></div>
                            </li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Footer -->
        <?php include("include/footer.php"); ?>
        
        <!-- Scroll to top -->
        <a href="#" class="bg-secondary text-white hover-text-success" id="scroll"><i class="fas fa-angle-up"></i></a>
        <!-- Scroll to top end -->
    </div>
</div>

<!-- Wrapper End -->
<!-- JavaScript Links -->
<script src="js/jquery.min.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/jquery-ui.js"></script>
<script src="js/layerslider.js"></script>
<script src="js/jquery.cookie.js"></script>
<script src="js/custom.js"></script>

<!-- JavaScript for Weather -->
<script>
        function fetchWeather() {
            const apiUrl = 'https://weather.visualcrossing.com/VisualCrossingWebServices/rest/services/timeline/Kalapet?unitGroup=metric&key=CNPR2AKSR9QSCYX35VVTUK7RH&contentType=json';

            fetch(apiUrl)
                .then(response => response.json())
                .then(data => {
                    const temperature = data.currentConditions.temp;
                    const weatherDescription = data.currentConditions.conditions;

                    document.getElementById('temperature').textContent = `Temperature: ${temperature}°C`;
                    document.getElementById('weather-description').textContent = `Weather: ${weatherDescription}`;
                })
                .catch(error => {
                    console.error('Error fetching weather data:', error);
                });
        }

        // Call fetchWeather() function when the page loads
        window.onload = fetchWeather;
    </script>


</body>
</html>
