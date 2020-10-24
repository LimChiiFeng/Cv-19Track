<?php
include("dbcon.php");
session_start();

//check user
if(!isset($_SESSION['username'])){
	echo "<script>alert('Please login first!')</script>";
	echo "<script>window.open('index.php','_self')</script>";
} else {
	$username = $_SESSION['username'];
	$hvtester=false;
	
	$findUser = "select * from user where username = '$username' ";
	$statement=$dbcon->prepare($findUser);
	$statement->execute();
	if($row = $statement->fetch()){
		$centreID=$row['centreID'];
		$checkCentre = "select count(*) AS testerQ from user where position = 'Tester' AND centreID = '$centreID'";
		$statement2=$dbcon->prepare($checkCentre);
		$statement2->execute();
		if($row2=$statement2->fetch()){
			$adatester=$row2['testerQ'];
			if($adatester>0){
				$hvtester=true;
			}else{
				$hvtester=false;
			}
			echo "<script>alert('Tester Count:$adatester')</script>";
		}
	}

	if(isset($_POST['createTester'])){
		$uname=$_POST['username'];
		$pssw=$_POST['password'];
		$fName=$_POST['fullName'];
	
		$find_user="select * from user where username='$uname'"; 
		$statement = $dbcon->prepare($find_user);
		$statement->execute();
		if($row = $statement->fetch())
		{  
			echo "<script>alert('Username exists. Please enter another username.')</script>";
		}
		else
		{
			
			$hashed_password = password_hash($pssw, PASSWORD_DEFAULT);
			
			$query = "insert into user (username, password, name, type, patientType, symptoms, position,centreID) 
					values ('$uname','$hashed_password','$fName','centreOfficer',null,null, 'Tester','$centreID')";
			$statement = $dbcon->prepare($query);
			if($statement->execute())
			{
				echo "<script>alert('Tester added successful...')</script>";
			}  
			else  
			{  
				echo "<script>alert('Register failed!')</script>";
			}  
		}
	}
	// else{
	// 	echo"<script>alert('Tak dpt cari createTester. Cannot create tester')</script>";
	// }
}

// if($hvtester){
// 	echo "<script>alert('hvtester:true');</script>";
// }else{
// 	echo "<script>alert('xxi');</script>";
// }


?>
<!DOCTYPE HTML>
<html>
	<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Test Centre</title>
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
								<div class="col-md-6">
									<span> <?php echo var_dump($hvtester). "$username, $centreID" ?> </span>
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
									<li class="nav-item" id="dashboard"><a href="dashboard.php">Dashboard</a></li>
									<li class="nav-item" id="test_centre"><a href="testCentre.php">Test Centre</a></li>
									<li class="nav-item active" id="view_tester"><a class="function" href="viewTester.php" >View Tester</a></li>
									<li class="nav-item" id="test_kit"><a class="function" href="kitStock.php">Kit Stock</a></li>
									<li class="nav-item" id="test_report"><a class="function" href="report.php">Report</a></li>
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
    <div class="viewTester">
        <div class = "container">
			<div class="notester">
				<img src="images/no-data(2).jpg">
				<h1> Oh, ooh</h1>
				<p> No tester registered to this center yet. Please press the button below to add a tester for this center.</p>
				<button type="submit" class="addtesterbtn" data-toggle="modal" data-target="#recordTester">Register a tester
					 <img src="images/nodatabtn.png"  alt="Register a tester">
					 <img src="images/CNYwritingrush.gif" class="btnchgimg" alt="registerabtn">
					</button>
				
				</div>
            <!-- <div class = "addTester col-md-6">
                <button class = "btn btn-outline" data-toggle="modal" data-target="#recordTester" id="addNewTester"> + New Tester</button>
            </div>
            <table class = "table">
                <tr>
                    <div>
                        <td class="col-md-3">
							<img src="images/test-centre1.jpg">
                        </td>
                        <td class="col-md-9">
                            <div>
                                <h3><?php echo $centreName ?></h3>
                            </div>
                            <div class="description">
                                <ul style="list-style:none; margin-left:-4rem;">
                                    <li class="list-item">Number of Tester: ?? <a class="btn btn-link" href=""> View </a> </li>
                                    <li class="list-item">Kit Stock: ?? <a class="btn btn-link" href="kitStock.php"> Manage </a></li>
                                </ul>
                            </div>
                        </td>
                    </div>
                </tr>
			</table> -->
			
			<div class="testerData">
				<h2> Tester List </h2>
				<div class="testerList">
					<ul>
					<?php 
					$tester_data="select * from user where position='Tester' AND centreID='$centreID'";
					$statement_01=$dbcon->prepare($tester_data);
					$statement_01->execute();
					$data=$statement_01->fetchAll();
					foreach($data as $row){
						$tester_username=$row['username'];
						$tester_name=$row['name'];
						$tester_type=$row['type'];
						$tester_position=$row['position'];
					?>
					<h3> Data <?php echo $tester_username ?></h3>
					<li> Username: <?php echo $tester_username ?></li>
					<li> Name: <?php echo $tester_name ?></li>
					<li> Type: <?php echo $tester_type ?></li>
					<li> Position<?php echo $tester_position ?></li>
					<hr>
					<?php } ?>
					</ul>
				</div>
			</div>
        </div>
    </div>

    <div class="addTester">
		<div class = "container">
			<div class="modal fade" id="recordTester">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<h2 class="modal-title">Add New Tester</h2>
							<button class="close" data-dismiss="modal">&times;</button>
						</div>
						<div class = "modal-body">
							<form method="post" action="viewTester.php" name="newtester" onsubmit="return addTesterForm(this);">
								<div class="form-group">
                                    <label>Tester Username</label>
                                    <input type="text" name="username" class="form-control" id="username" autofocus>
									<span class = "invalid-feedback" id = "usernameError"> *Please enter a username.</span>									
								</div>
							<div class="form-group">
								<label>password</label>
								<input type="password" name="password" id="passwordReg" class="form-control" placeholder="Contains 2-20 characters, At least one lower case, upper case letter, and a number">
								<span class = "invalid-feedback" id = "pssError"> *Please enter a password length of 2 - 20, at least one number, one lower case and one upper case letter. </span>
							</div>

							<div class="form-group">
								<input type="password" name="passwordCfm" id="passwordCfm" class="form-control" placeholder="Password Confirm">
								<span class = "invalid-feedback" id = "pssCfmError"> *The password is not match. </span>
							</div>
							<div class="form-group">
								<input type="text" name="fullName" id="fullName" class="form-control" placeholder="Full Name">
								<span class = "invalid-feedback" id = "fullNameError"> *Please enter your full name. </span>
							</div>
							<div class="text-center pt-4">
								    <button type="submit" value="createCentre" name="createTester" class="btn btn-success btn-block" id="myAznchor">Register</button>
								</div>
							  </form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<footer id="colorlib-footer" role="contentinfo">
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

	function stop(){
		return false;
	}
    function addTesterForm(){
            // else if (centreName.value== checkName){
			// 	document.getElementById("centreNameError").innerHTML="Centre Name exist!";
			// 	return false;
			// }
			var username=document.newtester.username;
			var password=document.newtester.password;
			var fullName=document.newtester.fullName;
            var passwordCfm=document.newtester.passwordCfm;  
			
			var errorMsg = 0;

			if(username.value == "") {
                document.getElementById('usernameError').style.display = 'block';
                errorMsg++;
            } else {
				document.getElementById('usernameError').style.display = 'none';
			}

			if(fullName.value == ""){
				document.getElementById("fullNameError").style.display = "block";
				errorMsg++;
			}
			else {
				document.getElementById("fullNameError").style.display = "none";
				console.log("fullName go to else");
			}
			
			if(password.value == "" || !password.value.match(/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z]{2,20}$/)){
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
                document.getElementById("pssCfmError").style.display = "none";
            }
			if(errorMsg != 0){
				if(username.value==""){
					username.focus();
				}else if(password.value == "" || !password.value.match(/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z]{8,20}$/)) {
					password.focus();
				}else if(passwordCfm.value != password.value || passwordCfm.value==""){
                    passwordCfm.focus();
                }else if(fullName.value == "") {
					fullName.focus();
				} 
				return false;
			} 
			
			console.log("saigo return false");
			return true;
			
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

