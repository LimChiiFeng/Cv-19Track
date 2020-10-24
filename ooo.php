<div class="card" id="test-data">
						<div class="card-header">
							<button class="btn btn-link" data-toggle="collapse" data-target="#collapse<?php echo $test_ID ?>"><strong><?php echo $test_name ?></strong><span> ID: <?php echo $test_ID ?> </span></button>
						</div>
						<div id="collapse<?php echo $test_ID ?>" class="collapse" data-parent="#accordion">
							<div class="card-body">
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

					<div class="panel panel-default" id="collapseOne_container">
						<div class="panel-heading">
							<h4 class="panel-title">
								<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $test_ID ?>"> <strong><?php echo $test_name ?></strong><span> ID: <?php echo $test_ID ?> </span> </a>
							</h4>
						</div>
						<div id="collapse<?php echo $test_ID ?>" class="panel-collapse collapse" role="tabpanel">
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

					<div class="modal-header">
						<ul class="nav nav-tabs justify-content-center pt-4" id="pills-tab" role="tablist">
							<li class="nav-item">
							<a class="nav-link active text-primary" id="pills-login-tab" data-toggle="pill" href="#pills-login" role="tab" aria-controls="pills-login"
								aria-selected="true">New Patient</a>
							</li>

							<li class="nav-item">
							<a class="nav-link text-primary" id="pills-register-tab" data-toggle="pill" href="#pills-register" role="tab" aria-controls="pills-register"
								aria-selected="false">Exist Patient</a>
							</li>
						</ul>
					</div>