<?php
include("dbcon.php");
session_start();

if(isset($_POST['login']))  
{  
	$username=$_POST['username'];
	$password=$_POST['password'];

	$find_user="select * from user where username='$username'"; 
	$statement = $dbcon->prepare($find_user);
	$statement->execute();
	if($row = $statement->fetch())
	{  
		$hashed_password=$row['password'];
		
		if(password_verify($password, $hashed_password)) {
			$_SESSION['username']=$row['username'];
			$_SESSION['type']=$row['type'];
			if($_SESSION['type'] == "centreOfficer"){
				echo "<script>window.open('dashboard.php','_self')</script>";
			}else if($_SESSION['type'] == "patient"){
				echo "<script>window.open('signup.php','_self')</script>";
			}else {
				echo "<script>alert('Wrong Type')</script>";
			}
		} 
		else  
		{  
			echo "<script>alert('Username or password is incorrect!')</script>";
		} 
	} 
	else 
	{
		echo "<script>alert('Username or password is incorrect!')</script>";
	}
}
elseif(isset($_POST['register']))  
{  
	$username=$_POST['username'];
	$password=$_POST['password'];
	$fullName=$_POST['fullName'];
	$email=$_POST['email'];
	
	$find_user="select * from user where username='$username'"; 
	$statement = $dbcon->prepare($find_user);
	$statement->execute();
	if($row = $statement->fetch())
	{  
		echo "<script>alert('Username exists. Please enter another username.')</script>";
	}
	else
	{
		$hashed_password = password_hash($password, PASSWORD_DEFAULT);
		
		$query = "insert into user (username, password, name, email, type, patientType, symptoms, position) 
				  values ('$username','$hashed_password','$fullName','$email','patient','returnee','None', null)";
		$statement = $dbcon->prepare($query);
		if($statement->execute())
		{
			echo "<script>alert('Register successful! Please login...')</script>";
			echo "<script>window.open('index.php','_self')</script>";
		}  
		else  
		{  
			echo "<script>alert('Register failed!')</script>";
		}  
	}
}
?>
<!DOCTYPE HTML>
<html>
	<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Cv-19Track</title>
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
									<li class="active"><a href="index.html">Home</a></li>
									<li><a href="services.html">Services</a></li>
									<li class="has-dropdown">
										<a href="departments.html">Departments</a>
										<ul class="dropdown">
											<li><a href="departments-single.html">Plasetic Surgery Department</a></li>
											<li><a href="departments-single.html">Dental Department</a></li>
											<li><a href="departments-single.html">Psychological Department</a></li>
										</ul>
									</li>
									<li><a href="contact.html">Contact Us</a></li>
								</ul>
							</div>
						</div>
						<div class = "col-md-4">
							<div class="menu-2">
								<button class = "btn btn-link" data-toggle="modal" data-target="#signIn">Sign In</button>
								<button class = "btn btn-link" data-toggle="modal" data-target="#signUp">Sign Up</button>
							</div>
							
						</div>
					</div>
				</div>
			</div>
		</div>
	</nav>
	
	<aside id="colorlib-hero">
		<div class="flexslider">
			<ul class="slides">
		   	<li style="background-image: url(images/img_bg_6.jpg);">
		   		<div class="overlay"></div>
		   		<div class="container">
		   			<div class="row">
			   			<div class="col-md-8 col-md-offset-2 col-md-pull-2 slider-text">
			   				<div class="slider-text-inner">
			   					<h1>Your Health <strong>is always <br>in the first place</strong></h1>
									<h2>Separated they live in Bookmarksgrove right at the coast of the Semantics, a large language ocean.</h2>
									<p><a class="btn btn-primary btn-lg btn-learn" href="#">Make an Appointment</a></p>
			   				</div>
			   			</div>
			   		</div>
		   		</div>
		   	</li>
		   	<li style="background-image: url(images/img_bg_5.jpg);">
		   		<div class="overlay"></div>
		   		<div class="container">
		   			<div class="row">
			   			<div class="col-md-8 col-md-offset-2 col-md-pull-2 slider-text">
			   				<div class="slider-text-inner">
			   					<h1>We help you <strong>to find the best doctor around you</strong></h1>
									<h2>Separated they live in Bookmarksgrove right at the coast of the Semantics, a large language ocean.</h2>
									<p><a class="btn btn-primary btn-lg btn-learn" href="#">Make an Appointment</a></p>
			   				</div>
			   			</div>
			   		</div>
		   		</div>
		   	</li>
		   	<li style="background-image: url(images/img_bg_1.jpg);">
		   		<div class="overlay"></div>
		   		<div class="container">
		   			<div class="row">
			   			<div class="col-md-8 col-md-offset-2 col-md-pull-2 slider-text">
			   				<div class="slider-text-inner">
			   					<h1>Guaranted <strong>safe &amp; potent</strong> Medicine</h1>
									<h2>Separated they live in Bookmarksgrove right at the coast of the Semantics, a large language ocean.</h2>
									<p><a class="btn btn-primary btn-lg btn-learn" href="#">Make an Appointment</a></p>
			   				</div>
			   			</div>
			   		</div>
		   		</div>
		   	</li>
		   	<li style="background-image: url(images/img_bg_2.jpg);">
		   		<div class="overlay"></div>
		   		<div class="container">
		   			<div class="row">
			   			<div class="col-md-8 col-md-offset-2 col-md-pull-2 slider-text">
			   				<div class="slider-text-inner">
			   					<h1>Helping to improve <strong>quality stimulate</strong> innovation</h1>
									<h2>Separated they live in Bookmarksgrove right at the coast of the Semantics, a large language ocean.</h2>
									<p><a class="btn btn-primary btn-lg btn-learn" href="#">Make an Appointment</a></p>
			   				</div>
			   			</div>
			   		</div>
		   		</div>
		   	</li>		   	
		  	</ul>
	  	</div>
	</aside>

	<div id="colorlib-counter" class="colorlib-counters">
		<div class="overlay"></div>
		<div class="container">
			<div class="row">
				<div class="col-md-8 col-md-offset-2 col-md-push-2 counter-wrap">
					<div class="row">
						<div class="col-md-3 col-sm-6 animate-box">
							<div class="desc">
								<p class="wrap">
									<span class="icon"><i class="flaticon-healthy"></i></span>
									<span class="colorlib-counter js-counter" data-from="0" data-to="3297" data-speed="5000" data-refresh-interval="50"></span>
								</p>
								<span class="colorlib-counter-label">Total Covid-19 Cases for Global</span>
							</div>
						</div>
						<div class="col-md-3 col-sm-6 animate-box">
							<div class="desc">
								<p class="wrap">
									<span class="icon"><i class="flaticon-hospital"></i></span>
									<span class="colorlib-counter js-counter" data-from="0" data-to="378" data-speed="5000" data-refresh-interval="50"></span>
								</p>
								<span class="colorlib-counter-label">Total Covid-19 Cases for Malaysia</span>
							</div>
						</div>
						<div class="col-md-3 col-sm-6 animate-box">
							<div class="desc">
								<p class="wrap">
									<span class="icon"><i class="flaticon-healthy-1"></i></span>
									<span class="colorlib-counter js-counter" data-from="0" data-to="400" data-speed="5000" data-refresh-interval="50"></span>
								</p>
								<span class="colorlib-counter-label">Total Actived Cases</span>
							</div>
						</div>
						<div class="col-md-3 col-sm-6 animate-box">
							<div class="desc">
								<p class="wrap">
									<span class="icon"><i class="flaticon-ambulance"></i></span>
									<span class="colorlib-counter js-counter" data-from="0" data-to="30" data-speed="5000" data-refresh-interval="50"></span>
								</p>
								<span class="colorlib-counter-label">Total Recovered Cases</span>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div id="colorlib-services">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<div class="services-flex">
						<div class="one-fifth no-border-bottom animate-box">
							<div class="services">
								<span class="icon">
									<i class="flaticon-hospital"></i>
								</span>
								<div class="desc">
									<h3><a href="#">Diagnostics and emergency treatment</a></h3>
								</div>
							</div>
						</div>
						<div class="one-fifth no-border-bottom animate-box">
							<div class="services">
								<span class="icon">
									<i class="flaticon-healthy-1"></i>
								</span>
								<div class="desc">
									<h3><a href="#">Home medical appointments</a></h3>
								</div>
							</div>
						</div>
						<div class="one-fifth no-border-bottom animate-box">
							<div class="services">
								<span class="icon">
									<i class="flaticon-stethoscope"></i>
								</span>
								<div class="desc">
									<h3><a href="#">Pharmacy refunded from hospital</a></h3>
								</div>
							</div>
						</div>
						<div class="one-forth animate-box">
							<div class="head">
								<h2>Comprehensive services for our patients</h2>
							</div>
						</div>
					</div>
					<div class="services-no-flex">
						<div class="one-fifth animate-box">
							<div class="services">
								<span class="icon">
									<i class="flaticon-blood-donation"></i>
								</span>
								<div class="desc">
									<h3><a href="#">Long term medical care in a hospital</a></h3>
								</div>
							</div>
						</div>

						<div class="services-wrap-flex">
							<div class="one-fifth services-img animate-box" style="background-image: url(images/services-1.jpg);">
								<div class="services">
									<div class="desc">
										<span>Mission</span>
										<h3><a href="#">The correct diagnosis is half the battle</a></h3>
									</div>
								</div>
							</div>
							<div class="one-half">
								<div class="one-full-flex">
									<div class="one-fifth services-img animate-box" style="background-image: url(images/services-2.jpg);">
										<div class="services">
											<div class="desc">
												<span>Vision</span>
												<h3><a href="#">We refund 50% of the cost of medicines</a></h3>
											</div>
										</div>
									</div>
									<div class="one-fifth animate-box">
										<div class="services">
											<span class="icon">
												<i class="flaticon-radiation"></i>
											</span>
											<div class="desc">
												<h3><a href="#">A specialized laboratory research</a></h3>
											</div>
										</div>
									</div>
									<div class="one-fifth animate-box">
										<div class="services">
											<span class="icon">
												<i class="flaticon-ambulance"></i>
											</span>
											<div class="desc">
												<h3><a href="#">Medical transport to the hospital</a></h3>
											</div>
										</div>
									</div>
								</div>
								<div class="one-full-flex animate-box">
									<div class="services-desc">
										<div class="desc">
											<p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts. Separated they live in Bookmarksgrove right at the coast of the Semantics, a large language ocean.</p>
											<a href="#" class="btn btn-primary">View services</a>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div id="colorlib-about">
		<div class="container">
			<div class="row">
				<div class="col-md-6 col-md-push-6 animate-box">
					<img class="img-responsive about-img" src="images/about.png" alt="">
				</div>
				<div class="col-md-6 col-md-pull-6 animate-box">
					<h2>About Healthcare</h2>
					<p>
						Even the all-powerful Pointing has no control about the blind texts it is an almost unorthographic life One day however a small line of blind text by the name of Lorem Ipsum decided to leave for the far World of Grammar.
					</p>
						<div class="fancy-collapse-panel">
                    <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                     <div class="panel panel-default">
                         <div class="panel-heading" role="tab" id="headingOne">
                             <h4 class="panel-title">
                                 <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">Our Mission
                                 </a>
                             </h4>
                         </div>
                         <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                             <div class="panel-body">
                                 <div class="row">
								      		<div class="col-md-6">
								      			<p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts. </p>
								      		</div>
								      		<div class="col-md-6">
								      			<p>Separated they live in Bookmarksgrove right at the coast of the Semantics, a large language ocean.</p>
								      		</div>
								      	</div>
                             </div>
                         </div>
                     </div>
                     <div class="panel panel-default">
                         <div class="panel-heading" role="tab" id="headingTwo">
                             <h4 class="panel-title">
                                 <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">Our Vission
                                 </a>
                             </h4>
                         </div>
                         <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                             <div class="panel-body">
                                 <p>Far far away, behind the word <strong>mountains</strong>, far from the countries Vokalia and Consonantia, there live the blind texts. Separated they live in Bookmarksgrove right at the coast of the Semantics, a large language ocean.</p>
											<ul>
												<li>Separated they live in Bookmarksgrove right</li>
												<li>Separated they live in Bookmarksgrove right</li>
											</ul>
                             </div>
                         </div>
                     </div>
                     <div class="panel panel-default">
                         <div class="panel-heading" role="tab" id="headingThree">
                             <h4 class="panel-title">
                                 <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">Why choose us
                                 </a>
                             </h4>
                         </div>
                         <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
                             <div class="panel-body">
                                 <p>Far far away, behind the word <strong>mountains</strong>, far from the countries Vokalia and Consonantia, there live the blind texts. Separated they live in Bookmarksgrove right at the coast of the Semantics, a large language ocean.</p>	
                             </div>
                         </div>
                     </div>
                  </div>
               </div>
				</div>
			</div>
		</div>
	</div>

	<div id="colorlib-choose">
		<div class="container-fluid">
			<div class="row">
				<div class="choose">
					<div class="half img-bg" style="background-image: url(images/cover_bg_1.jpg);"></div>
					<div class="half features-wrap">
						<div class="features-services animate-box">
							<div class="colorlib-heading animate-box">
								<h2>How to prevent it?</h2>
							</div>
							<div class="row">
								<div class="col-md-6">
									<div class="features animate-box">
										<span class="icon text-center"><i class="flaticon-healthy-1"></i></span>
										<div class="desc">
											<h3>Wash Hand</h3>
											<p>A small river named Duden flows by their place and supplies it with the necessary regelialia. </p>
										</div>
									</div>
									<div class="features animate-box">
										<span class="icon text-center"><i class="flaticon-stethoscope"></i></span>
										<div class="desc">
											<h3>Free Consultation</h3>
											<p>A small river named Duden flows by their place and supplies it with the necessary regelialia. </p>
										</div>
									</div>
								</div>
								<div class="col-md-6">
									<div class="features animate-box">
										<span class="icon text-center"><i class="flaticon-medical-1"></i></span>
										<div class="desc">
											<h3>Online Enrollment</h3>
											<p>A small river named Duden flows by their place and supplies it with the necessary regelialia. </p>
										</div>
									</div>
									<div class="features animate-box">
										<span class="icon text-center"><i class="flaticon-radiation"></i></span>
										<div class="desc">
											<h3>Modern Facilities</h3>
											<p>A small river named Duden flows by their place and supplies it with the necessary regelialia. </p>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>


	<div class="colorlib-doctor">
		<div class="container">
			<div class="row animate-box">
				<div class="col-md-6 col-md-offset-3 text-center colorlib-heading">
					<h2>Well Experienced Doctors</h2>
					<p>A small river named Duden flows by their place and supplies it with the necessary regelialia.</p>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12 animate-box">
					<div class="row">
						<div class="owl-carousel2">
							<div class="item">
								<div class="col-md-6">
									<div class="doctor-desc">
										<h3><a href="#">Dr. Paul Armstrong</a></h3>
										<span class="specialty">Dental Hygienist</span>
										<p>When she reached the first hills of the Italic Mountains, she had a last view back on the skyline of her hometown Bookmarksgrove, the headline of Alphabet Village and the subline of her own road, the Line Lane. Pityful a rethoric question ran over her cheek, then she continued her way.</p>
										<p>Even the all-powerful Pointing has no control about the blind texts it is an almost unorthographic life One day however a small line of blind text by the name of Lorem Ipsum decided to leave for the far World of Grammar.</p>
										<p><a href="#" class="btn btn-primary">Email us</a> <a href="#" class="btn btn-primary btn-outline">Make an appointment</a></p>
									</div>
								</div>
								<div class="col-md-6">
									<div class="doctor-img" style="background-image: url(images/staff-3.jpg);">
									</div>
								</div>
							</div>
							<div class="item">
								<div class="col-md-6">
									<div class="doctor-desc">
										<h3><a href="#">Dr. Paul Armstrong</a></h3>
										<span class="specialty">Dental Hygienist</span>
										<p>When she reached the first hills of the Italic Mountains, she had a last view back on the skyline of her hometown Bookmarksgrove, the headline of Alphabet Village and the subline of her own road, the Line Lane. Pityful a rethoric question ran over her cheek, then she continued her way.</p>
										<p>Even the all-powerful Pointing has no control about the blind texts it is an almost unorthographic life One day however a small line of blind text by the name of Lorem Ipsum decided to leave for the far World of Grammar.</p>
										<p><a href="#" class="btn btn-primary">Email us</a> <a href="#" class="btn btn-primary btn-outline">Make an appointment</a></p>
									</div>
								</div>
								<div class="col-md-6">
									<div class="doctor-img" style="background-image: url(images/staff-1.jpg);">
									</div>
								</div>
							</div>
							<div class="item">
								<div class="col-md-6">
									<div class="doctor-desc">
										<h3><a href="#">Dr. Paul Armstrong</a></h3>
										<span class="specialty">Dental Hygienist</span>
										<p>When she reached the first hills of the Italic Mountains, she had a last view back on the skyline of her hometown Bookmarksgrove, the headline of Alphabet Village and the subline of her own road, the Line Lane. Pityful a rethoric question ran over her cheek, then she continued her way.</p>
										<p>Even the all-powerful Pointing has no control about the blind texts it is an almost unorthographic life One day however a small line of blind text by the name of Lorem Ipsum decided to leave for the far World of Grammar.</p>
										<p><a href="#" class="btn btn-primary">Email us</a> <a href="#" class="btn btn-primary btn-outline">Make an appointment</a></p>
									</div>
								</div>
								<div class="col-md-6">
									<div class="doctor-img" style="background-image: url(images/staff-2.jpg);">
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="login">
		<div class = "container">
			<div class="modal fade" id="signIn">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<h2 class="modal-title">Sign In</h2>
							<button class="close" data-dismiss="modal">&times;</button>
						</div>
						<div class = "modal-body">
							<form role="form" method="post" action="index.php" name="loginForm" onsubmit="return loginForm1(this);">
								<div class="form-group">
								  <input type="text" name="username" class="form-control" id="username" placeholder="Username" autofocus>
								  <span class = "invalid-feedback" id = "usernameError"> *Please enter username.</span>
								</div>
				
								<div class="form-group">
								  <input type="password" name="password" class="form-control" id="password" id="password" placeholder="Password">
								  <span class = "invalid-feedback" id = "passwordError"> *Please enter password.</span>
								</div>
								<div class="text-center pt-4">
								  <button type="submit" name="login" class="btn btn-success">Login</button>
								</div>				
							  </form>
							  <div class="text-center">
								<span>Don't have an account?<button class="btn btn-link">Sign Up now!</button></span>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="registration">
		<div class = "container">
			<div class="modal fade" id="signUp">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<h2 class="modal-title">Sign Up</h2>
							<button class="close" data-dismiss="modal">&times;</button>
						</div>
						<div class = "modal-body">
							<form role="form" method="post" action="index.php" name="registerForm" onsubmit="return regForm(this);">
							<div class="form-group">
								<input type="text" name="username" id="name" class="form-control" placeholder="Username" autofocus>
								<span class = "invalid-feedback" id = "userNameError"> *Please enter your username. </span>
							</div>

							<div class="form-group">
								<input type="text" name="fullName" id="fullName" class="form-control" placeholder="Full Name">
								<span class = "invalid-feedback" id = "fullNameError"> *Please enter your full name. </span>
							</div>

							<div class="form-group">
								<input type="text" name="email" id="email" class="form-control" placeholder="Email">
								<span class = "invalid-feedback" id = "emailError"> *Please enter a valid email address. </span>
							</div>

							<div class="form-group">
								<input type="password" name="password" id="passwordReg" class="form-control" placeholder="Password">
								<span class = "invalid-feedback" id = "pssError"> *Please enter a password length of 8 - 20, at least one number, one lower case and one upper case letter. </span>
							</div>

							<div class="form-group">
								<input type="password" name="passwordCfm" id="passwordCfm" class="form-control" placeholder="Password Confirm">
								<span class = "invalid-feedback" id = "pssCfmError"> *The password is not match. </span>
							</div>

								<div class="text-center pt-2 pb-1">
								  <button type="submit" name="register" class="btn btn-success">Register</button>
								</div>
							  </form>
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
	
	
	<script>
		//register form valudation
		function regForm()
		{
			var username=document.registerForm.username;
			var password=document.registerForm.password;
			var fullName=document.registerForm.fullName;
			var email=document.registerForm.email;
            var passwordCfm=document.registerForm.passwordCfm;
			
			var atPos=email.value.indexOf("@");
			var dotPos=email.value.lastIndexOf(".");      
			
			var errorMsg = 0;

			if(username.value == ""){
				document.getElementById("userNameError").style.display = "block";
			  	errorMsg++;
			}
			else {
				document.getElementById("userNameError").style.display = "none";
			}

			if(fullName.value == ""){
				document.getElementById("fullNameError").style.display = "block";
				errorMsg++;
			}
			else {
				document.getElementById("fullNameError").style.display = "none";
			}
			
			if (email.value == "" || atPos < 1 || dotPos < atPos+2 || dotPos+2 >= email.value.length){
				document.getElementById("emailError").style.display = "block";
				errorMsg++;  
			}
			else {
				document.getElementById("emailError").style.display = "none";
			}
			
			if(password.value == "" || !password.value.match(/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z]{8,20}$/)){
				document.getElementById("pssError").style.display = "block";
				errorMsg++; 
			}
			else {
				document.getElementById("pssError").style.display = "none";
			}

            if(passwordCfm.value != password.value || passwordCfm.value==""){
                document.getElementById("pssCfmError").style.display = "block";
				errorMsg++; 
            }	
            else {
                document.getElementById("pssError").style.display = "none";
            }
			
			if(errorMsg != 0){
				if(username.value == "") {
					username.focus();
				} else if(fullName.value == "") {
					fullName.focus();
				} else if (email.value == "" || atPos < 1 || dotPos < atPos+2 || dotPos+2 >= email.value.length) {
					email.focus();
				} else if(password.value == "" || !password.value.match(/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z]{8,20}$/)) {
					password.focus();
				} else {
                    passwordCfm.focus();
                }
				return false;
			} 

			return true;
		}
		
		//login form validation
		function loginForm1()
		{
			var username=document.loginForm.username;
			var password=document.loginForm.password;

			var errormsg = 0;

			if(username.value == ""){
				document.getElementById("usernameError").style.display = "block";
			  	errormsg++;
			}
			else {
				document.getElementById("usernameError").style.display = "none";
			}
			if(password.value == ""){  
				document.getElementById("passwordError").style.display = "block";
				errormsg++; 
			}
			else {
				document.getElementById("passwordError").style.display = "none";
			}

			if(errormsg != 0) {
				if(username.value == ""){
					username.focus();
				} else if (password.value == ""){
					password.focus();
				}
				return false;
			}
		}
	
	</script>

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

