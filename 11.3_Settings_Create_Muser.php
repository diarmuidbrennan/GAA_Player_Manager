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
		<div class="row">
			<div class="col-xs-12 col-md-12">

							<?php
								if(isset($_POST['SAVE']))  {
									$table='users';
									//get the values entered in the form	
									$Username=$conn->real_escape_string($_POST['Username']);
									$salt = "tipperaryhurlers";
									$pass1=$conn->real_escape_string($_POST['Password1']);
									$pass2=$conn->real_escape_string($_POST['Password2']);
									$pass3=$pass1.$salt;
									$usertype=$conn->real_escape_string($_POST['UserType']);
									$FirstName=$conn->real_escape_string($_POST['FirstName']);
									$LastName=$conn->real_escape_string($_POST['LastName']);
									$DOB=$conn->real_escape_string($_POST['DOB']);
									$Height=$conn->real_escape_string($_POST['Height']);
									$Weight=$conn->real_escape_string($_POST['Weight']);
									$Email=$conn->real_escape_string($_POST['Email']);
									$Phone=$conn->real_escape_string($_POST['Phone']);
									$enabled=$conn->real_escape_string($_POST['Enabled']);
									$Team=$conn->real_escape_string($_POST['Team']);

									if ($pass1===$pass2) {
									//this hashing method works in PHP 5.1.2. +
									//the first parameter is the hash algorithm
									$passEncrypt= hash('ripemd160', $pass3);  //this algorithm requires 40 chars field length
									//$sqlDataAllUsers="CALL gaaplayermanager2. elevenSettingsNewMUsers ('$Username','$passEncrypt',$usertype,'$FirstName','$LastName',$DOB,'$Height','$Weight','$Email',$Phone,$enabled,$Team)";
									$sqlInsert= "INSERT INTO $table (Username,Password,User_Type,First_Name,Last_Name,DOB,Height,Weight,email,phone,Enabled,Team) VALUES('$Username','$passEncrypt','$usertype','$FirstName','$LastName','$DOB','$Height','$Weight','$Email','$Phone','$enabled','$Team')";
										if(queryInsert($conn,$sqlInsert)==1) { //execute the INSERT query 
											echo "<h3>New data inserted successfully</h3>";
											echo "<script> window.location.assign('11_Settings.php'); </script>";
										}
										else {
											echo "<h3>Error data cannot be entered</h3>";
										}
									}
									else { 
										echo "<p>Passwords dont match - data not entered";
									}
								}
								else {
							?>


				<form class="" method="post" autocomplete="off" action="<?php echo $_SERVER['PHP_SELF'];?>">
						<h2 id="displayGAAuserformheader">New Management User</h2>
							<table class="npform">
								<tr><td>
									<label>
	<!--Username-->
										<span>Username</span>
										<input name="Username" type="text" required="true"  title="Username (20 Characters)" pattern="[a-zA-Z0-9]{1,20}" data-tip="Enter Characters A-Z,a-z and/or numbers 0-9">	
	<!--Password-->
										<span>Password</span>
										<input name="Password1" id="password" type="password" required="true" title="Password (min 5 to 8 Characters)" pattern="[A-Za-z-0-9_]{5,30}">
	<!--Password-->
										<span>Re-enter Password</span>
										<input name="Password2"  type="password" required="true" title="Password (5 to 8 Characters a-z,A-Z,0-9 and underscore)" pattern="[A-Za-z-0-9_]{5,30}">
	<!--User Type 1->Admin, 2->Management, 3->Player -->
										<span>User Type</span>
										<input name="UserType" type="text" required="true" title="User Type 1->Admin, 2->Management, 3->Player" pattern="[a-zA-Z0-9óáéí']{1,48}">		
	<!--First Name-->
										<span>First Name</span>
										<input name="FirstName" type="text" required="true" title="First Name (up to 45 Characters)" pattern="[a-zA-Z0-9óáéí']{1,48}">
	<!--Last Name-->
										<span>Last Name</span>
										<input name="LastName" type="text" required="true" title="Last Name (up to 45 Characters)" pattern="[a-zA-Z0-9óáéí']{1,48}">	
	<!--Date Of Birth-->
										<span>Date Of Birth</span>
										<input name="DOB" type="date" required="true" title="yyyy/mm/dd" pattern="[a-zA-Z0-9óáéí']{1,48}">	
	<!--Height-->
										<span>Height</span>
										<input name="Height" type="text" required="true" title="Height (cm)" pattern="[a-zA-Z0-9óáéí']{1,48}">	
	<!--Weight-->
										<span>Weight</span>
										<input name="Weight" type="text" required="true" title="Weight (kg)" pattern="[a-zA-Z0-9óáéí']{1,48}">	
	<!--Email-->
										<span>Email</span>
										<input name="Email" type="text" required="true" title="Email" pattern="[a-zA-Z0-9óáéí.@']{1,48}">	
	<!--Phone-->
										<span>Phone</span>
										<input name="Phone" id="phone" type="text" required="true" title="Mobile Phone Number" pattern="[0-9_]{5,15}">
	<!--Enabled-->
										<span>Enabled</span>
										<input name="Enabled" id="Enabled" type="text" required="true" title="" pattern="[0-9_]{1,15}">
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
									} 	}
								?>
										</select><br>
										<label>

										<button class="playerprofilemenubutton" name="SAVE" type="submit" value="<?php echo $id;?>">Save</button>

										</label>
								</td></tr>
							</table>
				</form>
			</div>
		</div><!--end of row-->

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