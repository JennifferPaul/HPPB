<?php
ini_set('session.cache_limiter','public');
session_cache_limiter(false);
session_start();
include("config.php");

// Retrieve the property ID parameter from the URL
$pid = $_GET['pid']; // Assuming 'pid' is passed as a parameter in the URL

// Query to retrieve property details based on property ID
$query = "SELECT * FROM property WHERE pid = ?";
$stmt = $con->prepare($query);
$stmt->bind_param('i', $pid);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    // Now you can use $row to access property details
    $propertyState = $row['city']; // Assuming 'state' is the column name in your property table
} else {
    echo "Property not found.";
}

// Passing the state value to JavaScript later
echo "<script>const state = '" . $propertyState . "';</script>";
$query = "SELECT uid, uname FROM user WHERE utype = 'agent'";
$result = mysqli_query($con, $query);

$agents = [];
while ($row = mysqli_fetch_assoc($result)) {
    $agents[] = $row;
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
<!-- Required meta tags -->
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

<!-- Meta Tags --><!-- FOR MORE PROJECTS visit: codeastro.com -->
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="description" content="Real Estate PHP">
<meta name="keywords" content="">
<meta name="author" content="Unicoder">
<link rel="shortcut icon" href="images/favicon.ico">

<!--	Fonts
	========================================================-->
<link href="https://fonts.googleapis.com/css?family=Muli:400,400i,500,600,700&amp;display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Comfortaa:400,700" rel="stylesheet">

<!--	Css Link
	========================================================-->
<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="css/bootstrap-slider.css">
<link rel="stylesheet" type="text/css" href="css/jquery-ui.css">
<link rel="stylesheet" type="text/css" href="css/layerslider.css">
<link rel="stylesheet" type="text/css" href="css/color.css" id="color-change">
<link rel="stylesheet" type="text/css" href="css/owl.carousel.min.css">
<link rel="stylesheet" type="text/css" href="css/font-awesome.min.css">
<link rel="stylesheet" type="text/css" href="fonts/flaticon/flaticon.css">
<link rel="stylesheet" type="text/css" href="css/style.css">

<!--	Title
	=========================================================-->
<title>Real Estate PHP</title>
</head>
<body>

<!--	Page Loader
=============================================================
<div class="page-loader position-fixed z-index-9999 w-100 bg-white vh-100">
	<div class="d-flex justify-content-center y-middle position-relative">
	  <div class="spinner-border" role="status">
		<span class="sr-only">Loading...</span>
	  </div>
	</div>
</div>
--> 


<div id="page-wrapper">
    <div class="row"> 
        <!--	Header start  -->
		<?php include("include/header.php");?>
        <!--	Header end  -->
        
        <!--	Banner   --->
        <div class="banner-full-row page-banner" style="background-image:url('images/breadcromb.jpg');">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <h2 class="page-name float-left text-white text-uppercase mt-1 mb-0"><b>Property Detail</b></h2>
                    </div>
                    <div class="col-md-6">
                        <nav aria-label="breadcrumb" class="float-left float-md-right">
                            <ol class="breadcrumb bg-transparent m-0 p-0">
                                <li class="breadcrumb-item text-white"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active">Property Detail</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
         <!--	Banner   --->

		
         <div class="full-row">
    <div class="container">
        <div class="row"><!-- FOR MORE PROJECTS visit: codeastro.com -->
            <?php
            $id = $_REQUEST['pid'];
            $query = mysqli_query($con, "SELECT property.*, user.* FROM `property`,`user` WHERE property.uid=user.uid and pid='$id'");
            while ($row = mysqli_fetch_array($query)) {
            ?>
            <div class="col-lg-8">
                <div class="row">
                    <div class="col-md-12">
                        <div id="single-property" style="width:100%; height:700px; margin:30px auto 50px;"> 
                            <!-- Slides -->
                            <div class="ls-slide" data-ls="duration:7500; transition2d:5; kenburnszoom:in; kenburnsscale:1.2;"> <img width="1920" height="1080" src="admin/property/<?php echo $row['18'];?>" class="ls-bg" alt="" /> </div>
                            <div class="ls-slide" data-ls="duration:7500; transition2d:5; kenburnszoom:in; kenburnsscale:1.2;"> <img width="1920" height="1080" src="admin/property/<?php echo $row['19'];?>" class="ls-bg" alt="" /> </div>
                            <div class="ls-slide" data-ls="duration:7500; transition2d:5; kenburnszoom:in; kenburnsscale:1.2;"> <img width="1920" height="1080" src="admin/property/<?php echo $row['20'];?>" class="ls-bg" alt="" /> </div>
                            <div class="ls-slide" data-ls="duration:7500; transition2d:5; kenburnszoom:in; kenburnsscale:1.2;"> <img width="1920" height="1080" src="admin/property/<?php echo $row['21'];?>" class="ls-bg" alt="" /> </div>
                            <div class="ls-slide" data-ls="duration:7500; transition2d:5; kenburnszoom:in; kenburnsscale:1.2;"> <img width="1920" height="1080" src="admin/property/<?php echo $row['22'];?>" class="ls-bg" alt="" /> </div>
                        </div>
                    </div>
                </div><!-- FOR MORE PROJECTS visit: codeastro.com -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="bg-success d-table px-3 py-2 rounded text-white text-capitalize">For <?php echo $row['5'];?></div>
                        <h5 class="mt-2 text-secondary text-capitalize"><?php echo $row['1'];?></h5>
                        <span class="mb-sm-20 d-block text-capitalize"><i class="fas fa-map-marker-alt text-success font-12"></i> &nbsp;<?php echo $row['14'];?></span>
                    </div>
                    <div class="col-md-6">
                        <div class="text-success text-left h5 my-2 text-md-right">₹<?php echo $row['13']; ?></div>
                        <div class="text-left text-md-right">Price</div>
                    </div>
                    <div class="text-md-right col-md-12">
                        <a href="booking.php?property_id=<?php echo $row['pid']; ?>" class="btn btn-primary">Book</a>
                    </div>

                </div>
                
                <div class="risk-factor-buttons">
                    <button onclick="predictFlood()" class="btn btn-risk-flood">Predict Flood</button>
                    <div id="flood_prediction"></div>
                    <button onclick="fetchAirQualityData()" class="btn btn-risk-air">Air Quality</button>
                    <div id="airQualityData"></div>
                    
                    <button onclick="predictSoilMoisture()" class="btn btn-risk-soil">Soil Factor</button>
                    <div id="soilMoisturePrediction"></div>
                    <button onclick="predictSevereCyclones()" class="btn btn-risk-cyclone">Cyclone Predict</button>
                    <div id="severeCyclonePrediction"></div>
                </div>
                <div class="property-details">
                    <div class="bg-gray property-quantity px-4 pt-4 w-100">
                        <ul>
                            <li><span class="text-secondary"><?php echo $row['12'];?></span> Sqft</li>
                            <li><span class="text-secondary"><?php echo $row['6'];?></span> Bedroom</li>
                            <li><span class="text-secondary"><?php echo $row['7'];?></span> Bathroom</li>
                            <li><span class="text-secondary"><?php echo $row['8'];?></span> Balcony</li>
                            <li><span class="text-secondary"><?php echo $row['10'];?></span> Hall</li>
                            <li><span class="text-secondary"><?php echo $row['9'];?></span> Kitchen</li>
                        </ul>
                    </div>
                    <!-- Where you want to display the flood prediction -->
                    <div id="risk-factor-predictions"></div>
                    <h4 class="text-secondary my-4">Description</h4>
                    <p><?php echo $row['2'];?></p>
                    
                    <h5 class="mt-5 mb-4 text-secondary">Property Summary</h5>
                    <div class="table-striped font-14 pb-2">
                        <table class="w-100"><!-- FOR MORE PROJECTS visit: codeastro.com -->
                            <tbody>
                                <tr>
                                    <td>BHK :</td>
                                    <td class="text-capitalize"><?php echo $row['4'];?></td>
                                    <td>Property Type :</td>
                                    <td class="text-capitalize"><?php echo $row['3'];?></td>
                                </tr>
                                <tr>
                                    <td>Floor :</td>
                                    <td class="text-capitalize"><?php echo $row['11'];?></td>
                                    <td>Total Floor :</td>
                                    <td class="text-capitalize"><?php echo $row['28'];?></td>
                                </tr>
                                <tr>
                                    <td>City :</td>
                                    <td class="text-capitalize"><?php echo $row['15'];?></td>
                                    <td>State :</td>
                                    <td class="text-capitalize"><?php echo $row['16'];?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    
                    <h5 class="mt-5 mb-4 text-secondary">Features</h5>
                    <div class="row">
                        <?php echo $row['17'];?>
                    </div>
                    
                    <h5 class="mt-5 mb-4 text-secondary">Floor Plans</h5>
                    <div class="accordion" id="accordionExample">
                        <button class="bg-gray hover-bg-success hover-text-white text-ordinary py-3 px-4 mb-1 w-100 text-left rounded position-relative" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne"> Floor Plans </button>
                        <div id="collapseOne" class="collapse show p-4" aria-labelledby="headingOne" data-parent="#accordionExample">
                            <img src="admin/property/<?php echo $row['25'];?>" alt="Not Available"> </div>
                        <button class="bg-gray hover-bg-success hover-text-white text-ordinary py-3 px-4 mb-1 w-100 text-left rounded position-relative collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">Basement Floor</button>
                        <div id="collapseTwo" class="collapse p-4" aria-labelledby="headingTwo" data-parent="#accordionExample">
                            <img src="admin/property/<?php echo $row['26'];?>" alt="Not Available"> </div>
                        <button class="bg-gray hover-bg-success hover-text-white text-ordinary py-3 px-4 mb-1 w-100 text-left rounded position-relative collapsed" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">Ground Floor</button>
                        <div id="collapseThree" class="collapse p-4" aria-labelledby="headingThree" data-parent="#accordionExample">
                            <img src="admin/property/<?php echo $row['27'];?>" alt="Not Available"> </div>
                    </div>

                    <h5 class="mt-5 mb-4 text-secondary double-down-line-left position-relative">Contact Agent</h5>
<div class="agent-contact pt-60">
    <div class="row">
        <div class="col-sm-4 col-lg-3"> 
            <!-- Ensure $row['uimage'] contains the correct path or filename -->
            <img src="admin/user/<?php echo $row['uimage']; ?>" alt="" height="200" width="170"> 
        </div>
        <div class="col-sm-8 col-lg-9">
            <div class="agent-data text-ordinary mt-sm-20">
                <h6 class="text-success text-capitalize" id="selectedAgentName"><?php echo $agents[0]['uname']; // Display initial agent name ?></h6>
                
                
                <div class="mt-3 text-secondary hover-text-success">
                    <ul>
                        <li class="float-left mr-3"><a href="#"><i class="fab fa-facebook-f"></i></a></li>
                        <li class="float-left mr-3"><a href="#"><i class="fab fa-twitter"></i></a></li>
                        <li class="float-left mr-3"><a href="#"><i class="fab fa-google-plus-g"></i></a></li>
                        <li class="float-left mr-3"><a href="#"><i class="fab fa-linkedin-in"></i></a></li>
                        <li class="float-left mr-3"><a href="#"><i class="fas fa-rss"></i></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Agent selection dropdown -->
    <div class="row mt-4">
        <div class="col-12">
            <form id="agentForm" action="process_agent_selection.php" method="post"> <!-- Replace with your actual processing file -->
                <label for="agentSelect" class="form-label">Select an Agent</label>
                <select class="form-select" id="agentSelect" name="agentSelect">
                    <?php foreach ($agents as $agent) : ?>
                        <option value="<?php echo $agent['uname']; ?>"><?php echo $agent['uname']; ?></option>
                    <?php endforeach; ?>
                </select>
                <button type="submit" class="btn btn-primary mt-3">Select Agent</button>
            </form>
        </div>
    </div>
</div>

<script>
    document.getElementById('agentForm').addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent form submission
        var selectedAgent = document.getElementById('agentSelect').value;
        document.getElementById('selectedAgentName').innerText = selectedAgent; // Update selected agent name on UI
    });
</script>




                </div>
            </div>
            <?php } ?>
        </div>
    </div>
</div>
<style>
    .risk-factor-buttons {
        margin-top: 20px;
        display: flex;
        flex-direction: column; /* Display buttons vertically */
        
    }

    .btn-risk-flood,
    .btn-risk-air,
    .btn-risk-soil,
    .btn-risk-cyclone {
        background-color: #FF5733;
        color: white;
        border: none;
        padding: 10px 20px;
        cursor: pointer;
        margin-bottom: 10px; /* Add margin between buttons */
        width: 200px; /* Set width of buttons */
        text-align: center; /* Center align text */
    }

    .btn-risk-air {
        background-color: #45AAB1;
    }

    .btn-risk-soil {
        background-color: #7EAB34;
    }

    .btn-risk-cyclone {
        background-color: #E388D2;
    }
    
</style>

     		
					
					
                    <div class="col-lg-4">
                        <!-- <h4 class="double-down-line-left text-secondary position-relative pb-4 mb-4 mt-md-50">Send Message</h4>
                        <form method="post" action="#">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <input type="text" class="form-control" placeholder="Enter Name">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <input type="text" class="form-control" placeholder="Enter Email">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <input type="text" class="form-control" placeholder="Enter Phone">
                                    </div>
                                </div>
								<div class="col-md-12">
                                    <div class="form-group">
										<textarea class="form-control" placeholder="Enter Message"></textarea>
                                    </div>
                                </div>
								
                                <div class="col-md-12">
                                    <div class="form-group mt-4">
                                        <button type="submit" class="btn btn-success w-100">Search Property</button>
                                    </div>
                                </div>
                            </div>
                        </form> -->
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
                            <button type="submit" value="submit" name="calc" class="btn btn-danger mt-4">Calclute Instalment</button>
                        </form>
                        <h4 class="double-down-line-left text-secondary position-relative pb-4 mb-4 mt-5">Featured Property</h4>
                        <ul class="property_list_widget">
							
                            <?php 
                            $query=mysqli_query($con,"SELECT * FROM `property` WHERE isFeatured = 1 ORDER BY date DESC LIMIT 3");
                                    while($row=mysqli_fetch_array($query))
                                    {
                            ?>
                            <li> <img src="admin/property/<?php echo $row['18'];?>" alt="pimage">
                                <h6 class="text-secondary hover-text-success text-capitalize"><a href="propertydetail.php?pid=<?php echo $row['0'];?>"><?php echo $row['1'];?></a></h6>
                                <span class="font-14"><i class="fas fa-map-marker-alt icon-success icon-small"></i> <?php echo $row['14'];?></span>
                                
                            </li>
                            <?php } ?>

                        </ul>

                        <div class="sidebar-widget mt-5">
                            <h4 class="double-down-line-left text-secondary position-relative pb-4 mb-4">Recently Added Property</h4>
                            <ul class="property_list_widget">
							
								<?php 
								$query=mysqli_query($con,"SELECT * FROM `property` ORDER BY date DESC LIMIT 7");
										while($row=mysqli_fetch_array($query))
										{
								?>
                                <li> <img src="admin/property/<?php echo $row['18'];?>" alt="pimage">
                                    <h6 class="text-secondary hover-text-success text-capitalize"><a href="propertydetail.php?pid=<?php echo $row['0'];?>"><?php echo $row['1'];?></a></h6>
                                    <span class="font-14"><i class="fas fa-map-marker-alt icon-success icon-small"></i> <?php echo $row['14'];?></span>
                                    
                                </li>
                                <?php } ?>

                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

         <!--	Footer   start-->
		<?php include("include/footer.php");?>
		<!--	Footer   start-->
        
        
        <!-- Scroll to top --> 
        <a href="#" class="bg-secondary text-white hover-text-secondary" id="scroll"><i class="fas fa-angle-up"></i></a> 
        <!-- End Scroll To top --> 
    </div>
</div>
<!-- Wrapper End --> 

<!--	Js Link
============================================================--> 
<script src="js/jquery.min.js"></script> 
<!--jQuery Layer Slider --> 

<script src="js/greensock.js"></script> 
<script src="js/layerslider.transitions.js"></script> 
<script src="js/layerslider.kreaturamedia.jquery.js"></script> 
<!--jQuery Layer Slider --> 
<script src="js/popper.min.js"></script> 
<script src="js/bootstrap.min.js"></script> 
<script src="js/owl.carousel.min.js"></script> 
<script src="js/tmpl.js"></script> 
<script src="js/jquery.dependClass-0.1.js"></script> 
<script src="js/draggable-0.1.js"></script> 
<script src="js/jquery.slider.js"></script> 
<script src="js/wow.js"></script> 
<script src="js/custom.js"></script> 

</body>

</html>
<!-- JavaScript for fetching flood predictions -->
<script>
// Function to predict flood
function predictFlood() {
    const state = '<?php echo $propertyState; ?>'; // Ensure using the correct PHP variable
    const data = { state: state };
    const apiUrl = 'http://127.0.0.1:5000/predict_flood';

    fetch(apiUrl, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        console.log('Flood Prediction:', data);
        const floodPredictionElement = document.getElementById('flood_prediction');
        if (floodPredictionElement) {
            let predictionPercentage = data.prediction;
            // Introduce random variation
            const randomFactor = Math.random() * 0.2 + 0.9; // Random number between 0.9 and 1.1
            predictionPercentage *= randomFactor;
            predictionPercentage = Math.abs(predictionPercentage);
            if (predictionPercentage <= 1) {
                predictionPercentage = (predictionPercentage * 100).toFixed(2);
            }
            floodPredictionElement.innerHTML = `<h5>Flood Prediction for ${state}:</h5><p>${predictionPercentage}% chance of flood this year</p>`;
        }
    })
    .catch(error => {
        console.error('Error predicting flood:', error);
        // Handle errors
    });
}


// Function to fetch air quality data
// Function to fetch air quality data
function fetchAirQualityData() {
    const state = '<?php echo $propertyState; ?>'; // Ensure using the correct PHP variable
    const data = { state: state };
    const apiUrlPollution = 'http://127.0.0.1:5000/predict_pollution';

    fetch(apiUrlPollution, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ 'city': state })
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        console.log('Air Quality Data:', data);
        const airQualityDataElement = document.getElementById('airQualityData');
        if (airQualityDataElement) {
            airQualityDataElement.innerHTML = `
                <p>City: ${data.city}</p>
                <p>Average Pollution: ${data.average_pollution}</p>
                <p>High Pollution Days: ${data.high_pollution_days}</p>
                <p>Moderate Pollution Days: ${data.moderate_pollution_days}</p>
                <p>Low Pollution Days: ${data.low_pollution_days}</p>
            `;
        } else {
            console.error('Element with id "airQualityData" not found.');
        }
    })
    .catch(error => {
        console.error('Error fetching air quality data:', error);
        // Handle errors gracefully
    });
}




// Function to predict soil moisture
function predictSoilMoisture() {
    const district = '<?php echo $propertyState; ?>'; // Ensure using the correct PHP variable
    const apiUrlSoil = 'http://127.0.0.1:5000/predict_soil_moisture';

    fetch(apiUrlSoil, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ 'district': district })
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        console.log('Predicted soil moisture:', data);
        const soilMoisturePredictionElement = document.getElementById('soilMoisturePrediction');
        
        // Assuming 'data' contains the predicted soil moisture object
        const predictedMoisture = data.predicted_moisture_percentage;
        
        // Display in the UI
        soilMoisturePredictionElement.innerHTML = `
            <p>Predicted soil moisture for ${district}: ${predictedMoisture}%</p>
        `;
    })
    .catch(error => {
        console.error('Error predicting soil moisture:', error);
        const soilMoisturePredictionElement = document.getElementById('soilMoisturePrediction');
        soilMoisturePredictionElement.innerHTML = `<p>Error predicting soil moisture. Please try again later.</p>`;
    });
}


// Function to predict severe cyclones
function predictSevereCyclones() {
    const state = '<?php echo $propertyState; ?>'; // Ensure using the correct PHP variable
    const apiUrlCyclones = 'http://127.0.0.1:5000/predict_severe_cyclones';

    fetch(apiUrlCyclones, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ 'Districts': state })
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        console.log('Predicted severe cyclones:', data);
        const severeCyclonePredictionElement = document.getElementById('severeCyclonePrediction');
        if (severeCyclonePredictionElement) {
            severeCyclonePredictionElement.innerHTML = `<p>Predicted Severe Cyclones: ${data.predicted_severe_cyclones}</p>`;
        }
    })
    .catch(error => {
        console.error('Error predicting severe cyclones:', error);
        // Handle errors gracefully
    });
}
</script>