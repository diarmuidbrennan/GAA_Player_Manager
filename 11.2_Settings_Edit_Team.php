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

<!----------------- HEADER SECTION ----------------------->
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
$table='team';  //table to delete records from
$PK="Team_ID";  //Specify the PK of the table;
if(isset($_POST['send']))	//execute the save button
{
 
 	//save the edited fields to the table in database
 	$selectedID=$_SESSION["Teamname"];
	$teamname = $_POST["Teamname"];

    $teamname=$conn->real_escape_string($teamname);

    //$sql="CALL gaaplayermanager2.elevenSettingsEditTeam ('$teamname', $selectedID)
	$sql = "UPDATE $table SET"     //sql query for the update 
	    . " " . "Name = '$teamname'"	
	    . " WHERE $PK = '$selectedID';";
	
	if (updateRecord($conn,$sql))  //call the updateRecord() function
	{
	echo "<h3>RECORD WITH PK=$selectedID UPDATED</h3>";
	echo "<script> window.location.assign('11_Settings.php'); </script>";
	}
	else {
	echo "<h3 >RECORD WITH PK=$selectedID CANNOT BE UPDATED</h3>";
	}

	//close the connection
	//$conn->close();
}

if(isset($_POST['CANCEL']))	//execute the save button
{
	echo "<script> window.location.assign('11_Settings.php'); </script>";
}
	

else //this is the first time the form is loaded
{

	$selectedTeamID=$_SESSION['primarykey'];  //get the ID of the record we want to update from the form
	//$sqlData="CALL gaaplayermanager2. elevenSettingsEditTeam $selectedTeamID)";
	$sqlData="SELECT * FROM team WHERE Team_ID = $selectedTeamID;";  //get the data from the table
	$rsData=getTableData($conn,$sqlData);//check the results
	$arrayData=checkResultSet($rsData);
	foreach($arrayData as $row) {
		sendToEditTeamForm($row["Name"]);
	}

	//close the connection
	$conn->close();
}

?>

</div>
</div>

<div class="row">
<div class="col-xs-12 col-md-12">



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
















 



