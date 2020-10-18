<?php
include("dbcon.php");
session_start();

$centreNum = 0;
$centreName = "";
$centreID = "";
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
			$centreID=$row['centreID'];
        }else{
            echo "<script> alert('Fail Centre Name!'); </script>";
        }
	}
}

//add new test kit
if(isset($_POST['createKit'])){
	$testName=$_POST['testName'];
	$stockNum=(int)$_POST['stockNum'];

	$check_kit="select * from testKit where testName='$testName' AND centreID='$centreID'";
	$statement = $dbcon->prepare($check_kit);
	$statement->execute();
	if($row = $statement->fetch()){
		echo "<script> alert('Test Kit exist!'); </script>";
	}
	else{
		$insert_kit="insert into `testKit` (`testName`,`availableStock`,`centreID`) values ('$testName',$stockNum,$centreID)";
		$statement2 = $dbcon->prepare($insert_kit);
		if($statement2->execute()){
			echo "<script> alert('Test Kit has been added!'); </script>";
		}
	} 
} 
else if(isset($_POST['updateStock'])){
	$kitID = $_POST['kID'];
	$testName = $_POST['tname'];
	$stockNo = (int)$_POST['stockNo'];
	
	$update_stock = "update `testkit` SET `availableStock`= availableStock + $stockNo where kitID = '$kitID'";
	$statement = $dbcon->prepare($update_stock);

	if($statement->execute()){
		echo "<script> alert('$testName\'s stock update successfully!'); </script>";
	} else {
		echo "<script> alert('Stock Update failed!'); </script>";
	}
} 



//if officer don't have centre, hide the manage and view tester link
// if($centreNum==0){
// 	echo "<style> #function, #centreInformation{display:none;} </style>";
// }
// else if($centreNum==1){
//     echo "<style> #addNewCentre{display:none;} </style>";
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
								<div class="col-md-5">
									<span> <?php echo "$username, $centreNum, $centreName,$centreID"; ?> <span>
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
									<li class="nav-item"><a href="testCentre.php">Test Centre</a></li>
									<li class="nav-item" id="function">
										<a href="viewTester.php" >View Tester</a>
									</li>
									<li class="nav-item active" id="function"><a href="kitStock.php">Kit Stock</a></li>
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
    
    <div class="testKit">
		<div class="container">
			<div class="table-top col-md-6">
				<button class="btn btn-outline" data-toggle="modal" data-target="#newKit" id="addNewKit"> + Add Test Kit </button>
			</div>

			<table class="table table-hover" id="testKitData">
				<tr class="thead">
					<th class='table_testName'> Test name  </th>
					<th class='table_stock'> Stock </th>
				</tr>
				
				<?php
					$kit_data="select * from testKit where centreID='$centreID'";
					$statement = $dbcon->prepare($kit_data);
					$statement->execute();
					$data = $statement->fetchAll();
					foreach($data as $row) {
						$kitID = $row['kitID'];
						$testName = $row['testName'];
						$availableStock = $row['availableStock'];
				?>
				
				<tr>
					<td class='table_testName'> <?php echo $testName ?> </td>
					<td class='table_stock'> <?php echo $availableStock ?><button class='btn btn-link' data-toggle='modal' data-target='#addStock<?php echo $kitID?>'> Add </button>
					</td> 
				</tr>

				<div class="modal fade" id="addStock<?php echo $kitID ?>">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<h2 class="modal-title">Adding Stock</h2>
								<button class="close" data-dismiss="modal">&times;</button>
							</div>
							<div class = "modal-body">
								<form role="form" method="post" action="kitStock.php" id="stockForm<?php echo $testName; ?>" name="stockForm" onsubmit="return addStockForm(this.id);">
									<div class="form-group">
										<!-- <label>Test Name</label> -->
										<h3> <?php echo $testName ?> </h3>
										<input type = "text" name="kID" id="kID" value="<?php echo $kitID ?>" hidden>
										<input type = "text" name="tname" id="tname" value="<?php echo $testName ?>" hidden>

									</div>
									<div class="form-group">
										<label>Stock Number</label>
										<input type="number" name="stockNo" class="form-control" id="stockNo" min="0" value="0"> 
										<span class = "invalid-feedback" id = "stockNoErr_stockForm<?php echo $testName; ?>"> *Must be greater than or equal to 1.</span>
									</div>

									<div class="text-center pt-4">
										<button type="submit"  value="updateStock" name="updateStock" class="btn btn-success btn-block">Confirm</button>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>

				<?php } ?>			
			</table>
		</div>
					
	</div>

    <div class="addKit">
		<div class = "container">
			<div class="modal fade" id="newKit">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<h2 class="modal-title">Add New Test Kit</h2>
							<button class="close" data-dismiss="modal">&times;</button>
						</div>
						<div class = "modal-body">
							<form role="form" method="post" action="kitStock.php" name="newKitForm" onsubmit="return addKitForm(this);">
								<div class="form-group">
                                    <label>Test Name</label>
                                    <input type="text" name="testName" class="form-control" id="testName" autofocus>
                                    <span class = "invalid-feedback" id = "testNameError"> *Please enter a test name.</span>
								</div>
								<div class="form-group">
									<label>Stock Number</label>
									<input type="number" name="stockNum" class="form-control" id="stockNum" min="0" value="0"> 
									<span class = "invalid-feedback" id = "stockNumError"> *Must be greater than or equal to 1.</span>
								</div>

								<div class="text-center pt-4">
								    <button type="submit" value="createKit" name="createKit" class="btn btn-success btn-block">Submit</button>
								</div>
							  </form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<script>
    function addKitForm()
		{
			var testName=document.newKitForm.testName;
			var stockNum=document.newKitForm.stockNum;

			var errorMsg = 0;

			if(testName.value == "") {
                document.getElementById('testNameError').style.display = 'block';
                return false;
				errorMsg++;
            } else {
				document.getElementById('testNameError').style.display = 'none';
			}

			if(stockNum.value =="" ) {
				document.getElementById('stockNumError').style.display = 'block';
				return false;
				errorMsg++;
			} else if (stockNum.value < 1){
				document.getElementById('stockNumError').style.display = 'block';
				return false;
			} else {
				document.getElementById('stockNumError').style.display = 'none';
			}

			if(errorMsg != 0){
				if(testName.value == "") {
					testName.focus();
				} else if(stockNum.value =="" || stockNum.value < 1) {
					stockNum.focus();
				} 
				return false;
			} 
		}

		function addStockForm(stockFormID)
		{
			var stockNo=document.getElementById(stockFormID).elements['stockNo'];


			if(stockNo.value =="" ) {
				document.getElementById('stockNoErr_'+stockFormID).style.display = 'block';
				return false;
				
			} else if (stockNo.value < 1){
				document.getElementById('stockNoErr_'+stockFormID).style.display = 'block';
				return false;
			} else {
				document.getElementById('stockNoErr_'+stockFormID).style.display = 'none';
			}

			// alert('this is id'+stockFormID);
		}
    
	
	</script>

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

