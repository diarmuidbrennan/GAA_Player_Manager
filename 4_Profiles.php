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
			</div><!--end of col-->
		</div><!--end of row-->

    	<div class="row">
        	<div class="col-xs-12 col-md-12">
            	<div id="navigation_option">
                	<h1>
                	<?php 
                		echo $selectedTeamName; 
                	?>
                	Player Profiles
                	</h1>
            	</div><br>
        	</div><!--end of col-->
    	</div><!--end of row-->

<!--//----------------MAIN SECTION----------------------------//-->
<!--//========================================================//-->
					<?php
						$table='users';  //table to delete records from
						$PK="User_ID";  //Specify the PK of the table

//Disable Record_________________________________________________________________

						if(isset($_POST['disableplayer'])){ //if the form has been submitted 
						//DELETE query
						$selectedID=$_POST['disableplayer'];  //get the ID of the record we want to delete from the form
						//$sqlDis="CALL gaaplayermanager2.fourProfilesdisableplayer($selectedID)";
						$sqlDis="UPDATE users SET Enabled = 0 WHERE User_ID='$selectedID';";  //create the SQL
						if (deleteRecord($conn,$sqlDis)){ //call the deleteRecord() function
						echo "<h3>RECORD WITH PK=$selectedID DELETED</h3>";
						}
						else {
						echo "<h3 >RECORD WITH PK=$selectedID CANNOT BE DELETED</h3>";
						}
						echo "<script> window.location.assign('4_Profiles.php'); </script>";
						}

//Edit Record_________________________________________________________________

						if(isset($_POST['editrecord']))  //if the form has been submitted 
						{
						$selectedID=$_POST['editrecord'];  //get the ID of the record we want to edit from the form
						$_SESSION['primarykey'] = $selectedID;
						echo "<script> window.location.assign('4.2_Profiles_Edit.php'); </script>";
						}

						

//Create New Record_________________________________________________________________

						if(isset($_POST['Create']))  //if the form has been submitted 
						{
						echo "<script> window.location.assign('4.1_Profiles_Create.php'); </script>";
						}
					?>

		
	<div id="indexpage_box_container">
		<div class="row">
			<div class="col-xs-12 col-md-6" id="profile_page_left_box">
				<div class="rpe_profile_page">
					<a href="4.3_Profiles_Create_RPE_Entry.php">
						<button class="rpe_profile_page_buttons">Create RPE entry</button>
					</a>
				</div>
			</div><!--end of col-->

			<div class="col-xs-12 col-md-6" id="profile_page_right_box">
				<div class="rpe_profile_page">
					<a href="4.4_Profiles_View_RPE_Entry.php">
						<button  class="rpe_profile_page_buttons">View RPE entries</button>
					</a>
				</div>
			</div><!--end of col-->
		</div><!--end of row-->

		<div class="row">
			<div class="col-xs-12 col-md-6" id="profile_page_left_box"><br>

					<?php
						if (($selectedUserType <=2)) {
							//$sqlDataam="CALL gaaplayermanager2.fourProfilesuserbuttonsplayer($selectedTeamID)";
							$sqlDataam="SELECT * FROM $table WHERE Team = $selectedTeamID && User_Type = 3 && Enabled = 1;";  //get the data from the table
							$rsDataam=getTableData($conn,$sqlDataam);
							$arrayDataam=checkResultSet($rsDataam);
							$arrayTitles=null;
							generateplayerbuttons($table, $PK, $arrayTitles, $arrayDataam);
						}
						else {
							////$sqlDatap="CALL gaaplayermanager2.fourProfilesuserbuttons($selectedUserID)";
							$sqlDatap="SELECT * FROM $table WHERE User_ID = $selectedUserID;";  //get the data from the table
							$rsDatap=getTableData($conn,$sqlDatap);
							$arrayDatap=checkResultSet($rsDatap);
							generateplayerbuttons($table, $PK, $arrayTitles, $arrayDatap);
						}
					?> 

			</div><!--end of col-->
					
			<div class="col-xs-12 col-md-6" id="profile_page_right_box">
					
					<?php 
						//Display Record_________________________________________________________________
						if(isset($_POST['showrecord'])) {
						$selectedUserID=$_POST['showrecord'];  //get the ID of the record we want to update from the form
						//$sqlData="CALL gaaplayermanager2.fourProfilesuserprofile($selectedUserID)";
						$sqlData="SELECT * FROM users WHERE User_ID = $selectedUserID;";  //get the data from the table
						$rsData=getTableData($conn,$sqlData);
						$arrayData=checkResultSet($rsData);
						$conn->close();
							foreach($arrayData as $row) {
						}
						//use resultsets to generate HTML tables with EDIT button
    					sendToDisplayPlayerForm($row["Username"], $row["Password"], $row["First_Name"] , $row["Last_Name"], $row["DOB"], $row["Height"], $row["Weight"], $row["email"], $row["phone"], $row["image"]);	
						}
					?>

			</div><!--end of col-->
		</div><!--end of row-->


		<div class="row">
			<div class="col-xs-12 col-md-6"><br>
				<?php 
					if (($selectedUserType <=2)) {
					echo "<a class=\"playerprofilemenubutton\" href=\"4.1_Profiles_Create.php\" role=\"button\">Register New Player</a>";
				}
				?>
			</div>

			<div class="col-xs-12 col-md-6">
				<form  class="" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>"><br>
					<button class="playerprofilemenubutton"  name="editrecord" type="submit" value="<?php echo $selectedUserID;?>">Edit Player
					</button>
					
				<?php 
					if (($selectedUserType <=2)) { 
						$disselectedUserID=(!empty($_POST['showrecord']) ? $_POST['showrecord'] : null);?>
						
						<button class="playerprofilemenubutton"  name="disableplayer" type="submit" value="<?php echo $disselectedUserID;?>">Disable Player</button>
				<?php
					}
				?>
				</form>
			</div><!--end of col-->
		</div><!--end of row--><br><br>
						
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
