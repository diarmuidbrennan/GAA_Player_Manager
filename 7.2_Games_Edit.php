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
					<h1>
						<?php echo $selectedTeamName; ?> Matches
					</h1>
				</div><br>
			</div>
		</div>


<!------------------MAIN SECTION------------------------------>
<!--========================================================-->

<?php
$table='games';  //table to delete records from
$PK="Game_ID";  //Specify the PK of the table;
if(isset($_POST['SAVE']))	//execute the save button
{
 
 	//save the edited fields to the table in database 
	$selectedID=$_SESSION["primarykey"];

	$season = $_POST["Season"];
    $gamedate = $_POST["Game_Date"];
    $gametime = $_POST["Game_Time"];
    $competition = $_POST["Competition"];
    $opposition = $_POST["Opposition"];
    $location = $_POST["Location"];
    $result = $_POST["Result"];
    $notes = $_POST["Notes"];


    $season=$conn->real_escape_string($season);
	$gamedate=$conn->real_escape_string($gamedate);
	$gametime=$conn->real_escape_string($gametime);
    $competition = $conn->real_escape_string($competition);
    $opposition = $conn->real_escape_string($opposition);
    $location = $conn->real_escape_string($location);
    $result = $conn->real_escape_string($result);
    $notes = $conn->real_escape_string($notes);

	$sql = "UPDATE games SET"     //sql query for the update 
	    . " " . "Season_Season_ID = '$season'"	
	    . "," . "Game_Date = '$gamedate'"
	    . "," . "Game_Time = '$gametime'"
	    . "," . "Competition = '$competition'"
	    . "," . "Opposition = '$opposition'"
	    . "," . "Location = '$location'"
	    . "," . "Result = '$result'"
	    . "," . "Notes = '$notes'"
	    . " WHERE Game_ID = '$selectedID';";
	
	if (updateRecord($conn,$sql))  //call the updateRecord() function
	{
	echo "<h3>RECORD WITH PK=$selectedID UPDATED</h3>";
	echo "<script> window.location.assign('7_Game.php'); </script>";
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
	echo "<script> window.location.assign('7_Games.php'); </script>";
}
	

else //this is the first time the form is loaded
{

?>

<form class="newplayerform" method="post" autocomplete="off" action="<?php echo $_SERVER['PHP_SELF'];?>">
	<div>
	<h2>Edit Game</h2>
	<table class="npform">
	<tr><td>
	<label>

<?php
//selected Season
	$selectedID=$_SESSION["primarykey"];  //get the ID of the record we want to update from the form
	//$sqlDataGames="CALL gaaplayermanager2. sevenMatchdayGetAllGames ($selectedTeamID)";
	$sqlDataCurrentSeason="SELECT * FROM gaaplayermanager2.games AS g INNER JOIN gaaplayermanager2.season AS s ON s.Season_ID = g.Season_Season_ID  WHERE g.Game_ID = $selectedID;";
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
	<option value="<?php echo $row2['Season_ID']; ?>" <?php if ($SeasonCurrentid == $row2['Season_ID']) { echo 'selected'; } ?> ><?php echo $Season; ?></option>
	<?php }
	echo "</select><br>";
	
	$Date=$row1['Game_Date'];
	$Time=$row1['Game_Time'];
	$Competition=$row1['Competition'];
	$Opposition=$row1['Opposition'];
	$Location=$row1['Location'];
	$Result=$row1['Result'];
	$Notes=$row1['Notes'];
	?>


<!--Choose a date-->
<label>Date</label><input name="Game_Date" type="date" required="false" title="Date" pattern="[a-zA-Z0-9óáéí']{1,200}"value = "<?php echo $Date;?>"/><br>

<!--Choose a Time-->
<label>Time</label><input name="Game_Time" type="time" required="false" title="Time (24hr)" pattern="[a-zA-Z0-9óáéí']{1,200}"value = "<?php echo $Time;?>"/><br>

<!--Competition-->
<label>Competition</label><input name="Competition" type="text" required="true"  title="Competition" pattern="[a-zA-Z0-9 ]{1,40}" value = "<?php echo $Competition;?>"/><br>

<!--Oppossition-->
<label>Oppossition</label><input name="Opposition" type="text" required="true"  title="Opposition" pattern="[a-zA-Z0-9 ]{1,40}" value = "<?php echo $Opposition;?>"/><br>

<!--Location-->
<label>Location</label><input name="Location" type="text" required="true"  title="Location" pattern="[a-zA-Z0-9 ]{1,40}" value = "<?php echo $Location;?>"/><br>

<!--Result-->
<label>Result</label><input name="Result" type="text" required=""  title="Result" pattern="[a-zA-Z0-9 ]{1,40}" value = "<?php echo $Result;?>"/><br>

<!--Notes-->
<label>Notes</label><input name="Notes" type="text" id="myText" pattern="[a-zA-Z0-9óáéí'- ]{1,200}" value="<?php echo $Notes ?>"/><br>


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

</body>
</html>