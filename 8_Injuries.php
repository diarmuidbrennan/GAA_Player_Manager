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
			</div>
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
				</div>
		</div><!--end of row-->
	
		<div class="row">
				<div class="col-xs-12 col-md-12">
						<div id="navigation_option">
								<h1><?php echo $selectedTeamName; ?> Injuries</h1>
						</div><br>
				</div>
		</div><!--end of row-->

<!------------------MAIN SECTION------------------------------>
<!--========================================================-->
		<div id="indexpage_box_container">
			<div class="row">
				<div class="col-xs-12 col-md-6">
					<h2 class="index_headers" >Injuries</h2>
					    <div class="indexpage_box" style="overflow:scroll">
					<?php 
						$table='injury';  //table to delete records from
						$PK="Injury_ID";
						$Team="Team_ID";  //Specify the PK of the table
					
						//edit an existing injury
						if(isset($_POST['editrecord']))  {//if the form has been submitted 
							$selectedID=$_POST['editrecord'];  //get the ID of the record we want to edit from the form
							$_SESSION['primarykey'] = $selectedID;
							echo "<script> window.location.assign('8.2_Injuries_Edit.php'); </script>";
						}

						//create a new injury
						if(isset($_POST['Create']))  {//if the form has been submitted 
							echo "<script> window.location.assign('8.1_Injuries_Create.php'); </script>";
						}

						else {
							//$sqlDataInjury="CALL gaaplayermanager2. eightInjuriesGetAll ($selectedTeamID)";
							$sqlDataInjury="SELECT i.Injury_ID, u.First_Name, u.Last_Name, iu.Injury_Type, rs.Recovery_Status FROM gaaplayermanager2.injury AS i INNER JOIN gaaplayermanager2.users AS u ON u.User_ID = i.Users_User_ID INNER JOIN gaaplayermanager2.injury_types AS iu ON i.Injury_Types_Injury_Types_ID = iu.Injury_Types_ID INNER JOIN gaaplayermanager2.recovery_status AS rs ON rs.Recovery_Status_ID = i.Recovery_Status_Recovery_Status_ID WHERE i.Team_ID=$selectedTeamID ORDER BY i.Recovery_Status_Recovery_Status_ID ASC";
							$rsDataInjury=getTableData($conn,$sqlDataInjury);
							$arrayDataInjury=checkResultSet($rsDataInjury);
						foreach($arrayDataInjury as $row) {
							$name = $row['First_Name']. ' - ' .$row['Last_Name']. ' - ' .$row['Injury_Type']. ' - ' .$row['Recovery_Status'];
							$id=$row['Injury_ID'];  //get the current PK value
							$buttonText=$name;
							include 'FORMS/buttonWithText3.html';
							}
						}
					?>
						</div><br><br>
					<a class="index_page_buttons" href="8.1_Injuries_Create.php" role="button">Create Injury</a>
			</div>
<!--Injuries image-->
					<?php
						//$sqlinjurycount="CALL gaaplayermanager2.twoIndexcountinjuriesnum($selectedTeamID)";
						$sqlinjurycount="SELECT i.Injury_Types_Injury_Types_ID, it.Injury_Type, COUNT(it.Injury_Types_ID) FROM injury AS i INNER JOIN injury_types AS it ON i.Injury_Types_Injury_Types_ID = it.Injury_Types_ID WHERE Team_ID = $selectedTeamID GROUP BY i.Injury_Types_Injury_Types_ID;";
						$rsDatainjurycount=getTableData($conn,$sqlinjurycount);
						$arrayDatainjurycount=checkResultSet($rsDatainjurycount);
						$conn->close();
						$counter = 1;
						foreach($arrayDatainjurycount as $row) {
							$id=$row['COUNT(it.Injury_Types_ID)'];  //get the current PK value
							$counter = $row['Injury_Types_Injury_Types_ID'];
							$injarray[$counter] = $id;
							
							}

//error_reporting = E_ALL & ~E_DEPRECATED & ~E_STRICT
					?>
			<div class="col-xs-12 col-md-6">
				<h2 class="injuryimage_title">Player Injuries</h2>
					<div class="injury_image">
						<img id="injury_image_edit" src="IMAGES/injuryimage.jpg" />
						<div class="numberCircle1head" alt="head injury"><?php echo "$injarray[1]"; ?></div>
						<div class="numberCircle2shoulder"><?php echo "$injarray[2]"; ?></div>
						<div class="numberCircle3hand"><?php echo "$injarray[3]"; ?></div>
						<div class="numberCircle4knee"><?php echo "$injarray[4]"; ?></div>
						<div class="numberCircle5back"><?php echo "$injarray[5]"; ?></div>
						<div class="numberCircle6hip"><?php echo "$injarray[6]"; ?></div>
						<div class="numberCircle7groin"><?php echo "$injarray[7]"; ?></div>
						<div class="numberCircle8hamstring"><?php echo "$injarray[8]"; ?></div>
						<div class="numberCircle9quad"><?php echo "$injarray[9]"; ?></div>
						<div class="numberCircle10calf"><?php echo "$injarray[10]"; ?></div>
						<div class="numberCircle11ankle"><?php echo "$injarray[11]"; ?></div>
						<div class="numberCircle12foot"><?php echo "$injarray[12]"; ?></div>



					</div>
			</div>
		</div>

<!------------------FOOTER section---------------------------->
<!--========================================================-->
		
		<div class="row"><br>
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

				</div>
			</div><!--end of row-->
		</div><!--end indexpage_box_container-->
</div><!--end of container-->

</body>
</html>
















 



