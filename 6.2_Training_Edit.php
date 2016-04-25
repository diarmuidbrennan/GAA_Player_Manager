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
	<link rel="stylesheet" type="text/css" href="CSS/Style.css">
	<!--bootstrap-->
	<link href="CSS/bootstrap.min.css" rel="stylesheet" media="screen">




</head>
<body >
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
                                <h1><?php echo $selectedTeamName; ?> Training</h1>
                        </div><br>
                </div>
        </div>

<?php
//----------------MAIN SECTION----------------------------//
//========================================================//

$table='training';  //table to delete records from
$PK="Training_ID";  //Specify the PK of the table;
if(isset($_POST['SAVE']))	//execute the save button
{
 
 	//save the edited fields to the table in database 
	$selectedID=$_SESSION["primarykey"];

	$season = $_POST["Season"];
	$trainingtype = $_POST["TrainingType"];
	$trainingload = $_POST["EstimatedRPE"];
    $trainingdate = $_POST["Training_Date"];
    $trainingtime = $_POST["Training_Time"];
    $notes = $_POST["Notes"];


    $season=$conn->real_escape_string($season);
    $trainingtype=$conn->real_escape_string($trainingtype);
    $trainingload=$conn->real_escape_string($trainingload);
	$trainingdate=$conn->real_escape_string($trainingdate);
	$trainingtime=$conn->real_escape_string($trainingtime);
    $notes = $conn->real_escape_string($notes);

    //$sql="CALL gaaplayermanager2.sixTrainingUpdate($season, $trainingtype, $trainingload, $trainingdate, $trainingtime, '$notes', $selectedID)";
	$sql = "UPDATE training SET"     //sql query for the update 
	    . " " . "Season_Season_ID = '$season'"
	    . "," . "Training_Type_Training_Type_ID = '$trainingtype'"
	    . "," . "Estimated_RPE = '$trainingload'"	
	    . "," . "Training_Date = '$trainingdate'"
	    . "," . "Training_Time = '$trainingtime'"
	    . "," . "Notes = '$notes'"
	    . " WHERE Training_ID = '$selectedID';";
	
	if (updateRecord($conn,$sql))  //call the updateRecord() function
	{
	echo "<h3>RECORD WITH PK=$selectedID UPDATED</h3>";
	echo "<script> window.location.assign('6_Training.php'); </script>";
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
	echo "<script> window.location.assign('6_Training.php'); </script>";
}
	

else //this is the first time the form is loaded
{

?>

<form class="editrainingform" method="post" autocomplete="off" action="<?php echo $_SERVER['PHP_SELF'];?>">
	<div>
	<h2>Edit Training Session</h2>
	<table class="npform">
	<tr><td>
	<label>

<?php
//selected season
	echo "<!--Choose a season-->";
	echo "<label>Season</label>";
	$selectedID=$_SESSION["primarykey"];  //get the ID of the record we want to update from the form
	//$sqlDataCurrentSeason="CALL gaaplayermanager2.sixTrainingeditselect($selectedID)";
	$sqlDataCurrentSeason="SELECT * FROM gaaplayermanager2.training AS t INNER JOIN gaaplayermanager2.season AS s ON t.Season_Season_ID = s.Season_ID WHERE t.Training_ID = $selectedID;";
	//$sqlDataAllSeason="CALL gaaplayermanager2.sixTrainingEditAllSeasons()";
	$sqlDataAllSeason="SELECT * FROM season";
	$rsDataCurrentSeason=getTableData($conn,$sqlDataCurrentSeason);
	$rsDataAllSeason=getTableData($conn,$sqlDataAllSeason);
	$arrayDataCurrentSeason=checkResultSet($rsDataCurrentSeason);
	$arrayDataAllSeason=checkResultSet($rsDataAllSeason);
	echo "<select name=\"Season\">";
	foreach($arrayDataCurrentSeason as $row1) {
				$SeasonCurrentid=$row1['Season_Season_ID'];  //get the current PK value
			}
	foreach($arrayDataAllSeason as $row2) {
				$Season = $row2['Season'];
				$Seasonid=$row2['Season_ID'];  //get the current PK value
	?>
	<option value="<?php echo $Seasonid; ?>" <?php if ($SeasonCurrentid == $Seasonid) { echo 'selected'; } ?> ><?php echo $Season; ?></option>
	<?php }
	echo "</select><br>";
	
//selected trainingtype
	echo "<!--Choose a training type-->";
	echo "<label>Training Type</label>";

	$selectedID=$_SESSION["primarykey"];  //get the ID of the record we want to update from the form
	//$sqlDataCurrentTrainingType="CALL gaaplayermanager2.sixTrainingeditSelectrainings($selectedID)";
	$sqlDataCurrentTrainingType="SELECT * FROM gaaplayermanager2.training AS t INNER JOIN gaaplayermanager2.training_type AS tt ON t.Training_Type_Training_Type_ID = tt.Training_Type_ID  WHERE t.Training_ID = $selectedID;";
	//$sqlDataAllTrainingType="CALL gaaplayermanager2.sixTrainingedittrainingtypes()";
	$sqlDataAllTrainingType="SELECT * FROM training_type";
	$rsDataCurrentTrainingType=getTableData($conn,$sqlDataCurrentTrainingType);
	$rsDataAllTrainingType=getTableData($conn,$sqlDataAllTrainingType);
	$arrayDataCurrentTrainingType=checkResultSet($rsDataCurrentTrainingType);
	$arrayDataAllTrainingType=checkResultSet($rsDataAllTrainingType);
	echo "<select name=\"TrainingType\">";
	foreach($arrayDataCurrentTrainingType as $row1) {
				$TrainingTypeCurrentid=$row1['Training_Type_Training_Type_ID'];  //get the current PK value
			}
	foreach($arrayDataAllTrainingType as $row2) {
				$TrainingType = $row2['Training_Type'];
				$TrainingTypeid=$row2['Training_Type_ID'];  //get the current PK value
	?>
	<option value="<?php echo $row2['Training_Type_ID']; ?>" <?php if ($TrainingTypeCurrentid == $row2['Training_Type_ID']) { echo 'selected'; } ?> ><?php echo $TrainingType; ?></option>
	<?php }
	echo "</select><br>";

	$Date=$row1['Training_Date'];
	$Time=$row1['Training_Time'];
	$Notes=$row1['Notes'];
	$estimatedrpe=$row1['Estimated_RPE'];
	$estimatedlenght=$row1['Estimated_Lenght'];
	$rpelowlimit=$row1['RPE_Low_Limit'];	
	$rpeestimatedlimit=$row1['RPE_Estimated_Limit'];
	$rpeupperlimit=$row1['RPE_Upper_Limit'];	
	?>

<!--Choose a date-->
<label>Date</label>
<input name="Training_Date" type="date" required="false" title="Date" pattern="[a-zA-Z0-9óáéí' ]{1,200}"value = "<?php echo $Date; ?>"><br>

<!--Choose a Time-->
<label>Time</label>
<input name="Training_Time" type="time" required="false" title="Time (24hr)" pattern="[a-zA-Z0-9óáéí' ]{1,200}"value = "<?php echo $Time; ?>"><br>

<!--Notes-->
<label>Notes</label>
<input name="Notes" type="text" id="myText" pattern="[a-zA-Z0-9óáéí'- ]{1,200}" value="<?php echo $Notes ?>"/><br>

<!--Estimated RPE-->
<span>Estimated RPE</span>
<input name="EstimatedRPE" type="text" required="true"  title="EstimatedRPE" pattern="[0-9 ]{1,10}" value = "<?php echo $estimatedrpe; ?>"><br>

<!--Estimated Lenght-->
<span>Estimated Lenght</span>
<input name="EstimatedLenght" type="text" required="true"  title="EstimatedLenght" pattern="[0-9 ]{1,10}" value = "<?php echo $estimatedlenght; ?>"><br>

<!--RPE Lower Limit-->
<label>RPE Lower Limit</label>
<input name="RPELowLimit" type="text" required="false"  title="RPELowLimit" pattern="[0-9 ]{1,10}" value = "<?php echo $rpelowlimit; ?>"><br>

<!--RPE Estimated Limit-->
<label>RPE Estimated Limit</label>
<input name="RPEEstimatedLimit" type="text" required="false"  title="RPEEstimatedLimit" pattern="[0-9 ]{1,10}" value = "<?php echo $rpeestimatedlimit; ?>"><br>

<!--RPE Lower Limit-->
<label>RPE Upper Limit</label>
<input name="RPEUpperLimit" type="text" required="false"  title="RPEUpperLimit" pattern="[0-9 ]{1,10}" value = "<?php echo $rpeupperlimit; ?>"><br>


<tr><td>
<label>
<button class="playerprofilemenubutton" name="SAVE" type="submit" value="<?php echo $id;?>">Update</button>
<button class="playerprofilemenubutton" name="CANCEL" type="submit" value="">Cancel</button>

</label>
</td></tr>
</table>
</div>
</form>


</div>
</div>

<div class="row">
<div class="col-xs-12 col-md-12">
<?php
	$conn->close();
}

//----------------FOOTER section--------------------------//
//========================================================//

//warn DEBUG  mode is on

if (__DEBUG==1) 
	{	
	echo '<footer class="debug">';
	echo "SQL= $sqlLogin <br>";
	echo 'Resultset: ';
	print_r($rs);
	echo "</footer>";
	}
	else
	{
	echo '<footer class="copyright">';
	echo 'Copyright 2016 GAA Player Manager';
	echo "</footer>";
	}


?>
</div>
</div>
</div>
</body>
</html>
















 



