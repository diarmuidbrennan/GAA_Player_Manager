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

	<div id="indexpage_box_container">



				<?php
				$table='users';  //table to delete records from
				$PK="User_ID";  //Specify the PK of the table;
					if(isset($_POST['SAVE']))	//execute the save button
				{
 					//save the edited fields to the table in database 
					$selectedID=$_SESSION["primarykey"];
					$username = $_POST["Username"];
					$usertype = $_POST["UserType"];					
    				$firstname = $_POST["FirstName"];
    				$lastname = $_POST["LastName"];
    				$DOB =  $_POST["DOB"];
    				$Height = $_POST["Height"];
    				$Weight = $_POST["Weight"];
    				$Email = $_POST["Email"];
					$Phone = $_POST["Phone"];
					$Enabled = $_POST["Enabled"];
					$Team = $_POST["Team"];					

    				$username=$conn->real_escape_string($username);
 					$usertype=$conn->real_escape_string($usertype);   				
    				$firstname = $conn->real_escape_string($firstname);
    				$lastname = $conn->real_escape_string($lastname);
					$DOB=$conn->real_escape_string($DOB);
					$Height=$conn->real_escape_string($Height);
					$Weight=$conn->real_escape_string($Weight);
					$Email=$conn->real_escape_string($Email);
					$Phone=$conn->real_escape_string($Phone);
					$Enabled=$conn->real_escape_string($Enabled);
					$Team=$conn->real_escape_string($Team);

						//$sql="CALL gaaplayermanager2.elevenSettingsEditMUsers ('$username', $usertype, '$firstname', '$lastname', $DOB, '$Height', '$Weight', '$Email', $Phone, $Enabled, $Team, $selectedID)";
						$sql = "UPDATE $table SET"     //sql query for the update 
	    				. " " . "Username = '$username'"
	    				. "," . "User_Type = '$usertype'"	    					
	    				. "," . "First_Name = '$firstname'"
	    				. "," . "Last_Name = '$lastname'"
	    				. "," . "DOB = '$DOB'"
	    				. "," . "Height = '$Height'"
	    				. "," . "Weight = '$Weight'"
	    				. "," . "email = '$Email'"
	    				. "," . "phone = '$Phone'"
	    				. "," . "Enabled = '$Enabled'"
	    				. "," . "Team = '$Team'"	    				
	    				. " WHERE $PK = '$selectedID';";
	
							if (updateRecord($conn,$sql))  //call the updateRecord() function
						{
							echo "<h3>RECORD WITH PK=$selectedID UPDATED</h3>";
							echo "<script> window.location.assign('11_Settings.php'); </script>";
						}
						else
						{
							echo "<h3 >RECORD WITH PK=$selectedID CANNOT BE UPDATED</h3>";
						}
	

				}

					if(isset($_POST['CANCEL']))	//execute the save button
					{
						echo "<script> window.location.assign('11_Settings.php'); </script>";
					}
	

					else //this is the first time the form is loaded
					{


						$selectedID=$_SESSION["primarykey"];  //get the ID of the record we want to update from the form
						$sqlData="SELECT * FROM users AS u INNER JOIN team AS t ON u.Team = t.Team_ID WHERE $PK = '$selectedID';";  //get the data from the table
						$rsData=getTableData($conn,$sqlData);
						$row = $rsData->fetch_assoc();

						$Username = $row["Username"];
						$UserType = $row["User_Type"];
						$FirstName = $row["First_Name"];
						$LastName = $row["Last_Name"];
						$DOB = $row["DOB"];
						$Height = $row["Height"];
						$Weight = $row["Weight"];
						$email = $row["email"];
						$phone = $row["phone"];
						$Enabled = $row["Enabled"];
						$CTeam = $row["Team"];

					?>

		<div class="row">
			<div class="col-xs-12 col-md-12">

				<form class="" method="post" autocomplete="off" action="<?php echo $_SERVER['PHP_SELF'];?>">
					<div>
						<h2 id="displayGAAuserformheader">Management User</h2>
							<table class="npform">
								<tr><td>
									<label>
	<!--Username-->
<span>Username</span>
<input name="Username" type="text" required="true"  title="Username (20 Characters)" pattern="[a-zA-Z0-9]{1,20}" data-tip="Enter Characters A-Z,a-z and/or numbers 0-9" value = "<?php echo $Username;?>">	
	<!--User Type 1->Admin, 2->Management, 3->Player -->
<span>User Type</span>
<input name="UserType" type="text" required="true" title="User Type 1->Admin, 2->Management, 3->Player" pattern="[a-zA-Z0-9óáéí']{1,48}"value = "<?php echo $UserType;?>">		
	<!--First Name-->
<span>First Name</span>
<input name="FirstName" type="text" required="true" title="First Name (up to 45 Characters)" pattern="[a-zA-Z0-9óáéí']{1,48}"value = "<?php echo $FirstName;?>">
	<!--Last Name-->
<span>Last Name</span>
<input name="LastName" type="text" required="true" title="Last Name (up to 45 Characters)" pattern="[a-zA-Z0-9óáéí']{1,48}"value = "<?php echo $LastName;?>">	
	<!--Date Of Birth-->
<span>Date Of Birth</span>
<input name="DOB" type="date" required="true" title="yyyy/mm/dd" pattern="[a-zA-Z0-9óáéí']{1,48}"value = "<?php echo $DOB;?>">	
	<!--Height-->
<span>Height</span>
<input name="Height" type="text" required="true" title="Height (cm)" pattern="[a-zA-Z0-9óáéí']{1,48}" value = "<?php echo $Height;?>">	
	<!--Weight-->
<span>Weight</span>
<input name="Weight" type="text" required="true" title="Weight (kg)" pattern="[a-zA-Z0-9óáéí']{1,48}"value = "<?php echo $Weight;?>">	
	<!--Email-->
<span>Email</span>
<input name="Email" type="text" required="true" title="Email" pattern="[a-zA-Z0-9óáéí.@']{1,48}" value = "<?php echo $email;?>">	
	<!--Phone-->
<span>Phone</span>
<input name="Phone" id="phone" type="text" required="true" title="Mobile Phone Number" pattern="[0-9_]{5,15}"value = "<?php echo $phone;?>">
	<!--Enabled-->
<span>Enabled</span>
<input name="Enabled" id="Enabled" type="text" required="true" title="Mobile Phone Number" pattern="[0-9_]{1,15}" value = "<?php echo $Enabled;?>">
	<!--Team-->
<span>Team</span>
					<?php
						$sqlData="SELECT * FROM gaaplayermanager2.team;";
						$rsData=getTableData($conn,$sqlData);
						$arrayData=checkResultSet($rsData);
						$conn->close();
						echo "<select name=\"Team\">";
						$teamCid=$Team;  //get the current team value
							foreach($arrayData as $row) {
								$name = $row['Name'];
								$id=$row['Team_ID'];  //get the current PK value
					?>

<span>Team</span>
<option value="<?php echo $id; ?>" <?php if ($CTeam == $id) { echo 'selected'; } ?> ><?php echo $name; ?></option>
					<?php 	
							} 	
					?>
						</select><br>

									<label>

<button class="smallBtn" name="SAVE" type="submit" value="<?php echo $id;?>">Update</button>
<button class="smallBtn" name="CANCEL" type="submit" value="">Cancel</button>

									</label>
								</td></tr>
							</table>
					</div>
				</form>


			</div>
		</div><!--end of row-->


<?php } ?>




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