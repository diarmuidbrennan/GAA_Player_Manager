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
    	echo "<script> window.location.assign('1_Login.php'); </script>";
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
			<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"       type="text/javascript"></script> 
			<script src="JS/highcharts.js"></script>
			<script src="http://code.highcharts.com/modules/exporting.js"></script>
			<script src="JS/highcharts-more.js"></script>
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
			</div><!--end of col-->
		</div><!--end of row-->
	
		<div class="row">
			<div class="col-xs-12 col-md-12">
				<div id="navigation_option">
					<h1><?php echo $selectedTeamName; ?> Home Page</h1>
				</div><br>
			</div><!--end of col-->
		</div><!--end of row-->

<!------------------MAIN SECTION------------------------------>
<!--========================================================-->
		
		<div id="indexpage_box_container">
			<div class="row">
<!--Training Attendence Chart-->
				<div class="col-xs-12 col-md-6">
					<div id="linechart" style="height: 400px; margin: 0 auto">

						<script src="JS/indexpageleftchart.js"></script>

					</div>
				</div><!--end of col-->

<!--Number of injuries Chart-->
				<div class="col-xs-12 col-md-6">
					
					<?php
					{
						//$sqltotalinj = "CALL gaaplayermanager2.twoIndexcountinjuries($selectedTeamID)";
						$sqltotalinj = "SELECT COUNT(Team_ID) FROM gaaplayermanager2.injury WHERE Team_ID = $selectedTeamID;";
						$rsDatatotalinj=getTableData($conn,$sqltotalinj);
						$arrayDatatotalinj=checkResultSet($rsDatatotalinj);
							foreach($arrayDatatotalinj as $row1) {
							$totalinjuries=$row1['COUNT(Team_ID)'];
							}
						
						//$sqlinjurycount="CALL gaaplayermanager2.twoIndexcountinjuriesnum($selectedTeamID)";
						$sqlinjurycount="SELECT i.Injury_Types_Injury_Types_ID, it.Injury_Type, COUNT(it.Injury_Types_ID) FROM gaaplayermanager2.injury AS i INNER JOIN gaaplayermanager2.injury_types AS it ON i.Injury_Types_Injury_Types_ID = it.Injury_Types_ID WHERE Team_ID = $selectedTeamID GROUP BY i.Injury_Types_Injury_Types_ID;";
						$rsDatainjurycount=getTableData($conn,$sqlinjurycount);
						$arrayDatainjurycount=checkResultSet($rsDatainjurycount);
						$counter = 1;
						/*foreach($arrayDatainjurycount as $row) {
							$id=$row['COUNT(it.Injury_Types_ID)'];  //get the current PK value
							$counter = $row['Injury_Types_Injury_Types_ID'];
							$injarray[$counter] = $id;
							}
						$head = $injarray[1];
						$shoulder = $injarray[2];
						$hand = $injarray[3];
						$knee = $injarray[4];
						$back = $injarray[5];
						$hip = $injarray[6];
						$groin = $injarray[7];
						$hamstring = $injarray[8];
						$quad = $injarray[9];
						$calf = $injarray[10];
						$ankle = $injarray[11];
						$foot = $injarray[12];*/
					}
						//create ajax request to the server-
					//data comes back in jason and dump that into pie chart.
					//  
						?>


						<div id="chart" style="height: 400px; margin: 0 auto">
						<script src="JS/indexpagerightchart.js"></script>

					</div>
				</div><!--end of col-->
			</div><!--end of row-->

			<div class="row">	
<!--Training Section-->
				<div class="col-xs-12 col-md-4">
					<h2 class="index_headers" >Training Sessions</h2>
						<div class="indexpage_box" style="overflow:scroll">
							<?php
								//training events
    							//$sqlDataTraining="CALL gaaplayermanager2.twoIndextrainingdata($selectedTeamID)";
    							$sqlDataTraining="SELECT * FROM gaaplayermanager2.training AS t INNER JOIN gaaplayermanager2.training_type AS tt ON tt.Training_Type_ID = t.Training_Type_Training_Type_ID INNER JOIN gaaplayermanager2.season AS s ON s.Season_ID = t.Season_Season_ID WHERE t.Team= $selectedTeamID && t.Season_Season_ID=2 ORDER BY t.Training_Date DESC;";
   								$rsDataTraining=getTableData($conn,$sqlDataTraining);
    							$arrayDataTraining=checkResultSet($rsDataTraining);
    								foreach($arrayDataTraining as $row) {
               							$training = $row['Training_Date']. ' - ' .$row['Training_Type']. ' Session';
               							$buttonText=$training;
               							include 'FORMS/buttonWithText3indexpage.html';
               						}
							?>
						</div>
				</div><!--end of col-->

<!--Matches Section-->
				<div class="col-xs-12 col-md-4">
					<h2 class="index_headers" >Upcoming Matches</h2>
						<div class="indexpage_box" style="overflow:scroll">
							<?php
						    	//matches
								//$sqlDataGames="CALL gaaplayermanager2.twoIndexgamesdata($selectedTeamID)";
								$sqlDataGames="SELECT * FROM gaaplayermanager2.games AS g INNER JOIN gaaplayermanager2.season AS s ON s.Season_ID = g.Season_Season_ID WHERE g.Team=$selectedTeamID ORDER BY g.Game_Date DESC;";
								$rsDataGames=getTableData($conn,$sqlDataGames);
								$arrayDataGames=checkResultSet($rsDataGames);
									foreach($arrayDataGames as $row) {
										$name = $selectedTeamName. ' v ' .$row['Opposition']. ' - ' .$row['Competition']. ' - ' .$row['Game_Date'];
										$id=$row['Game_ID'];  //get the current PK value
										$buttonText=$name;
										include 'FORMS/buttonWithText3indexpage.html';
									}
							?>
					</div>
				</div><!--end of col-->

<!--Injured Players Section-->
				<div class="col-xs-12 col-md-4">
					<h2 class="index_headers" >Injured Players</h2>
						<div class="indexpage_box" style="overflow:scroll">
							<?php
								//$sqlDataInjury="CALL gaaplayermanager2.twoIndexinjurydata($selectedTeamID)";
								$sqlDataInjury="SELECT i.Injury_ID, u.First_Name, u.Last_Name, iu.Injury_Type FROM gaaplayermanager2.injury AS i INNER JOIN gaaplayermanager2.users AS u ON u.User_ID = i.Users_User_ID INNER JOIN gaaplayermanager2.injury_types AS iu ON i.Injury_Types_Injury_Types_ID = iu.Injury_Types_ID WHERE i.Team_ID=$selectedTeamID && i.Recovery_Status_Recovery_Status_ID < 2;";
								$rsDataInjury=getTableData($conn,$sqlDataInjury);
								$arrayDataInjury=checkResultSet($rsDataInjury);
								$conn->close();
									foreach($arrayDataInjury as $row) {
										$name = $row['First_Name']. ' ' .$row['Last_Name']. ' - ' .$row['Injury_Type'];
										$id=$row['Injury_ID'];  //get the current PK value
										$buttonText=$name;
										include 'FORMS/buttonWithText3indexpage.html';
									}
							?>
						</div>
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
















 



