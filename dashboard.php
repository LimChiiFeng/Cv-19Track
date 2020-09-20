<?php
include("dbcon.php");
session_start();

$centreNum = 0;

if(!isset($_SESSION['username'])){
	echo "<script>alert('Please login first!')</script>";
	echo "<script>window.open('index.php','_self')</script>";
}
	$username = $_SESSION['username'];
	$checkCentre = "select * from user where username='$username' and position = 'manager' AND centreID IS NULL";

	$statement = $dbcon->prepare($checkCentre);
	$statement->execute();
	if($row = $statement->fetch()){
		echo "<script>alert('$username, your test centre have been approved, please complete the centre registration!');</script>";
	}
	else{
		// echo "<script>alert('Welcome, $username, you haven\'t a test centre');</script>";
		$centreNum++;
	}

if($centreNum==0){
	echo "<style> .function{display:none;} </style>";
}
?>

<!DOCTYPE HTML>
<html>
	<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Dashboard</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="" />
	<meta name="keywords" content="" />
	<meta name="author" content="" />

  <!-- Facebook and Twitter integration -->
	<meta property="og:title" content=""/>
	<meta property="og:image" content=""/>
	<meta property="og:url" content=""/>
	<meta property="og:site_name" content=""/>
	<meta property="og:description" content=""/>
	<meta name="twitter:title" content="" />
	<meta name="twitter:image" content="" />
	<meta name="twitter:url" content="" />
	<meta name="twitter:card" content="" />

	<link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" rel="stylesheet">
	
	<!-- Animate.css -->
	<link rel="stylesheet" href="css/animate.css">
	<!-- Icomoon Icon Fonts-->
	<link rel="stylesheet" href="css/icomoon.css">
	<!-- Bootstrap  -->
	<link rel="stylesheet" href="css/bootstrap.css">
	<!-- Magnific Popup -->
	<link rel="stylesheet" href="css/magnific-popup.css">
	<!-- Owl Carousel  -->
	<link rel="stylesheet" href="css/owl.carousel.min.css">
	<link rel="stylesheet" href="css/owl.theme.default.min.css">
	<!-- Flexslider  -->
	<link rel="stylesheet" href="css/flexslider.css">
	<!-- Flaticons  -->
	<link rel="stylesheet" href="fonts/flaticon/font/flaticon.css">
	<!-- Theme style  -->
	<link rel="stylesheet" href="css/style.css">

	<!-- Modernizr JS -->
	<script src="js/modernizr-2.6.2.min.js"></script>
	<!-- FOR IE9 below -->
	<!--[if lt IE 9]>
	<script src="js/respond.min.js"></script>
	<![endif]-->

	</head>
	<body>
		
	<div class="colorlib-loader"></div>
	
	<div id="page">
	<nav class="colorlib-nav" role="navigation">
		<div class="top-menu">
			<div class="container">
				<div class="row">
					<div class="col-xs-12">
						<div class="top">
							<div class="row">
								<div class="col-md-6">
									<div id="colorlib-logo"><a href="index.html">Cv-19<span>Track</span></a></div>
								</div>
								<div class="col-md-2">
									<span> <?php echo "$username,$centreNum"; ?> <span>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="menu-wrap">
				<div class="container">
					<div class="row">
						<div class="col-md-8">
							<div class="menu-1">
								<ul>
									<li class="nav-item active" ><a href="dashboard.php">Dashboard</a></li>
									<li><a href="testCentre.php">Test Centre</a></li>
									<li class="nav-item">
										<a class="function" href="viewTester" >View Tester</a>
									</li>
									<li class="nav-item"><a class="function" href="kitStock.php">Kit Stock</a></li>
									<li class="nav-item"><a class="function" href="report.php">Report</a></li>
								</ul>
							</div>
						</div>
						<div class = "col-md-4">
							<div class="menu-2">
                            <?php
                                if(isset($_SESSION['username'])){
                                    echo'<a class="btn btn-link" href="index.php">Logout</a>';
                                }
                            ?>    
							</div>
							
						</div>
					</div>
				</div>
			</div>
		</div>
	</nav>	
	
	<!-- <aside id="colorlib-hero" class="breadcrumbs">
		<div class="flexslider">
			<ul class="slides">
		   	<li style="background-image: url(images/img_bg_6.jpg);">
		   		<div class="overlay"></div>
		   		<div class="container">
		   			<div class="row">
			   			<div class="col-md-8 col-md-offset-2 col-md-pull-2 slider-text">
			   				<div class="slider-text-inner">
			   					<h1>Welcome back, <strong>Manager1</strong></h1>
									<h2>html5 Bootstrap Templates Made by colorlib.com</h2>
			   				</div>
			   			</div>
			   		</div>
		   		</div>
		   	</li>
		  	</ul>
	  	</div>
	</aside> -->


	<div id="colorlib-services">
		<div class="container">
			<div class="row">
				<div class="col-md-4 animate-box">
					<div class="services-2">
						<span class="icon">
							<i class="flaticon-hospital"></i>
						</span>
						<div class="desc">
							<h3>
								<a href="testCentre.php">
									<?php
										if($centreNum==0){echo "Register Test Centre";}
										else { echo "View Test Centre";};

									?>
								</a>
							</h3>
							<p>Even the all-powerful Pointing has no control about the blind texts it is an almost unorthographic life</p>
						</div>
					</div>
				</div>
				<div class="col-md-4 animate-box function">
					<div class="services-2">
						<span class="icon">
							<i class="flaticon-healthy-1"></i>
						</span>
						<div class="desc">
							<h3><a href="#">View Tester</a></h3>
							<p>Even the all-powerful Pointing has no control about the blind texts it is an almost unorthographic life</p>
						</div>
					</div>
				</div>
				<div class="col-md-4 animate-box function">
					<div class="services-2">
						<span class="icon">
							<i class="flaticon-stethoscope"></i>
						</span>
						<div class="desc">
							<h3><a href="#">Report</a></h3>
							<p>Even the all-powerful Pointing has no control about the blind texts it is an almost unorthographic life</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>


	<footer id="colorlib-footer" role="contentinfo">
		<div class="overlay"></div>
		<div class="container">
			<div class="row row-pb-md">
				<div class="col-md-3 colorlib-widget">
						<h3>Head Office</h3>
						<ul class="colorlib-footer-links">
							<li>291 South 21th Street, <br> Suite 721 New York NY 10016</li>
							<li><a href="tel://1234567920"><i class="icon-phone"></i> + 1235 2355 98</a></li>
							<li><a href="mailto:info@yoursite.com"><i class="icon-mail"></i> info@yoursite.com</a></li>
							<li><a href="http://luxehotel.com"><i class="icon-location4"></i> yourwebsite.com</a></li>
							<li>Mon-Thu: 9:30 – 21:00</li>
							<li>Fri: 6:00 – 21:00</li>
							<li>Sat: 10:00 – 15:00</li>
						</ul>
					</div>
					<div class="col-md-2 colorlib-widget">
						<h3>Departments</h3>
						<p>
							<ul class="colorlib-footer-links">
								<li><a href="#">Neurology</a></li>
								<li><a href="#">Traumotology</a></li>
								<li><a href="#">Gynaecology</a></li>
								<li><a href="#">Nephrology</a></li>
								<li><a href="#">Cardiology</a></li>
								<li><a href="#">Pulmonary</a></li>
							</ul>
						</p>
					</div>
					<div class="col-md-2 colorlib-widget">
						<h3>Useful Links</h3>
						<p>
							<ul class="colorlib-footer-links">
								<li><a href="#">Home</a></li>
								<li><a href="#">Departments</a></li>
								<li><a href="#">Doctors</a></li>
								<li><a href="#">Services</a></li>
								<li><a href="#">News</a></li>
								<li><a href="#">Contact</a></li>
							</ul>
						</p>
					</div>

					<div class="col-md-2 colorlib-widget">
						<h3>Support</h3>
						<p>
							<ul class="colorlib-footer-links">
								<li><a href="#">Documentation</a></li>
								<li><a href="#">Forums</a></li>
								<li><a href="#">Help &amp; Support</a></li>
								<li><a href="#">Scholarship</a></li>
								<li><a href="#">Student Transport</a></li>
								<li><a href="#">Release Status</a></li>
							</ul>
						</p>
					</div>

				<div class="col-md-3 colorlib-widget">
					<h3>Make an Appointment</h3>
					<form class="contact-form">
						<div class="form-group">
							<label for="name" class="sr-only">Name</label>
							<input type="name" class="form-control" id="name" placeholder="Name">
						</div>
						<div class="form-group">
							<label for="email" class="sr-only">Email</label>
							<input type="email" class="form-control" id="email" placeholder="Email">
						</div>
						<div class="form-group">
							<label for="message" class="sr-only">Message</label>
							<textarea class="form-control" id="message" rows="3" placeholder="Message"></textarea>
						</div>
						<div class="form-group">
							<input type="submit" id="btn-submit" class="btn btn-primary btn-send-message btn-md" value="Send Message">
						</div>
					</form>
				</div>
			</div>
		</div>
		<div class="row copyright">
			<div class="col-md-12 text-center">
				<p>
					<small class="block">&copy; <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | This template is made with <i class="icon-heart" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank">Colorlib</a>
<!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. --></small> 
					<small class="block">Demo Images: <a href="http://unsplash.co/" target="_blank">Unsplash</a> , <a href="https://www.pexels.com/" target="_blank">Pexels</a></small>
				</p>
			</div>
		</div>
	</footer>
	</div>

	<div class="gototop js-top">
		<a href="#" class="js-gotop"><i class="icon-arrow-up"></i></a>
	</div>
	
	<!-- jQuery -->
	<script src="js/jquery.min.js"></script>
	<!-- jQuery Easing -->
	<script src="js/jquery.easing.1.3.js"></script>
	<!-- Bootstrap -->
	<script src="js/bootstrap.min.js"></script>
	<!-- Waypoints -->
	<script src="js/jquery.waypoints.min.js"></script>
	<!-- Stellar Parallax -->
	<script src="js/jquery.stellar.min.js"></script>
	<!-- Carousel -->
	<script src="js/owl.carousel.min.js"></script>
	<!-- Flexslider -->
	<script src="js/jquery.flexslider-min.js"></script>
	<!-- countTo -->
	<script src="js/jquery.countTo.js"></script>
	<!-- Magnific Popup -->
	<script src="js/jquery.magnific-popup.min.js"></script>
	<script src="js/magnific-popup-options.js"></script>
	<!-- Sticky Kit -->
	<script src="js/sticky-kit.min.js"></script>
	<!-- Main -->
	<script src="js/main.js"></script>

	</body>
</html>
