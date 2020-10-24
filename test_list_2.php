<?php
include('dbcon.php');
session_start();

if(!isset($_SESSION['username'])){
	echo "<script>alert('Please login first!')</script>";
	echo "<script>window.open('index.php','_self')</script>";
}else{
	$username = $_SESSION['username'];
	$findCentre = "select * from user where username='$username'";
	$statement = $dbcon->prepare($findCentre);
	$statement->execute();

	if($row=$statement->fetch()){
		$centreID = $row['centreID'];
	}
}

if(isset($_POST['recordTest'])){
	$testKitID=$_POST['testName'];
	$patientUsername=$_POST['patientUsername'];
	$patientPassword=$_POST['patientPassword'];
	$patientName=$_POST['patientName'];
	$patientType=$_POST['patientType'];
	$symptoms=$_POST['patientSymptoms'];
	$testDate= date("Y-m-d");

	$checkPatient = "select * from User where username='$patientUsername'";
	$statement = $dbcon->prepare($checkPatient);
	$statement->execute();
	if($row=$statement->fetch()){
		echo "<script> alert('User exist!'); </script>";
	} 
	else {
		

		$hashed_patientPassword = password_hash($patientPassword, PASSWORD_DEFAULT);
		$addPatient = "insert into user (username, password, name, type, patientType, symptoms, centreID) 
				  values ('$patientUsername','$hashed_patientPassword','$patientName','patient','$patientType','$symptoms', '$centreID')";
		$recordTest = "insert into covidtest (testDate, kitID, patientUsername, testerUsername, status) values ( '$testDate', '$testKitID', '$patientUsername', '$username', 'pending')";
		$statement2 = $dbcon->prepare($addPatient);
		$statement3 = $dbcon->prepare($recordTest);

		if($statement2->execute()){
			if($statement3->execute()){
				
				$reduce_stock="Update testKit set availableStock=availableStock-1 where kitID=$testKitID";
				$statement3 = $dbcon->prepare($reduce_stock);
				if($statement3->execute()){
					echo "<script>alert('Test has recorded!')</script>";
				} else {
					echo "<script>alert('Stock Reduce Failed!')</script>";
				}
			} else {
				echo "<script>alert('Test added error!')</script>";
			}
		} else {
			echo "<script>alert('Patient added error!')</script>";
		}
	}
}
else if(isset($_POST['patientrecordNewTest'])){
	$puname=$_POST['patient_username'];
	$test_kitID=$_POST['test_kitID'];
	$tDate= date("Y-m-d");

	$patient_new_test = "insert into covidtest (testDate, kitID, patientUsername, testerUsername, status) values ( '$tDate', '$test_kitID', '$puname', '$username', 'pending')";
	$statement = $dbcon->prepare($patient_new_test);
	if($statement->execute()){
		$reduceStock="Update testKit set availableStock=availableStock-1 where kitID=$test_kitID";
				$statement2 = $dbcon->prepare($reduceStock);
				if($statement2->execute()){
					echo "<script>alert('Test Record Successfully!')</script>";
				} else {
					echo "<script>alert('Stock Reduce Failed!')</script>";
				}
	} else {
		echo "<script>alert('Test Record Failed')</script>";
	}
} 
else if(isset($_POST['updatePatient'])){
	$p_uname=$_POST['pusername'];
	$p_type=$_POST['patientType'];
	$p_symptoms=$_POST['patientSymptoms'];

	$update_patient="update user set patientType='$p_type', symptoms='$p_symptoms' where username='$p_uname' AND type='patient'";
	$statement=$dbcon->prepare($update_patient);
	if($statement->execute()){
		echo "<script> alert('$p_uname\' updated successfully!'); </script>";
	}
} 
else if(isset($_POST['updateTestResult'])){
	$p_uname=$_POST['pusername'];
	$test_id=$_POST['test_id'];
	$test_result=$_POST['testResult'];
	$result_date= date("Y-m-d");

	$update_test="update covidTest set result='$test_result', resultDate='$result_date',status='complate' where testID='$test_id'";
	$statement=$dbcon->prepare($update_test);
	if($statement->execute()){
		echo "<script> alert('$test_id\'s result has been updated!'); </script>";
	}
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
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	
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
	<script src='https://kit.fontawesome.com/a076d05399.js'></script>
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
								<span> <?php echo "$username,$centreID"?> <span>
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
									<li class="nav-item active" id="function"><a href="test_list.php">Test</a></li>
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
    
	<div class="test">
		<div class="container">
			<div class="test_action">
				<button class="btn btn-primary" data-toggle="modal" data-target="#recordNewTest"> <i class="fa fa-plus"> </i> &nbsp; Add New Test </button>
			</div>
			<div class="patient-table">
				<h3> Patient </h3>
				<table class="table table-hover">
					<tr class="thead">
						<th> Patient Username </th>
						<th> Patient Name </th>
						<th> Patient Type </th>
						<th> Symptoms </th>
						<th colspan="2"> Action </th>
					</tr>
					<!-- Display all patient -->
					<?php
						$patient_data="select * from user where centreID='$centreID' AND type='patient'";
						$statement_1=$dbcon->prepare($patient_data);
						$statement_1->execute();
						$data=$statement_1->fetchAll();
						foreach($data as $row){
							$pusername=$row['username'];
							$ppassword=$row['password'];
							$pname=$row['name'];
							$ptype=$row['patientType'];
							$psymptoms=$row['symptoms'];
					?>
					<tr class="patientTest">
						<td> <span></span> <?php echo $pusername ?> </td>
						<td> <?php echo $pname ?> </td>
						<td> <?php echo $ptype ?> </td>
						<td> <?php echo $psymptoms ?> </td>
						<td colspan="2"> 
							<button class="btn btn-light" data-toggle='modal' data-target='#editPatient_<?php echo $pusername ?>'><i class="fas fa-user-edit"> </i> </button>
							<button class="btn btn-light" data-toggle='modal' data-target='#patientNewTest_<?php echo $pusername ?>'><i class="far fa-file-alt"> </i> </button>
							<!-- <button class="btn btn-light"> New Test </button> -->
						</td>
					</tr>
					
					<div class="editPatient">
						<div class="modal fade" id="editPatient_<?php echo $pusername ?>">
							<div class="modal-dialog">
								<div class="modal-content">
									<div class="modal-header">
										<h2 class="modal-title"> Edit </h2>
										<!-- <button class="close" data-dismiss="modal">&times;</button> -->
									</div>
									<div class="modal-body">
									<form role="form" method="post" action="test_list.php" id="editPatientForm<?php echo $pusername; ?>" name="editPatientForm" onsubmit="return updatePatientForm(this.id);">
										<div class="form-group">
											<label> Patient Username </label>
											<input type = "text" class="form-control" value="<?php echo $pusername; ?>" disabled>
											<input type = "hidden" class="form-control" name="pusername" id="pusername" value="<?php echo $pusername; ?>">

										</div>
										<div class="form-group">
											<label>Patient password</label>
											<input type="password" name="patientPassword" class="form-control" id="patientPassword" value="<?php echo $ppassword ?>" disabled>
										</div>
										<div class="form-group">
											<label>Patient Name</label>
											<input type="text" name="patientName" class="form-control" id="patientName" value="<?php echo $pname ?>" disabled>
										</div>
										<div class="form-group">
											<label>Patient Type</label>
											<select class="form-control" name="patientType" id="patientType">
											<option value=""> -- </option>
											<option value="Returnee" <?php if($ptype=="Returnee"){echo "selected";} ?>> Returnee </option>
											<option value="Quarantined"  <?php if($ptype=="Quarantined"){echo "selected";} ?>> Quarantined </option>
											<option value="Close Contact"  <?php if($ptype=="Close Contact"){echo "selected";} ?>> Close Contact </option>
											<option value="Infected"  <?php if($ptype=="Infected"){echo "selected";} ?>> Infected </option>
											<option value="Suspected"  <?php if($ptype=="Suspected"){echo "selected";} ?>> Suspected </option>
											</select>
											<span class = "invalid-feedback" id = "patientTypeErr_editPatientForm<?php echo $pusername; ?>"> *Please select one patient type</span>
										</div>
										<div class="form-group">
											<label>Symptoms</label>
											<input type="text" name="patientSymptoms" class="form-control" id="patientSymptoms" value="<?php echo $psymptoms ?>">
											<span class = "invalid-feedback" id = "patientSymptomsErr_editPatientForm<?php echo $pusername; ?>"> *Please enter symptoms.</span>
										</div>

										<div class="text-center pt-4">
											<button type="submit"  value="updatePatient" name="updatePatient" class="btn btn-success btn-block">Save</button>
										</div>
									</form>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="patientNewTest">
						<div class="modal fade" id="patientNewTest_<?php echo $pusername ?>">
							<div class="modal-dialog">
								<div class="modal-content">
									<div class="moda;-header">
										<h2 class="modal-title"> New Test </h2>
										<!-- <button class="close" data-dismiss="modal">&times;</button> -->
									</div>
									<div class="modal-body">
									<form role="form" method="post" action="test_list.php" id="recordPatientTestForm<?php echo $pusername; ?>" name="recordPatientTestForm" onsubmit="return updatePatient(this.id);">
										<div class="form-group">
											<label> Patient Username </label>
											<input type = "text" class="form-control" value="<?php echo $pusername; ?>" disabled>
											<input type = "hidden" class="form-control" name="patient_username" id="patient_username" value="<?php echo $pusername; ?>">

										</div>
										<div class="form-group">
											<label>Patient Name</label>
											<input type="text" name="patient_name" class="form-control" id="patient_name" value="<?php echo $pname; ?>" disabled>
										</div>
										<div class="form-group">
											<label>Test Name</label>
											<!-- <input type="text" name="testName" class="form-control" id="centreName" autofocus> -->
											<select class="form-control" name="test_kitID" id="test_kitID" autofocus>
											<option value=""> -- </option>
											<?php 
											if($centreID != null){
												$find_testkit = "select * from testKit where centreID = '$centreID' AND availableStock>0";
												$statement_2 = $dbcon->prepare($find_testkit);
												$statement_2->execute();
												$kits_2 = $statement_2 -> fetchAll();
												foreach($kits_2 as $kit_2){
													$kitid = $kit_2['kitID'];
													$testname = $kit_2['testName'];
													echo "<option value='".$kitid."'>".$testname."</option>";
												}
											}
											?>
											</select>
											<span class = "invalid-feedback" id = "test_nameError"> *Please select one test.</span>
										</div>

										<div class="text-center pt-4">
											<button type="submit"  value="patientrecordNewTest" name="patientrecordNewTest" class="btn btn-success btn-block"> Add </button>
										</div>
									</form>
									</div>
								</div>
							</div>
						</div>
					</div>

				<?php } ?>
				</table>
					
			</div>

			<div class="test-table">
				<h3> Test </h3>
				<div class="searchBar">
					<input type="text" class="form-control" id="searchTest" placeholder="Search">
				</div>
				<br>
				<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
				<?php 
					$test_data="select * from covidTest where testerUsername='$username' AND status='pending'";
					$statement_01=$dbcon->prepare($test_data);
					$statement_01->execute();
					$data_01=$statement_01->fetchAll();
					foreach($data_01 as $row_01){
						$test_ID=$row_01['testID'];
						$kit_ID=$row_01['kitID'];
						$patient_username=$row_01['patientUsername'];
						$test_date=$row_01['testDate'];
						$test_status=$row_01['status'];
						$result_date=$row_01['resultDate'];
						$test_result=$row_01['result'];

						$find_kit="select * from testKit where kitID='$kit_ID'";
						$statement_02=$dbcon->prepare($find_kit);
						$statement_02->execute();
						if($row_02=$statement_02->fetch()){
							$test_name=$row_02['testName'];
						
				?>
					
					<div class="panel panel-default" id="collapse_container">
						<div class="panel-heading">
							<h4 class="panel-title">
								<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $test_ID.'_'.$patient_username ?>"> <strong><?php echo $test_name ?></strong><span> ID: <?php echo $test_ID ?> </span> </a>
							</h4>
						</div>
						<div id="collapse<?php echo $test_ID.'_'.$patient_username ?>" class="panel-collapse collapse" role="tabpanel">
							<div class="panel-body">
							<?php
							$find_patient="select * from user where username='$patient_username' AND type='patient'";
							$statement_03=$dbcon->prepare($find_patient);
							$statement_03->execute();
							if($row_03=$statement_03->fetch()){
								$patient_name=$row_03['name'];
							?>
								<p> Patient Username:  	<?php echo $patient_username ?></p>
								<p> Patient Name: 		<?php echo $patient_name ?></p>
								<p> Test Date:			<?php echo $test_date ?></p>
								<p> Result:				<?php echo $test_result ?></p>
								<p> Result Date:		<?php echo $result_date ?></p>
								<p> Status: 			<?php echo $test_status ?></p>
								<button class="btn btn-success" data-toggle='modal' data-target='#updateTest_<?php echo $test_ID ?>'> Update </button>
							</div>
						</div>
					</div>
						

					<div class="updateTest">
						<div class="modal fade" id="updateTest_<?php echo $test_ID ?>">
							<div class="modal-dialog">
								<div class="modal-content">
									<div class="moda;-header">
										<h2 class="modal-title"> Update Test </h2>
										<!-- <button class="close" data-dismiss="modal">&times;</button> -->
									</div>
									<div class="modal-body">
									<form role="form" method="post" action="test_list.php" id="updateTestForm<?php echo $test_ID; ?>" name="updateTestForm" onsubmit="return updateTestResultForm(this.id);">
									<div class="form-group">
											<label> Test ID </label>
											<input type = "text" class="form-control" value="<?php echo $test_ID?>" disabled>
											<input type = "hidden" class="form-control" name="test_id" id="test_id" value="<?php echo $test_ID?>" >
										</div>
										
										<div class="form-group">
											<label> Test Name </label>
											<input type = "text" class="form-control" name="test_name" id="test_name" value="<?php echo $test_name ?>" disabled>
										</div>
										
										<div class="form-group">
											<label> Patient Username </label>
											<input type = "text" class="form-control" value="<?php echo $patient_username ?>" disabled>
											<input type = "hidden" class="form-control" name="pusername" id="pusername" value="<?php echo $patient_username ?>">
										</div>

										<div class="form-group">
											<label>Patient Name</label>
											<input type="text" name="patientName" class="form-control" id="patientName" value="<?php echo $patient_name ?>" disabled>
										</div>

										<div class="form-group">
											<label>Result</label>
											<input type="text" name="testResult" class="form-control" id="testResult" autofocus>
											<span class = "invalid-feedback" id = "testResultErr_updateTestForm<?php echo $test_ID; ?>"> *Please enter symptoms.</span>
										</div>

										<div class="text-center pt-4">
											<button type="submit"  value="updateTestResult" name="updateTestResult" class="btn btn-success btn-block">Save</button>
										</div>
									</form>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div>
					</div>
					<?php }}} ?>
				</div>
			</div>
			
		</div>
		
	</div>

	<div class="recordTest">
		<div class = "container">
			<div class="modal fade" id="recordNewTest">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							
							<h2 class="modal-title">Add New Test</h2>
							<button class="close" data-dismiss="modal">&times;</button>
							
						</div>

						<div>
						<ul class="nav nav-tabs">
							<li class="nav-item active"><a class="nav-link active text-primary " data-toggle="tab" href="#newPatient" id="pills-newPatient-tab">New Patient</a></li>
							<li class="nav-item"><a class="nav-link text-primary" data-toggle="tab" href="#currentPatient" id="pills-currentPatient-tab">In Patient</a></li>
						</ul>
						</div>
						
						<div class = "modal-body">
							<div class="tab-content" id="pills-tabContent">
								<div id="newPatient" class="tab-pane fade in active" role="tabpanel" aria-labelledby="pills-newPatient-tab">
									<h3>New Test</h3>
									<form role="form" method="post" action="test_list.php" name="newTestForm" onsubmit="return recordTestForm(this);">
										<div class="form-group">
											<label>Test Name</label>
											
											<select class="form-control" name="testName" id="testName" autofocus>
											<option value=""> -- </option>
											<?php 
											if($centreID != null){
												$findTestKit = "select * from testKit where centreID = '$centreID' AND availableStock>0";
												$statement = $dbcon->prepare($findTestKit);
												$statement->execute();
												$kits = $statement -> fetchAll();
												foreach($kits as $kit){
													$kitID = $kit['kitID'];
													$testName = $kit['testName'];
													echo "<option value='".$kitID."'>".$testName."</option>";
												}
											}
											?>
											</select>
											<span class = "invalid-feedback" id = "testNameError"> *Please select one test.</span>
										</div>
										
										<div class="form-group">
											<label>Patient Username</label>
											<input type="text" name="patientUsername" class="form-control" id="patientUsername">
											<span class = "invalid-feedback" id = "patientUsernameError"> *Please enter a centre name.</span>
										</div>
										<div class="form-group">
											<label>Patient password</label>
											<input type="password" name="patientPassword" class="form-control" id="patientPassword">
											<span class = "invalid-feedback" id = "patientPasswordError"> *Please enter a password.</span>
										</div>
										<div class="form-group">
											<label>Patient Name</label>
											<input type="text" name="patientName" class="form-control" id="patientName">
											<span class = "invalid-feedback" id = "patientNameError"> *Please enter a name.</span>
										</div>
										<div class="form-group">
											<label>Patient Type</label>
											<select class="form-control" name="patientType" id="patientType">
											<option value=""> -- </option>
											<option value="Returnee"> Returnee </option>
											<option value="Quarantined"> Quarantined </option>
											<option value="Close Contact"> Close Contact </option>
											<option value="Infected"> Infected </option>
											<option value="Suspected"> Suspected </option>
											</select>
											<span class = "invalid-feedback" id = "patientTypeError"> *Please select one patient type</span>
										</div>
										<div class="form-group">
											<label>Symptoms</label>
											<textarea class="form-control" name="patientSymptoms" id="patientSymptoms" rows="5"> </textarea>
											
											<span class = "invalid-feedback" id = "patientSymptomsError"> *Please enter symptoms.</span>
										</div>

										<div class="text-center pt-4">
											<button type="submit" value="recordTest" name="recordTest" class="btn btn-success btn-block">Submit</button>
										</div>
									</form>
								</div>

								<div id="currentPatient" class="tab-pane fade" role="tabpanel" aria-labelledby="pills-currentPatient-tab">
									<h3>Menu 1</h3>
									<form role="form" method="post" action="test_list.php" name="newTestForm" onsubmit="return recordTestForm(this);">
										<div class="form-group">
											<label>Test Name</label>
											
											<select class="form-control" name="testName" id="testName" autofocus>
											<option value=""> -- </option>
											<?php 
											if($centreID != null){
												$findTestKit = "select * from testKit where centreID = '$centreID' AND availableStock>0";
												$statement = $dbcon->prepare($findTestKit);
												$statement->execute();
												$kits = $statement -> fetchAll();
												foreach($kits as $kit){
													$kitID = $kit['kitID'];
													$testName = $kit['testName'];
													echo "<option value='".$kitID."'>".$testName."</option>";
												}
											}
											?>
											</select>
											<span class = "invalid-feedback" id = "testNameError"> *Please select one test.</span>
										</div>
										
										<div class="form-group">
											<label>Patient Username</label>
											<input type="text" name="patientUsername" class="form-control" id="patientUsername">
											<span class = "invalid-feedback" id = "patientUsernameError"> *Please enter a centre name.</span>
										</div>
										
										<div class="form-group">
											<label>Patient Name</label>
											<input type="text" name="patientName" class="form-control" id="patientName">
											<span class = "invalid-feedback" id = "patientNameError"> *Please enter a name.</span>
										</div>
										
										<div class="text-center pt-4">
											<button type="submit" value="recordTest" name="recordTest" class="btn btn-success btn-block">Submit</button>
										</div>
									</form>
								</div>
								
							</div>
							
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

	<script>
    function recordTestForm(){
		var kitID=document.newTestForm.testName;
		var patientUsername=document.newTestForm.patientUsername;
		var patientPassword=document.newTestForm.patientPassword;
		var patientName=document.newTestForm.patientName;
		var patientType=document.newTestForm.patientType;
		var symptoms=document.newTestForm.patientSymptoms;
		
		var errorMsg = 0;

		if(kitID.value == "") {
			document.getElementById('testNameError').style.display = 'block';
			return false;
			errorMsg++;
		} else {
			document.getElementById('testNameError').style.display = 'none';
		}

		if(patientUsername.value =="" ) {
			document.getElementById('patientUsernameError').style.display = 'block';
			return false;
			errorMsg++;
		} else {
			document.getElementById('patientUsernameError').style.display = 'none';
		}

		if(patientPassword.value == ""){
			document.getElementById("patientPasswordError").style.display = "block";
			return false;
			errorMsg++; 
		} else if(!patientPassword.value.match(/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z]{8,20}$/)){
			document.getElementById("patientPasswordError").innerHTML="*Please enter a password length of 8 - 20, at least one number, one lower case and one upper case letter.";
			document.getElementById("patientPasswordError").style.display = "block";
			return false;
			errorMsg++;
		} else {
			document.getElementById("patientPasswordError").style.display = "none";
		}

		if(patientName.value =="" ) {
			document.getElementById('patientNameError').style.display = 'block';
			return false;
			errorMsg++;
		} else {
			document.getElementById('patientNameError').style.display = 'none';
		}

		if(patientType.value =="" ) {
			document.getElementById('patientTypeError').style.display = 'block';
			return false;
			errorMsg++;
		} else {
			document.getElementById('patientTypeError').style.display = 'none';
		}

		if(symptoms.value =="" ) {
			document.getElementById('patientSymptomsError').style.display = 'block';
			return false;
			errorMsg++;
		} else {
			document.getElementById('patientSymptomsError').style.display = 'none';
		}


		if(errorMsg != 0){
			if(kitID.value == "") {
				kitID.focus();
			} else if(patientUsername.value == "") {
				patientUsername.focus();
			} else if(patientPassword.value == "" || !password.value.match(/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z]{8,20}$/)) {
				patientPassword.focus();
			} else if(patientName.value==""){
				patientName.focus();
			} else if(patientType.value==""){
				patientType.focus();
			} else {
				symptoms.focus();
			}
			return false;
		} 
	}
    
	function updatePatientForm(editFormID) {
		var patientType = document.getElementById(editFormID).elements['patientType'];
		var symptoms = document.getElementById(editFormID).elements['patientSymptoms'];

		var errorMsg = 0;

		if(patientType.value =="" ) {
			document.getElementById('patientTypeErr_'+editFormID).style.display = 'block';
			return false;
			errorMsg++;
		} else {
			document.getElementById('patientTypeErr_'+editFormID).style.display = 'none';
		}

		if(symptoms.value =="" ) {
			document.getElementById('patientSymptomsErr_'+editFormID).style.display = 'block';
			return false;
			errorMsg++;
		} else {
			document.getElementById('patientSymptomsErr_'+editFormID).style.display = 'none';
		}

		if(errorMsg !=0){
			if(patientType.value==""){
				patientType.focus();
			} else {
				symptoms.focus();
			}
			return false;
		}
	} 

	function updateTestResultForm(editFormID) {
		var testResult = document.getElementById(editFormID).elements['testResult'];

		if(testResult.value =="" ) {
			document.getElementById('testResultErr_'+editFormID).style.display = 'block';
			return false;

		} else {
			document.getElementById('testResultErr_'+editFormID).style.display = 'none';
		}

	} 

	function patientRecord(){
		
	}

	//expand table row
	$('.patientTest').click(function(){
			$(this).nextUntil('tr.patientTest').slideToggle(0);
		});

	$(document).ready(function(){
		var panelContainerId;
		$("#searchTest").on("keyup", function() {
			var value = $(this).val().toLowerCase();
			$("#accordion .panel").filter(function() {
				$(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
			});
			// $('#accordion > .panel').each(function () {
			// 	panelContainerId = '#' + $(this).attr('id');
			// 	console.log(panelContainerId);
			// 	console.log(value);
			// 	$(panelContainerId + ':not(:containsCaseInsensitive(' + value + '))').hide();
			// 	$(panelContainerId + ':containsCaseInsensitive(' + value + ')').show();
			// 	});
				console.log(panelContainerId);			
			});
	});
	</script>

	</body>
</html>
