<?php
// Start the session
    session_start();

//includes
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
					<?php 
						include("PAGE_CONTENT/header.php"); 
					?> 
				</div>
			</div>
		</div><!--end of row-->

<!------------------NAVIGATION SECTION------------------------>
<!--========================================================-->
		
		<br>
		<div id="indexpage_box_container">
			<div class="row"><br>				
				<div class="col-xs-12 col-md-12">

					<?php		
						echo "<section>";

						if(isset($_POST['send'])) { //if the form has been submitted previously
							$table='users';  //table to insert values into
							//QUERY
							//get the values entered in the form
							$username=$conn->real_escape_string($_POST['username']);
							$salt = "tipperaryhurlers";
							$pass=$conn->real_escape_string($_POST['password'].$salt);
							$passEncrypt= hash('ripemd160', $pass);
							//$sqlLogin= "CALL gaaplayermanager2.oneLoginCheckUP('$username', '$passEncrypt')";
							$sqlLogin= "SELECT * FROM $table WHERE Username='$username' AND password='$passEncrypt';";
							$rs=$conn->query($sqlLogin);  //execute the query

	
							if ($rs->num_rows==1){
							$msg = 'Login Complete! Thanks';
							$sqlData="CALL gaaplayermanager2.oneLoginUserData('$username')";
							//$sqlData="SELECT * FROM $table AS u INNER JOIN team AS t ON u.Team = t.Team_ID WHERE Username='$username';";
							$rsData=getTableData($conn,$sqlData);
							$arrayData=checkResultSet($rsData);
							foreach($arrayData as $row) {
								$selectedUserType = $row['User_Type'];
								$selectedUserID= $row['User_ID'];
								$selectedTeamID = $row['Team'];
								$selectedTeamName= $row['Name'];
								$selectedUserEnabled= $row['Enabled'];
							}
    						$_SESSION['UserID'] = $selectedUserID;
    						$_SESSION['UserType'] = $selectedUserType;    
							$_SESSION['TeamID'] = $selectedTeamID;
							$_SESSION['TeamName'] = $selectedTeamName;
							$_SESSION['Enabled'] = $selectedUserEnabled;
							echo "<script> window.location.assign('2_Index.php'); </script>";
							}
							else {
							echo "Invalid Login";
							echo "<script> window.location.assign('1_Login.php'); </script>"; }
							//close the connection
							$conn->close();
						}
						else {
						// display the login form
						include 'FORMS/UserLoginForm.html'; }

						echo "</section>";
					?>
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
		</div><!--indexpage_box_container-->
	</div><!--end of container-->

</body>
</html>
















 



