<?php
	// Start the session
	session_start();

    $selectedUserID = $_SESSION['UserID'];
    $selectedUserType = $_SESSION['UserType'];
	$selectedTeamID = $_SESSION['TeamID'];
	$selectedTeamName = $_SESSION['TeamName'];
	$selectedUserEnabled = $_SESSION['Enabled'];

	//check if the user has logged in
	if (!isset($_SESSION['UserID'])){
    	echo "<script> window.location.assign('1_Login.php'); </script>";}

	//PHP web page begin
	include("CONFIG/connection.php");  //include the database connection 
	include("LIBRARY/helperFunctionsTables.php");  //include the database connection 
	include("LIBRARY/helperFunctionsDatabase.php");  //include the database connection 
	require_once("CONFIG/config.php");  //include the application configuration settings
?>

<META HTTP-EQUIV="Content-Type" CONTENT="text/html;" charset="UTF-8">

<html>
	<head>
		<title>MySQLi</title>
			<link rel="stylesheet" type="text/css" href="<?php echo __CSS;?>">
				<!--bootstrap-->
			<link href="CSS/bootstrap.min.css" rel="stylesheet" media="screen">
	</head>
<body>

<!----------------- HEADER SECTION ------------------------>
<!--====================================================-->

	<div class="container">
		<div class="row">
			<div class="col-xs-12 col-md-12">
				<div id="header_option">
				<a href="2_Index.php">
					<?php 
						include("PAGE_CONTENT/header.php"); 
					?> 
				</a>
				</div>
			</div><!--end of col-->
		</div><!--end of row-->

<!------------------NAVIGATION SECTION------------------------>
<!--========================================================-->

		<div class="row">
				<div class="col-xs-12 col-md-12">
					<div id="navigation_option">
					<?php 
						switch ($selectedUserType){
							case 1:
								include("PAGE_CONTENT/navigation_level_1.php");
								break;
							case 2:
								include("PAGE_CONTENT/navigation_level_2.php");
								break;
							case 3:
								include("PAGE_CONTENT/navigation_level_3.php");
								break;
							default:
							echo "<script> window.location.assign('1_Login.php'); </script>";
						}
					?> 
					</div>
				</div><!--end of col-->
		</div><!--end of row-->
	
		<div class="row">
				<div class="col-xs-12 col-md-12">
						<div id="navigation_option">
								<h1><?php echo $selectedTeamName; ?> RPE Entry</h1>
						</div><br>
				</div><!--end of col-->
		</div><!--end of row-->

<!------------------MAIN SECTION------------------------------>
<!--========================================================-->

	<div id="indexpage_box_container">
		<div class="row">
			<div class="col-xs-12 col-md-12">
				<form class="" method="post" autocomplete="off" action="<?php echo $_SERVER['PHP_SELF'];?>">
						<h2 id="displayGAAuserformheader">Enter Player RPE</h2>
									<?php

										if(isset($_POST['SAVE'])) { //if the form has been submitted previously
											$trainingID=$_POST['SAVE'];
											$table='rpe_player_load';  //table to insert values into
	
											//$sqlData="CALL gaaplayermanager2.fourProfileRPEtrainings($trainingID)";
											$sqlData="SELECT * FROM gaaplayermanager2.training WHERE Training_ID = $trainingID;";
											$rsData=getTableData($conn,$sqlData);
											$arrayData=checkResultSet($rsData);
											foreach($arrayData as $row) {
												$trainingid = $row['Training_ID'];
												$training_date = $row['Training_Date'];
												$rpelowlimit = $row['RPE_Low_Limit'];
												$rpeestlimit = $row['RPE_Estimated_Limit'];
												$rpehighlimit = $row['RPE_Upper_Limit'];
											}

											//get the values entered in the form	
											$trainingsession=$conn->real_escape_string($_POST['Training']);
											$playerrpe=$conn->real_escape_string($_POST['PlayerRPE']);
											$sessionlenght=$conn->real_escape_string($_POST['SessionLenght']);
											$notes=$conn->real_escape_string($_POST['Notes']);
											//$sqlInsert="CALL gaaplayermanager2.fourProfileRPEinsert($selectedUserID, $trainingid, $training_date, $playerrpe, $sessionlenght, $rpelowlimit, $rpeestlimit, $rpehighlimit,'$notes')";
											$sqlInsert= "INSERT INTO rpe_player_load (PL_User_ID, PL_Training_ID, PL_Training_Date, PL_Players_RPE, PL_Players_Training_Lenght, PL_Estimated_RPE_Lower_Limit, PL_Estimated_RPE_Limit, PL_Estimated_RPE_Upper_Limit, Note) VALUES('$selectedUserID','$trainingid','$training_date','$playerrpe','$sessionlenght','$rpelowlimit','$rpeestlimit','$rpehighlimit','$notes');";
		
											if(queryInsert($conn,$sqlInsert)==1) {//execute the INSERT query
												echo "<h3>New data inserted successfully</h3>";
												echo "<script> window.location.assign('4_Profiles.php'); </script>";
											}
											else {
												echo "<h3>Error data cannot be entered</h3>";
											}
										}

										if(isset($_POST['CANCEL']))	//execute the save button
										{
											echo "<script> window.location.assign('4_Profiles.php'); </script>";
										}

										else {
									?>
	


							<table class="npform">
								<tr><td>
									<label>
<!--Team-->
										<span>Training Session</span>
											<?php
												//$sqlData = "CALL gaaplayermanager2.fourProfileRPEtrainingsessions($selectedTeamID)";
												$sqlData="SELECT * FROM gaaplayermanager2.training AS t INNER JOIN gaaplayermanager2.training_type AS tt ON t.Training_Type_Training_Type_ID = tt.Training_Type_ID WHERE Team = $selectedTeamID;";
												$rsData=getTableData($conn,$sqlData);
												$arrayData=checkResultSet($rsData);
												echo "<select name=\"Training\" style=\"overflow:scroll\" !important >";
												echo "<option>Select Training Date</option>";
												foreach($arrayData as $row) {
													$training = $row['Training_Date']. ' - ' .$row['Training_Type'];
													$trainingid=$row['Training_ID'];  //get the current PK value
											?>
											<option value="<?php echo $id; ?>"><?php echo $training; ?></option>
											<?php 	
												} 	
											?>
											</select><br>

<!--RPE Training Load-->
										<span>RPE Training Load</span>
											<?php
												//$sqlData = "CALL gaaplayermanager2.fourProfileRPEnumbers()";
												$sqlData="SELECT * FROM gaaplayermanager2.rpe_number;";
												$rsData=getTableData($conn,$sqlData);
												$arrayData=checkResultSet($rsData);
												echo "<select name=\"PlayerRPE\">";
												echo "<option>Select Your Estimated RPE</option>";
												foreach($arrayData as $row) {
													$rpenumber = $row['RPE_Number'];
													$id=$row['RPE_ID'];  //get the current PK value
											?>
										<span>Team</span>
											<option value="<?php echo $id; ?>" ><?php echo $rpenumber; ?></option>
											<?php 	} 	?>
												</select><br>
										<span>Date of other session</span>
											<input name="DateOfOtherSession" type="date" title="yyyy/mm/dd" pattern="[a-zA-Z0-9óáéí']{1,48}"><br>

<!--Lenght of training session-->
										<span>Lenght of training session</span>
											<input name="SessionLenght" id="SessionLenght" type="text" title="Lenght of training session" pattern="[0-9_]{1,3}"><br>

<!--Notes-->
										<span>Notes</span>
											<input name="Notes" type="text"  title="Notes" pattern="[a-zA-Z0-9óáéí' ]{1,200}" data-tip="Enter Match Notes"><br>
									
									<label>
										<button class="playerprofilemenubutton" name="SAVE" type="submit" value="<?php echo $trainingid;?>">Save</button>
										<button class="playerprofilemenubutton" name="CANCEL" type="submit" value="">Cancel</button>
									</label>
								</td></tr>
							</table>
				</form>
			</div><!--end of col-->
		</div><!--end of row-->
											<?php } ?>


<!------------------FOOTER section---------------------------->
<!--========================================================-->
		
		<div class="row">
			<div class="col-xs-12 col-md-12">
				<?php
					//warn DEBUG  mode is on
					if (__DEBUG==1) {	
						echo '<footer class="debug">';
						echo "SQL= $sqlLogin <br>";
						echo 'Resultset: ';
						print_r($rs);
						echo "</footer>"; }
					else {
						echo '<footer class="copyright">';
						echo 'Copyright 2016 GAA Player Manager';
						echo "</footer>"; }
				?>

			</div><!--end of col-->
		</div><!--end of row-->
	</div><!--end indexpage_box_container-->
</div><!--end of container-->

</body>
</html>
