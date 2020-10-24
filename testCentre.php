<?php
include("dbcon.php");
session_start();

$centreNum = 0;
$centreName = "";
$count_kitstock = 0;
$count_tester = 0;

//check user
if(!isset($_SESSION['username'])){
	echo "<script>alert('Please login first!')</script>";
	echo "<script>window.open('index.php','_self')</script>";
} else {
	$username = $_SESSION['username'];
	$checkCentre = "select * from user where username='$username' and position = 'manager' AND centreID IS NOT NULL";

	$statement = $dbcon->prepare($checkCentre);
	$statement->execute();
	if($row = $statement->fetch()){
        $centreNum++;
		$centreID = $row['centreID'];
		
        $findCentre = "select * from testCentre where centreID = $centreID";
        $statement2 = $dbcon->prepare($findCentre);
        $statement2->execute();
        if($row2=$statement2->fetch()){
			$centreName = $row2['centreName'];
        }else{
            echo "<script> alert('Fail Centre Name!'); </script>";
		}
		
		//to calculate total kit stock
		$sum_kit = "select count(kitID) as totalKit from testKit where centreID = '$centreID'";
		$statement3 = $dbcon->prepare($sum_kit);
		$statement3->execute();
		if($row3=$statement3->fetch()){
			$count_kitstock  = $row3['totalKit'];
		}
		else{
			echo "<script> alert('Available Stock calculate fail!!'); </script>";
		}

		//to calculate total number of tester
		$sum_tester = "select count(username) from user where centreID = '$centreID' AND position = 'Tester'";
		$statement4 = $dbcon->prepare($sum_tester);
		$statement4->execute();
		if($row4=$statement4->fetch()){
			$count_tester  = $row4['count(username)'];
		}
		else{
			echo "<script> alert('Tester number calculate fail!!'); </script>";
		}
	}
}

//register test centre
if(isset($_POST['createCentre'])){
    if($centreNum==0) {
        $username=$_SESSION['username'];
        $cname = $_POST['centreName'];

        $check_cname = "select * from testCentre where centreName='$cname'";
        $statement = $dbcon->prepare($check_cname);
        $statement->execute();
        if($row=$statement->fetch()){
            echo "<script> alert('Test Centre exist!'); </script>";
        }
        else{
            $insert_centre="insert into `testCentre` (`centreName`) values ('$cname')";
            $statement2 = $dbcon->prepare($insert_centre);
            if($statement2->execute()){
                echo "<script> alert('TestCentre Registration Success!'); </script>";
                $centreNum++;
            }
            
            $retrieve_id = "select * from testCentre where centreName='$cname'";
            $statement2 = $dbcon->prepare($retrieve_id);
            $statement2 -> execute();
            if($row = $statement2->fetch()){
                $centreID = $row['centreID'];
                $insert_user = "update `user` SET `centreID` = '$centreID' where username='$username'";
                $statement3 = $dbcon->prepare($insert_user);
                if(!$statement3->execute()){
                    echo "<script> alert('Retrieve Failed!'); </script>";
                }
            }
        }
    }   
}

//if officer don't have centre, hide the manage and view tester link
if($centreNum==0){
	echo "<style> #function, #centreInformation{display:none;} </style>";
}
else if($centreNum==1){
    echo "<style> #addNewCentre{display:none;} </style>";
}

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
								<div class="col-md-2">
									<span> <?php echo "$username, $centreNum, $centreName,$count_kitstock,$count_tester"; ?> <span>
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
									<li class="nav-item" ><a href="dashboard.php">Dashboard</a></li>
									<li class="nav-item active"><a href="testCentre.php">Test Centre</a></li>
									<li class="nav-item" id="function">
										<a href="viewTester.php" >View Tester</a>
									</li>
									<li class="nav-item" id="function"><a href="kitStock.php">Kit Stock</a></li>
									<li class="nav-item" id="function"><a href="report.php">Report</a></li>
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
    
    <div class="viewCentre">
        <div class = "container">
            <div class = "addCentre col-md-6">
                <button class = "btn btn-outline" data-toggle="modal" data-target="#newCentre" id="addNewCentre"> + New Test Centre</button>
            </div>
            <table class = "table" id="centreInformation">
                <tr>
                    <div>
                        <!-- <td class="col-md-3">
                            <span>Image</span>
                            <img src="images/aaa.jpg">
                        </td> -->
                        <td class="col-md-9">
                            <div>
                                <h3><?php echo $centreName ?></h3>
                            </div>
                            <div class="description">
                                <ul style="list-style:none; margin-left:-4rem;">
                                    <li class="list-item">Number of Tester: <?php echo $count_tester ?> <a class="btn btn-link" href="viewTester.php"> View </a> </li>
                                    <li class="list-item">Test Kit Stock: <?php echo $count_kitstock ?> <a class="btn btn-link" href="kitStock.php"> Details </a></li>
                                </ul>
                                <!-- The number of tester will be increase and automatically count when a tester is recorded to this test centre -->
                                <!-- There are two way to show the tester information, 1. click the view button 2. click the view tester link in the navigation -->
                                <!-- In the view tester page, it show the list of the tester and able to add/records a new tester -->
                                <!-- When manager record a new tester, the username would be assinged to the centreID -->
                            </div>
                        </td>
                    </div>
                </tr>
            </table>
        </div>
    </div>

    <div class="addCentre">
		<div class = "container">
			<div class="modal fade" id="newCentre">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<h2 class="modal-title">Add New Centre</h2>
							<button class="close" data-dismiss="modal">&times;</button>
						</div>
						<div class = "modal-body">
							<form role="form" method="post" action="testCentre.php" name="newCentreForm" onsubmit="return addCentreForm(this);">
								<div class="form-group">
                                    <label>Centre Name</label>
                                    <input type="text" name="centreName" class="form-control" id="centreName" autofocus>
                                    <span class = "invalid-feedback" id = "centreNameError"> *Please enter a centre name.</span>
                                </div>

								<div class="text-center pt-4">
								    <button type="submit" value="createCentre" name="createCentre" class="btn btn-success btn-block">Submit</button>
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
    function addCentreForm()
		{
			var centreName=document.newCentreForm.centreName;

			if(centreName.value == "") {
                document.getElementById('centreNameError').style.display = 'block';
                return false;
            }
            // else if (centreName.value== checkName){
			// 	document.getElementById("centreNameError").innerHTML="Centre Name exist!";
			// 	return false;
			// }
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

