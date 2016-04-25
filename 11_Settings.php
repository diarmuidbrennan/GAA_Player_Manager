<?php
	// Start the session
	session_start();

    $selectedUserID = $_SESSION['UserID'];
    $selectedUserType = $_SESSION['UserType'];
	$selectedTeamID = $_SESSION['TeamID'];
	$selectedTeamName = $_SESSION['TeamName'];
	$selectedUserEnabled = $_SESSION['Enabled'];

	//check if the user has logged in
	if (!isset($_SESSION['UserID'])) {
    	echo "<script> window.location.assign('1_Login.php'); </script>";
    }

    if (($_SESSION['UserType']==3) || ($_SESSION['UserType']==2)) {
    	echo "<script> window.location.assign('2_Index.php'); </script>";
    }

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

<!--//----------------NAVIGATION SECTION----------------------//-->
<!--//========================================================//-->

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
                				<h1>Administrator Settings</h1>
            			</div><br>
        		</div>
    	</div>

<!--//----------------MAIN SECTION----------------------------//-->
<!--//========================================================//-->

					<?php
						//Change Team_________________________________________________________________
						if(isset($_POST['SAVE'])) {	//execute the save button

						$team = $_POST["Teams"];
					    $team=$conn->real_escape_string($team);
						$sql = "UPDATE users SET"     //sql query for the update 
	    				. " " . "Team = '$team'"	
	    				. " WHERE User_ID = '$selectedUserID';";
	
						if (updateRecord($conn,$sql)) { //call the updateRecord() function
							echo "<h3>RECORD WITH PK=$selectedID UPDATED</h3>";
							
							$sqlDataUser="SELECT * FROM users AS u INNER JOIN team AS t ON u.Team = t.Team_ID WHERE u.User_ID = $selectedUserID;";
							$rsDataUser=getTableData($conn,$sqlDataUser);	
							$arrayDataUser=checkResultSet($rsDataUser);
							foreach($arrayDataUser as $row1) {

								}
							$TeamID=$row1['Team'];
							$TeamName=$row1['Name'];
							$_SESSION['TeamID'] = $TeamID;
							$_SESSION['TeamName'] = $TeamName;
							echo "<script> window.location.assign('11_Settings.php'); </script>";
						}
						else {
							echo "<h3 >RECORD WITH PK=$selectedID CANNOT BE UPDATED</h3>";
							echo "$sql";
						}
	

						//close the connection
						$conn->close();


						}

						//Edit Team Record_________________________________________________________________

						if(isset($_POST['editrecordteam']))  //if the form has been submitted 
						{
						$selectedID=$_POST['editrecordteam'];  //get the ID of the record we want to edit from the form
						$_SESSION['primarykey'] = $selectedID;
						echo "<script> window.location.assign('11.2_Settings_Edit_Team.php'); </script>";
						}

						//Edit Management User Record_________________________________________________________________

						if(isset($_POST['editrecord']))  //if the form has been submitted 
						{
						$selectedID=$_POST['editrecord'];  //get the ID of the record we want to edit from the form
						$_SESSION['primarykey'] = $selectedID;
						//echo "$selectedID";
						echo "<script> window.location.assign('11.4_Settings_Edit_Muser.php'); </script>";
						}
					?>


		<!--All the teams using the web app-->
		<div id="indexpage_box_container">

			<div class="row">
				<div class="col-xs-12 col-md-12">
					<div class="change_team">
						<h2 class="index_headers" >Choose a Team</h2>
							<form class="" method="post" autocomplete="off" action="<?php echo $_SERVER['PHP_SELF'];?>">
								<div class="change_teamdiv">
									<?php
										//selected Season
										$sqlDataUser="SELECT * FROM gaaplayermanager2.users AS u INNER JOIN gaaplayermanager2.team AS t ON u.Team = t.Team_ID  WHERE u.User_ID = $selectedUserID;";
										//$sqlDataTeams="CALL gaaplayermanager2. elevenSettingsGetAllTeams ()";
										$sqlDataTeam="SELECT * FROM team";
										$rsDataUser=getTableData($conn,$sqlDataUser);
										$rsDataTeam=getTableData($conn,$sqlDataTeam);
										$arrayDataUser=checkResultSet($rsDataUser);
										$arrayDataTeam=checkResultSet($rsDataTeam);
										echo "<select class=\"settingdropdown\" name=\"Teams\">";
										foreach($arrayDataUser as $row1) {
											$CurrentUserTeam=$row1['Team'];  //get the current PK value
										}
										foreach($arrayDataTeam as $row2) {
											$TeamName = $row2['Name'];
											$TeamID=$row2['Team_ID'];  //get the current PK value
									?>
							<option  value="<?php echo $TeamID; ?>" <?php if ($CurrentUserTeam == $TeamID) { echo 'selected'; } ?> ><?php echo $TeamName; ?></option>
									<?php }
										echo "</select><br>";
									?>
							<button class="changeteambutton" name="SAVE" type="submit" value="<?php echo $id;?>">Update</button>
							</div>
						</form>	
					</div>
				</div>
			</div><!--end of row-->



			<div class="row">
				<div class="col-xs-12 col-md-6">
					<h2 class="index_headers" >Teams</h2>
				</div>

			<div class="col-xs-12 col-md-6">
				<h2 class="index_headers" >Management Profiles</h2>

			</div>
		</div><!--end of row-->


			<div class="row">
				<div class="col-xs-12 col-md-6">
					<div class="indexpage_box" style="overflow:scroll">
						<?php
							//load team buttons
							//$sqlDataTeams="CALL gaaplayermanager2. elevenSettingsGetAllTeams ()";
    						$sqlDataTeams="SELECT * FROM gaaplayermanager2.team;";
   							$rsDataTeams=getTableData($conn,$sqlDataTeams);
    						$arrayDataTeams=checkResultSet($rsDataTeams);
    							foreach($arrayDataTeams as $row) {
               						$teams = $row['Team_ID']. ' - ' .$row['Name'];
               						$id=$row['Team_ID'];
               						$buttonText=$teams;
               						include 'FORMS/buttonWithText3settingspageT.html';}
						?>
					</div>


				</div>
			
				<div class="col-xs-12 col-md-6">
					<div class="indexpage_box" style="overflow:scroll">
						<?php
							//load management buttons
							//$sqlDataTeams="CALL gaaplayermanager2. elevenSettingsGetAllManagers ()";
    						$sqlDataTeams="SELECT * FROM gaaplayermanager2.users AS u INNER JOIN gaaplayermanager2.team AS t ON u.Team = t.Team_ID WHERE User_Type < 3;";
   							$rsDataTeams=getTableData($conn,$sqlDataTeams);
    						$arrayDataTeams=checkResultSet($rsDataTeams);
    							foreach($arrayDataTeams as $row) {
               						$musers = $row['Name']. ' - ' .$row['First_Name']. ' ' .$row['Last_Name'];
               						$id=$row['User_ID'];
               						$buttonText=$musers;
               						include 'FORMS/buttonWithText3settingspageMU.html';}
						?>

				</div>

			</div>
		</div><!--end of row-->

		<div class="row">
				<div class="col-xs-12 col-md-6">
					<div class="index_page_div"><br>
						<a class="index_page_buttons" href="11.1_Settings_Create_Team.php" role="button">Create New Team</a>
					</div><br>
				</div>
				<div class="col-xs-12 col-md-6">
					<div class="index_page_div"><br>
						<a class="index_page_buttons" href="11.3_Settings_Create_Muser.php" role="button">Create New Management User</a>
					</div><br>
				</div>
		</div><!--end of row-->
	</div><!--end of container-->







<!--//----------------FOOTER section--------------------------//-->
<!--//========================================================//-->
		
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

				</div>
		</div><!--end of row-->
</div><!--end of container-->

</body>
</html>
















 



