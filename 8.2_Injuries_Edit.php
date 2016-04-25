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
		</div><!--end of row-->s

    	<div class="row">
        		<div class="col-xs-12 col-md-12">
            			<div id="navigation_option">
                				<h1><?php echo $selectedTeamName; ?> Injuries</h1>
            			</div><br>
        		</div>
    	</div>

<!--//----------------MAIN SECTION----------------------------//-->
<!--//========================================================//-->

<div class="row">
<div class="col-xs-12 col-md-12">
<?php 

$table='users';  //table to delete records from
$PK="User_ID";  //Specify the PK of the table;
if(isset($_POST['SAVE']))	//execute the save button
{
 
 	//save the edited fields to the table in database 
	$selectedID=$_SESSION["primarykey"];

	$username = $_POST["Username"];
    $injurytype = $_POST["InjuryType"];
    $injurystatus = $_POST["InjuryStatus"];
    $comment = $_POST["Comment"];
    $dateinjured = $_POST["DateInjured"];
    $dateofreturn = $_POST["DateOfReturn"];


    $username=$conn->real_escape_string($username);
	$injurytype=$conn->real_escape_string($injurytype);
	$injurystatus=$conn->real_escape_string($injurystatus);
    $comment = $conn->real_escape_string($comment);
    $dateinjured = $conn->real_escape_string($dateinjured);
    $dateofreturn = $conn->real_escape_string($dateofreturn);



	//$sqlDataAllUsers="CALL gaaplayermanager2. eightInjuriesEdit ($username, $injurytype, $injurystatus, '$comment', $dateinjured, $dateofreturn, $selectedID)";
	$sql = "UPDATE injury SET"     //sql query for the update 
	    . " " . "Users_User_ID = '$username'"	
	    . "," . "Injury_Types_Injury_Types_ID = '$injurytype'"
	    . "," . "Recovery_Status_Recovery_Status_ID = '$injurystatus'"
	    . "," . "Comment = '$comment'"
	    . "," . "Date_Occured = '$dateinjured'"
	    . "," . "Date_Of_Return = '$dateofreturn'"
	    . " WHERE Injury_ID = '$selectedID';";
	
	if (updateRecord($conn,$sql))  //call the updateRecord() function
	{
	echo "<h3>RECORD WITH PK=$selectedID UPDATED</h3>";
	echo "<script> window.location.assign('8_Injuries.php'); </script>";
	}
	else
	{
	echo "<h3 >RECORD WITH PK=$selectedID CANNOT BE UPDATED</h3>";
	echo "$sql";
	}
	

	//close the connection
	$conn->close();

}




if(isset($_POST['CANCEL']))	//execute the save button
{
	echo "<script> window.location.assign('8_Injuries.php'); </script>";
}
	

else //this is the first time the form is loaded
{

?>

<form class="newplayerform" method="post" autocomplete="off" action="<?php echo $_SERVER['PHP_SELF'];?>">
	<div>
	<h2>Edit Injury</h2>
	<table class="npform">
	<tr><td>
	<label>

<?php

	//selected user
	$selectedID=$_SESSION["primarykey"];  //get the ID of the record we want to update from the form
	$sqlDataCurrentUsername="SELECT * FROM gaaplayermanager2.injury AS i INNER JOIN gaaplayermanager2.users AS u ON u.User_ID = i.Users_User_ID  WHERE i.Injury_ID = $selectedID";
	$sqlDataAllUsername="SELECT * FROM users WHERE Team =$selectedTeamID";
	$rsDataCurrentUsername=getTableData($conn,$sqlDataCurrentUsername);
	$rsDataAllUsername=getTableData($conn,$sqlDataAllUsername);
	$arrayDataCurrentUsername=checkResultSet($rsDataCurrentUsername);
	$arrayDataAllUsername=checkResultSet($rsDataAllUsername);
	echo "<select name=\"Username\">";
	foreach($arrayDataCurrentUsername as $row1) {
				$userid=$row1['User_ID'];  //get the current PK value
			}
	foreach($arrayDataAllUsername as $row2) {
				$name = $row2['First_Name']. ' ' .$row2['Last_Name'];
				$id=$row2['User_ID'];  //get the current PK value
	//echo "<option value='". $id ."'>". $name ."</option>";?>
	<option value="<?php echo $row2['User_ID']; ?>" <?php if ($userid == $row2['User_ID']) { echo 'selected'; } ?> ><?php echo $name; ?></option>
	<?php }
	echo "</select><br>";
	}


	//selected injury
	$selectedID=$_SESSION["primarykey"];  //get the ID of the record we want to update from the form
	$sqlDataCurrentInjuryType="SELECT * FROM gaaplayermanager2.injury_types AS it INNER JOIN gaaplayermanager2.injury AS i ON i.Injury_Types_Injury_Types_ID = it.Injury_Types_ID  WHERE i.Injury_ID = $selectedID";
	$sqlDataAllInjuryType="SELECT * FROM injury_types";
	$rsDataCurrentInjuryType=getTableData($conn,$sqlDataCurrentInjuryType);
	$rsDataAllInjuryType=getTableData($conn,$sqlDataAllInjuryType);
	$arrayDataCurrentInjuryType=checkResultSet($rsDataCurrentInjuryType);
	$arrayDataAllInjuryType=checkResultSet($rsDataAllInjuryType);
	echo "<select name=\"InjuryType\">";
	foreach($arrayDataCurrentInjuryType as $row1) {
				$injurytype = $row1['Injury_Type'];
				$injuryCurid=$row1['Injury_Types_ID'];  //get the current PK value
			}
	foreach($arrayDataAllInjuryType as $row2) {
				$injurytype = $row2['Injury_Type'];
				$injuryid=$row2['Injury_Types_ID'];  //get the current PK value
	?>
	<option value="<?php echo $row2['Injury_Types_ID']; ?>" <?php if ($injuryCurid == $row2['Injury_Types_ID']) { echo 'selected'; } ?> ><?php echo $injurytype; ?></option>
	<?php }
	echo "</select><br>";

	//selected injury status
	$selectedID=$_SESSION["primarykey"];  //get the ID of the record we want to update from the form
	$sqlDataCurrentInjuryStatus="SELECT * FROM gaaplayermanager2.recovery_status AS rs INNER JOIN gaaplayermanager2.injury AS i ON i.Recovery_Status_Recovery_Status_ID = rs.Recovery_Status_ID  WHERE i.Injury_ID = $selectedID";
	$sqlDataAllInjuryStatus="SELECT * FROM recovery_status";
	$rsDataCurrentInjuryStatus=getTableData($conn,$sqlDataCurrentInjuryStatus);
	$rsDataAllInjuryStatus=getTableData($conn,$sqlDataAllInjuryStatus);
	$arrayDataCurrentInjuryStatus=checkResultSet($rsDataCurrentInjuryStatus);
	$arrayDataAllInjuryStatus=checkResultSet($rsDataAllInjuryStatus);
	echo "<select name=\"InjuryStatus\">";
	foreach($arrayDataCurrentInjuryStatus as $row1) {
				$injuryCurStatusid=$row1['Recovery_Status_ID'];  //get the current PK value
			}
	foreach($arrayDataAllInjuryStatus as $row2) {
				$injurystatus = $row2['Recovery_Status'];
				$injurystatusid=$row2['Recovery_Status_ID'];  //get the current PK value
	?>
	<option value="<?php echo $row2['Recovery_Status_ID']; ?>" <?php if ($injuryCurStatusid == $row2['Recovery_Status_ID']) { echo 'selected'; } ?> ><?php echo $injurystatus; ?></option>
	<?php }
	echo "</select><br>";
	?>

	
	<?php
	//selected comment
	$selectedID=$_SESSION["primarykey"];  //get the ID of the record we want to update from the form
	$sqlDataInjuryComment="SELECT * FROM injury  WHERE Injury_ID = $selectedID";
	$rsDataInjuryComment=getTableData($conn,$sqlDataInjuryComment);
	$arrayDataInjuryComment=checkResultSet($rsDataInjuryComment);
		foreach($arrayDataInjuryComment as $row) {
		$comment = $row['Comment'];
	}
	?>
	<label>Comments on Injury</label><input name="Comment" type="text" id="myText" pattern="[a-zA-Z0-9óáéí'- ]{1,200}" value="<?php echo $comment ?>"/><br>

	<?php
	$selectedID=$_SESSION["primarykey"];  //get the ID of the record we want to update from the form
	$sqlDataInjuryDate="SELECT * FROM injury  WHERE Injury_ID = $selectedID";
	$rsDataInjuryDate=getTableData($conn,$sqlDataInjuryComment);
	$arrayDataInjuryDate=checkResultSet($rsDataInjuryDate);
		foreach($arrayDataInjuryDate as $row) {
		$DateInjured = $row['Date_Occured'];
		$DateOfReturn = $row['Date_Of_Return'];		
	}
	?>
	<span>Date Injured</span><input name="DateInjured" type="date" title="Date" pattern="[a-zA-Z0-9óáéí']{1,200}"value = <?php echo $DateInjured;?>><br>

	<span>Estimated Date of Return</span><input name="DateOfReturn" type="date" title="Date" pattern="[a-zA-Z0-9óáéí']{1,200}"value = <?php echo $DateOfReturn;?>><br>

	<tr><td>
<label>
<button class="smallBtn" name="SAVE" type="submit" value="<?php echo $id;?>">Update</button>
<button class="smallBtn" name="CANCEL" type="submit" value="">Cancel</button>
</label>
</td></tr>
</table>
</div>
</form>


</div>
</div>

<div class="row">
<div class="col-xs-12 col-md-12">



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
















 



