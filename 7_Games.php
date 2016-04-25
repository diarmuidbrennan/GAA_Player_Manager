<?php
	// Start the session
	session_start();

    $selectedUserID = $_SESSION['UserID'];
    $selectedUserType = $_SESSION['UserType'];
	$selectedTeamID = $_SESSION['TeamID'];
	$selectedTeamName = $_SESSION['TeamName'];
	$selectedUserEnabled = $_SESSION['Enabled'];
	$matchopposition = $_SESSION['matchOpposition'];
	$matchID = 1;
	
	$testmatchID = (!empty($_SESSION['matchID']) ? $_SESSION['matchID'] : null);						
		
		if ($testmatchID !=null){
			$matchID = $_SESSION['matchID'];
		}

	//check if the user has logged in
	if (!isset($_SESSION['UserID'])){
    	echo "<script> window.location.assign('1_Login.php'); </script>";
    }

        if ($selectedUserType > 2){
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
							$PK="Game_ID";
							$Team="Team_ID";  //Specify the PK of the table
							$UserTeamID=$_SESSION['TeamID'];
							$selectedID=$_SESSION["primarykey"];  //get the ID of the record we want to update from the form
							//$sqlData="CALL gaaplayermanager2.sevenMatchdayGetTeam ($UserTeamID)";
							$sqlData="SELECT * FROM gaaplayermanager2.matchday_team AS mt INNER JOIN gaaplayermanager2.users AS u ON u.User_ID = mt.User_User_ID INNER JOIN gaaplayermanager2.games AS g ON g.Game_ID = mt.Match_Match_ID INNER JOIN gaaplayermanager2.player_positions AS pp ON mt.Player_Positions_Player_Positions_ID = pp.Player_Positions_ID WHERE u.Team = $UserTeamID && g.Game_ID = 3;";
							$rsData=getTableData($conn,$sqlData);
							$arrayDataMT=checkResultSet($rsData);
							
							//$sqlDataAllUsers="CALL gaaplayermanager2.fourProfilesuserbuttonsplayer($selectedTeamID)";
							$sqlDataAllUsers="SELECT * FROM gaaplayermanager2.users WHERE Team = $UserTeamID && User_Type = 3 && Enabled = 1;";
							$rsDataAllUsers=getTableData($conn,$sqlDataAllUsers);
							$arrayDataAllUsers=checkResultSet($rsDataAllUsers);


						?>

		<div id="indexpage_box_container">
			<form class="" method="post" autocomplete="off" action="<?php echo $_SERVER['PHP_SELF'];?>">
			<div class="row"><br>
				<div class="col-xs-12 col-md-6">
					
					<div id="gaa_image">
						<img id="gaa_image_edit" src="IMAGES/Gaelic_football_pitch_diagram.svg" />

			<!--Player 1-->

						<select class="playerbutton" id="playerbutton1" name="player1">
						<option value="default">Player1</option>
						<?php

							//$sqlData="CALL gaaplayermanager2. sevenMatchdayGetPositions ($UserTeamID, $position)";
							$sqlData="SELECT * FROM gaaplayermanager2.matchday_team WHERE Match_Match_ID = $matchID && Player_Positions_Player_Positions_ID = 1;";
							$rsData=getTableData($conn,$sqlData);
							$arrayDataMT=checkResultSet($rsData);
							foreach($arrayDataMT as $row1) {
							$MTUserid1=$row1['User_User_ID'];  //get the current PK value
							}
							foreach($arrayDataAllUsers as $row) {
							$name = $row['First_Name']. ' ' .$row['Last_Name'];
							$id=$row['User_ID'];  //get the current PK value 
						?>
						<option value="<?php echo $id; ?>" <?php if ($MTUserid1 == $row['User_ID']) { echo 'selected'; } ?> ><?php echo $name; ?></option>
						<?php 
							} 
						
						?>
						</select>
						

			<!--Player 2-->
						<select class="playerbutton" id="playerbutton2" name="player2">
						<option value="default">Player2</option>
						<?php 
							//$sqlData="CALL gaaplayermanager2. sevenMatchdayGetPositions ($UserTeamID, $position)";
							$sqlData="SELECT * FROM gaaplayermanager2.matchday_team WHERE Match_Match_ID = $matchID && Player_Positions_Player_Positions_ID = 2;";
							$rsData=getTableData($conn,$sqlData);
							$arrayDataMT=checkResultSet($rsData);
							foreach($arrayDataMT as $row1) {
							$MTUserid2=$row1['User_User_ID'];  //get the current PK value
							}
							foreach($arrayDataAllUsers as $row) {
							$name = $row['First_Name']. ' ' .$row['Last_Name'];
							$id=$row['User_ID'];  //get the current PK value 
						?>
						<option value="<?php echo $id; ?>" <?php if ($MTUserid2 == $row['User_ID']) { echo 'selected'; } ?> ><?php echo $name; ?></option>
						<?php 
							} 
						?>
						</select>

			<!--Player 3-->
						<select class="playerbutton" id="playerbutton3" name="player3">
						<option value="default">Player3</option>
						<?php
							//$sqlData="CALL gaaplayermanager2. sevenMatchdayGetPositions ($UserTeamID, $position)"; 
							$sqlData="SELECT * FROM gaaplayermanager2.matchday_team WHERE Match_Match_ID = $matchID && Player_Positions_Player_Positions_ID = 3;";
							$rsData=getTableData($conn,$sqlData);
							$arrayDataMT=checkResultSet($rsData);
							foreach($arrayDataMT as $row1) {
							$MTUserid3=$row1['User_User_ID'];  //get the current PK value
							}
							foreach($arrayDataAllUsers as $row) {
							$name = $row['First_Name']. ' ' .$row['Last_Name'];
							$id=$row['User_ID'];  //get the current PK value 
						?>
						<option value="<?php echo $id; ?>" <?php if ($MTUserid3 == $row['User_ID']) { echo 'selected'; } ?> ><?php echo $name; ?></option>
						<?php 
							} 
						?>
						</select>

			<!--Player 4-->
						<select class="playerbutton" id="playerbutton4" name="player4">
						<option value="default">Player4</option>
						<?php
							//$sqlData="CALL gaaplayermanager2. sevenMatchdayGetPositions ($UserTeamID, $position)";
							$sqlData="SELECT * FROM gaaplayermanager2.matchday_team WHERE Match_Match_ID = $matchID && Player_Positions_Player_Positions_ID = 4;";
							$rsData=getTableData($conn,$sqlData);
							$arrayDataMT=checkResultSet($rsData);
							foreach($arrayDataMT as $row1) {
							$MTUserid4=$row1['User_User_ID'];  //get the current PK value
							}
							foreach($arrayDataAllUsers as $row) {
							$name = $row['First_Name']. ' ' .$row['Last_Name'];
							$id=$row['User_ID'];  //get the current PK value 
						?>
						<option value="<?php echo $id; ?>" <?php if ($MTUserid4 == $row['User_ID']) { echo 'selected'; } ?> ><?php echo $name; ?></option>
						<?php 
							} 
						?>
						</select>

			<!--Player 5-->
						<select class="playerbutton" id="playerbutton5" name="player5">
						<option value="default">Player5</option>
						<?php
							//$sqlData="CALL gaaplayermanager2. sevenMatchdayGetPositions ($UserTeamID, $position)";
							$sqlData="SELECT * FROM gaaplayermanager2.matchday_team WHERE Match_Match_ID = $matchID && Player_Positions_Player_Positions_ID = 5;";
							$rsData=getTableData($conn,$sqlData);
							$arrayDataMT=checkResultSet($rsData);
							foreach($arrayDataMT as $row1) {
							$MTUserid5=$row1['User_User_ID'];  //get the current PK value
							}
							foreach($arrayDataAllUsers as $row) {
							$name = $row['First_Name']. ' ' .$row['Last_Name'];
							$id=$row['User_ID'];  //get the current PK value 
						?>
						<option value="<?php echo $id; ?>" <?php if ($MTUserid5 == $row['User_ID']) { echo 'selected'; } ?> ><?php echo $name; ?></option>
						<?php 
							} 
						?>
						</select>

			<!--Player 6-->
						<select class="playerbutton" id="playerbutton6" name="player6">
						<option value="default">Player6</option>
						<?php
							//$sqlData="CALL gaaplayermanager2. sevenMatchdayGetPositions ($UserTeamID, $position)";
							$sqlData="SELECT * FROM gaaplayermanager2.matchday_team WHERE Match_Match_ID = $matchID && Player_Positions_Player_Positions_ID = 6;";
							$rsData=getTableData($conn,$sqlData);
							$arrayDataMT=checkResultSet($rsData);
							foreach($arrayDataMT as $row1) {
							$MTUserid6=$row1['User_User_ID'];  //get the current PK value
							}
							foreach($arrayDataAllUsers as $row) {
							$name = $row['First_Name']. ' ' .$row['Last_Name'];
							$id=$row['User_ID'];  //get the current PK value 
						?>
						<option value="<?php echo $id; ?>" <?php if ($MTUserid6 == $row['User_ID']) { echo 'selected'; } ?> ><?php echo $name; ?></option>
						<?php 
							} 
						?>
						</select>

			<!--Player 7-->
						<select class="playerbutton" id="playerbutton7" name="player7">
						<option value="default">Player7</option>
						<?php
							//$sqlData="CALL gaaplayermanager2. sevenMatchdayGetPositions ($UserTeamID, $position)";
							$sqlData="SELECT * FROM gaaplayermanager2.matchday_team WHERE Match_Match_ID = $matchID && Player_Positions_Player_Positions_ID = 7;";
							$rsData=getTableData($conn,$sqlData);
							$arrayDataMT=checkResultSet($rsData);
							foreach($arrayDataMT as $row1) {
							$MTUserid7=$row1['User_User_ID'];  //get the current PK value
							}
							foreach($arrayDataAllUsers as $row) {
							$name = $row['First_Name']. ' ' .$row['Last_Name'];
							$id=$row['User_ID'];  //get the current PK value 
						?>
						<option value="<?php echo $id; ?>" <?php if ($MTUserid7 == $row['User_ID']) { echo 'selected'; } ?> ><?php echo $name; ?></option>
						<?php 
							} 
						?>
						</select>

			<!--Player 8-->
						<select class="playerbutton" id="playerbutton8" name="player8">
						<option value="default">Player8</option>
						<?php
							//$sqlData="CALL gaaplayermanager2. sevenMatchdayGetPositions ($UserTeamID, $position)";
							$sqlData="SELECT * FROM gaaplayermanager2.matchday_team WHERE Match_Match_ID = $matchID && Player_Positions_Player_Positions_ID = 8;";
							$rsData=getTableData($conn,$sqlData);
							$arrayDataMT=checkResultSet($rsData);
							foreach($arrayDataMT as $row1) {
							$MTUserid8=$row1['User_User_ID'];  //get the current PK value
							}
							foreach($arrayDataAllUsers as $row) {
							$name = $row['First_Name']. ' ' .$row['Last_Name'];
							$id=$row['User_ID'];  //get the current PK value 
						?>
						<option value="<?php echo $id; ?>" <?php if ($MTUserid8 == $row['User_ID']) { echo 'selected'; } ?> ><?php echo $name; ?></option>
						<?php 
							} 
						?>
						</select>

			<!--Player 9-->
						<select class="playerbutton" id="playerbutton9" name="player9">
						<option value="default">Player9</option>
						<?php
							//$sqlData="CALL gaaplayermanager2. sevenMatchdayGetPositions ($UserTeamID, $position)";
							$sqlData="SELECT * FROM gaaplayermanager2.matchday_team WHERE Match_Match_ID = $matchID && Player_Positions_Player_Positions_ID = 9;";
							$rsData=getTableData($conn,$sqlData);
							$arrayDataMT=checkResultSet($rsData);
							foreach($arrayDataMT as $row1) {
							$MTUserid9=$row1['User_User_ID'];  //get the current PK value
							}
							foreach($arrayDataAllUsers as $row) {
							$name = $row['First_Name']. ' ' .$row['Last_Name'];
							$id=$row['User_ID'];  //get the current PK value 
						?>
						<option value="<?php echo $id; ?>" <?php if ($MTUserid9 == $row['User_ID']) { echo 'selected'; } ?> ><?php echo $name; ?></option>
						<?php 
							} 
						?>
						</select>

			<!--Player 10-->
						<select class="playerbutton" id="playerbutton10" name="player10">
						<option value="default">Player10</option>
						<?php
							//$sqlData="CALL gaaplayermanager2. sevenMatchdayGetPositions ($UserTeamID, $position)";
							$sqlData="SELECT * FROM gaaplayermanager2.matchday_team WHERE Match_Match_ID = $matchID && Player_Positions_Player_Positions_ID = 10;";
							$rsData=getTableData($conn,$sqlData);
							$arrayDataMT=checkResultSet($rsData);
							foreach($arrayDataMT as $row1) {
							$MTUserid10=$row1['User_User_ID'];  //get the current PK value
							}
							foreach($arrayDataAllUsers as $row) {
							$name = $row['First_Name']. ' ' .$row['Last_Name'];
							$id=$row['User_ID'];  //get the current PK value 
						?>
						<option value="<?php echo $id; ?>" <?php if ($MTUserid10 == $row['User_ID']) { echo 'selected'; } ?> ><?php echo $name; ?></option>
						<?php 
							} 
						?>
						</select>

			<!--Player 11-->
						<select class="playerbutton" id="playerbutton11" name="player11">
						<option value="default">Player11</option>
						<?php
							//$sqlData="CALL gaaplayermanager2. sevenMatchdayGetPositions ($UserTeamID, $position)";
							$sqlData="SELECT * FROM gaaplayermanager2.matchday_team WHERE Match_Match_ID = $matchID && Player_Positions_Player_Positions_ID = 11;";
							$rsData=getTableData($conn,$sqlData);
							$arrayDataMT=checkResultSet($rsData);
							foreach($arrayDataMT as $row1) {
							$MTUserid11=$row1['User_User_ID'];  //get the current PK value
							}
							foreach($arrayDataAllUsers as $row) {
							$name = $row['First_Name']. ' ' .$row['Last_Name'];
							$id=$row['User_ID'];  //get the current PK value 
						?>
						<option value="<?php echo $id; ?>" <?php if ($MTUserid11 == $row['User_ID']) { echo 'selected'; } ?> ><?php echo $name; ?></option>
						<?php 
							} 
						?>
						</select>

			<!--Player 12-->
						<select class="playerbutton" id="playerbutton12" name="player12">
						<option value="default">Player12</option>
						<?php
							//$sqlData="CALL gaaplayermanager2. sevenMatchdayGetPositions ($UserTeamID, $position)";
							$sqlData="SELECT * FROM gaaplayermanager2.matchday_team WHERE Match_Match_ID = $matchID && Player_Positions_Player_Positions_ID = 12;";
							$rsData=getTableData($conn,$sqlData);
							$arrayDataMT=checkResultSet($rsData);
							foreach($arrayDataMT as $row1) {
							$MTUserid12=$row1['User_User_ID'];  //get the current PK value
							}
							foreach($arrayDataAllUsers as $row) {
							$name = $row['First_Name']. ' ' .$row['Last_Name'];
							$id=$row['User_ID'];  //get the current PK value 
						?>
						<option value="<?php echo $id; ?>" <?php if ($MTUserid12 == $row['User_ID']) { echo 'selected'; } ?> ><?php echo $name; ?></option>
						<?php 
							} 
						?>
						</select>

			<!--Player 13-->
						<select class="playerbutton" id="playerbutton13" name="player13">
						<option value="default">Player13</option>
						<?php
							//$sqlData="CALL gaaplayermanager2. sevenMatchdayGetPositions ($UserTeamID, $position)";
							$sqlData="SELECT * FROM gaaplayermanager2.matchday_team WHERE Match_Match_ID = $matchID && Player_Positions_Player_Positions_ID = 13;";
							$rsData=getTableData($conn,$sqlData);
							$arrayDataMT=checkResultSet($rsData);
							foreach($arrayDataMT as $row1) {
							$MTUserid13=$row1['User_User_ID'];  //get the current PK value
							}
							foreach($arrayDataAllUsers as $row) {
							$name = $row['First_Name']. ' ' .$row['Last_Name'];
							$id=$row['User_ID'];  //get the current PK value 
						?>
						<option value="<?php echo $id; ?>" <?php if ($MTUserid13 == $row['User_ID']) { echo 'selected'; } ?> ><?php echo $name; ?></option>
						<?php 
							} 
						?>
						</select>

			<!--Player 14-->
						<select class="playerbutton" id="playerbutton14" name="player14">
						<option value="default">Player14</option>
						<?php
							//$sqlData="CALL gaaplayermanager2. sevenMatchdayGetPositions ($UserTeamID, $position)";
							$sqlData="SELECT * FROM gaaplayermanager2.matchday_team WHERE Match_Match_ID = $matchID && Player_Positions_Player_Positions_ID = 14;";
							$rsData=getTableData($conn,$sqlData);
							$arrayDataMT=checkResultSet($rsData);
							foreach($arrayDataMT as $row1) {
							$MTUserid14=$row1['User_User_ID'];  //get the current PK value
							}
							foreach($arrayDataAllUsers as $row) {
							$name = $row['First_Name']. ' ' .$row['Last_Name'];
							$id=$row['User_ID'];  //get the current PK value 
						?>
						<option value="<?php echo $id; ?>" <?php if ($MTUserid14 == $row['User_ID']) { echo 'selected'; } ?> ><?php echo $name; ?></option>
						<?php 
							} 
						?>
						</select>

			<!--Player 15-->
						<select class="playerbutton" id="playerbutton15" name="player15">
						<option value="default">Player15</option>
						<?php
							//$sqlData="CALL gaaplayermanager2. sevenMatchdayGetPositions ($UserTeamID, $position)";
							$sqlData="SELECT * FROM gaaplayermanager2.matchday_team WHERE Match_Match_ID = $matchID && Player_Positions_Player_Positions_ID = 15;";
							$rsData=getTableData($conn,$sqlData);
							$arrayDataMT=checkResultSet($rsData);
							foreach($arrayDataMT as $row1) {
							$MTUserid15=$row1['User_User_ID'];  //get the current PK value
							}
							foreach($arrayDataAllUsers as $row) {
							$name = $row['First_Name']. ' ' .$row['Last_Name'];
							$id=$row['User_ID'];  //get the current PK value 
						?>
						<option value="<?php echo $id; ?>" <?php if ($MTUserid15 == $row['User_ID']) { echo 'selected'; } ?> ><?php echo $name; ?></option>
						<?php 
							} 
						?>
						</select>

			<!--Player 16-->
						<select class="playerbutton" id="playerbutton16" name="player16">
						<option value="default">Player16</option>
						<?php
							//$sqlData="CALL gaaplayermanager2. sevenMatchdayGetPositions ($UserTeamID, $position)";
							$sqlData="SELECT * FROM gaaplayermanager2.matchday_team WHERE Match_Match_ID = $matchID && Player_Positions_Player_Positions_ID = 16;";
							$rsData=getTableData($conn,$sqlData);
							$arrayDataMT=checkResultSet($rsData);
							foreach($arrayDataMT as $row1) {
							$MTUserid16=$row1['User_User_ID'];  //get the current PK value
							}
							foreach($arrayDataAllUsers as $row) {
							$name = $row['First_Name']. ' ' .$row['Last_Name'];
							$id=$row['User_ID'];  //get the current PK value 
						?>
						<option value="<?php echo $id; ?>" <?php if ($MTUserid16 == $row['User_ID']) { echo 'selected'; } ?> ><?php echo $name; ?></option>
						<?php 
							} 
						?>
						</select>

			<!--Player 17-->
						<select class="playerbutton" id="playerbutton17" name="player17">
						<option value="default">Player17</option>
						<?php
							//$sqlData="CALL gaaplayermanager2. sevenMatchdayGetPositions ($UserTeamID, $position)";
							$sqlData="SELECT * FROM gaaplayermanager2.matchday_team WHERE Match_Match_ID = $matchID && Player_Positions_Player_Positions_ID = 17;";
							$rsData=getTableData($conn,$sqlData);
							$arrayDataMT=checkResultSet($rsData);
							foreach($arrayDataMT as $row1) {
							$MTUserid17=$row1['User_User_ID'];  //get the current PK value
							}
							foreach($arrayDataAllUsers as $row) {
							$name = $row['First_Name']. ' ' .$row['Last_Name'];
							$id=$row['User_ID'];  //get the current PK value 
						?>
						<option value="<?php echo $id; ?>" <?php if ($MTUserid17 == $row['User_ID']) { echo 'selected'; } ?> ><?php echo $name; ?></option>
						<?php 
							} 
						?>
						</select>

			<!--Player 18-->
						<select class="playerbutton" id="playerbutton18" name="player18">
						<option value="default">Player18</option>
						<?php
							//$sqlData="CALL gaaplayermanager2. sevenMatchdayGetPositions ($UserTeamID, $position)";
							$sqlData="SELECT * FROM gaaplayermanager2.matchday_team WHERE Match_Match_ID = $matchID && Player_Positions_Player_Positions_ID = 18;";
							$rsData=getTableData($conn,$sqlData);
							$arrayDataMT=checkResultSet($rsData);
							foreach($arrayDataMT as $row1) {
							$MTUserid18=$row1['User_User_ID'];  //get the current PK value
							}
							foreach($arrayDataAllUsers as $row) {
							$name = $row['First_Name']. ' ' .$row['Last_Name'];
							$id=$row['User_ID'];  //get the current PK value 
						?>
						<option value="<?php echo $id; ?>" <?php if ($MTUserid18 == $row['User_ID']) { echo 'selected'; } ?> ><?php echo $name; ?></option>
						<?php 
							} 
						?>
						</select>

			<!--Player 19-->
						<select class="playerbutton" id="playerbutton19" name="player19">
						<option value="default">Player19</option>
						<?php
							//$sqlData="CALL gaaplayermanager2. sevenMatchdayGetPositions ($UserTeamID, $position)";
							$sqlData="SELECT * FROM gaaplayermanager2.matchday_team WHERE Match_Match_ID = $matchID && Player_Positions_Player_Positions_ID = 19;";
							$rsData=getTableData($conn,$sqlData);
							$arrayDataMT=checkResultSet($rsData);
							foreach($arrayDataMT as $row1) {
							$MTUserid19=$row1['User_User_ID'];  //get the current PK value
							}
							foreach($arrayDataAllUsers as $row) {
							$name = $row['First_Name']. ' ' .$row['Last_Name'];
							$id=$row['User_ID'];  //get the current PK value 
						?>
						<option value="<?php echo $id; ?>" <?php if ($MTUserid19 == $row['User_ID']) { echo 'selected'; } ?> ><?php echo $name; ?></option>
						<?php 
							} 
						?>
						</select>

			<!--Player 20-->
						<select class="playerbutton" id="playerbutton20" name="player20">
						<option value="default">Player20</option>
						<?php
							//$sqlData="CALL gaaplayermanager2. sevenMatchdayGetPositions ($UserTeamID, $position)";
							$sqlData="SELECT * FROM gaaplayermanager2.matchday_team WHERE Match_Match_ID = $matchID && Player_Positions_Player_Positions_ID = 20;";
							$rsData=getTableData($conn,$sqlData);
							$arrayDataMT=checkResultSet($rsData);
							foreach($arrayDataMT as $row1) {
							$MTUserid20=$row1['User_User_ID'];  //get the current PK value
							}
							foreach($arrayDataAllUsers as $row) {
							$name = $row['First_Name']. ' ' .$row['Last_Name'];
							$id=$row['User_ID'];  //get the current PK value 
						?>
						<option value="<?php echo $id; ?>" <?php if ($MTUserid20 == $row['User_ID']) { echo 'selected'; } ?> ><?php echo $name; ?></option>
						<?php 
							} 
						?>
						</select>

			<!--Player 21-->
						<select class="playerbutton" id="playerbutton21" name="player21">
						<option value="default">Player21</option>
						<?php
							//$sqlData="CALL gaaplayermanager2. sevenMatchdayGetPositions ($UserTeamID, $position)";
							$sqlData="SELECT * FROM gaaplayermanager2.matchday_team WHERE Match_Match_ID = $matchID && Player_Positions_Player_Positions_ID = 21;";
							$rsData=getTableData($conn,$sqlData);
							$arrayDataMT=checkResultSet($rsData);
							foreach($arrayDataMT as $row1) {
							$MTUserid21=$row1['User_User_ID'];  //get the current PK value
							}
							foreach($arrayDataAllUsers as $row) {
							$name = $row['First_Name']. ' ' .$row['Last_Name'];
							$id=$row['User_ID'];  //get the current PK value 
						?>
						<option value="<?php echo $id; ?>" <?php if ($MTUserid21 == $row['User_ID']) { echo 'selected'; } ?> ><?php echo $name; ?></option>
						<?php 
							} 
						?>
						</select>

			<!--Player 22-->
						<select class="playerbutton" id="playerbutton22" name="player22">
						<option value="default">Player22</option>
						<?php
							//$sqlData="CALL gaaplayermanager2. sevenMatchdayGetPositions ($UserTeamID, $position)";
							$sqlData="SELECT * FROM gaaplayermanager2.matchday_team WHERE Match_Match_ID = $matchID && Player_Positions_Player_Positions_ID = 22;";
							$rsData=getTableData($conn,$sqlData);
							$arrayDataMT=checkResultSet($rsData);
							foreach($arrayDataMT as $row1) {
							$MTUserid22=$row1['User_User_ID'];  //get the current PK value
							}
							foreach($arrayDataAllUsers as $row) {
							$name = $row['First_Name']. ' ' .$row['Last_Name'];
							$id=$row['User_ID'];  //get the current PK value 
						?>
						<option value="<?php echo $id; ?>" <?php if ($MTUserid22 == $row['User_ID']) { echo 'selected'; } ?> ><?php echo $name; ?></option>
						<?php 
							} 
						?>
						</select>

			<!--Player 23-->
						<select class="playerbutton" id="playerbutton23" name="player23">
						<option value="default">Player23</option>
						<?php
							//$sqlData="CALL gaaplayermanager2. sevenMatchdayGetPositions ($UserTeamID, $position)";
							$sqlData="SELECT * FROM gaaplayermanager2.matchday_team WHERE Match_Match_ID = $matchID && Player_Positions_Player_Positions_ID = 23;";
							$rsData=getTableData($conn,$sqlData);
							$arrayDataMT=checkResultSet($rsData);
							foreach($arrayDataMT as $row1) {
							$MTUserid23=$row1['User_User_ID'];  //get the current PK value
							}
							foreach($arrayDataAllUsers as $row) {
							$name = $row['First_Name']. ' ' .$row['Last_Name'];
							$id=$row['User_ID'];  //get the current PK value 
						?>
						<option value="<?php echo $id; ?>" <?php if ($MTUserid23 == $row['User_ID']) { echo 'selected'; } ?> ><?php echo $name; ?></option>
						<?php 
							} 
						?>
						</select>

			<!--Player 24-->
						<select class="playerbutton" id="playerbutton24" name="player24">
						<option value="default">Player24</option>
						<?php
							//$sqlData="CALL gaaplayermanager2. sevenMatchdayGetPositions ($UserTeamID, $position)";
							$sqlData="SELECT * FROM gaaplayermanager2.matchday_team WHERE Match_Match_ID = $matchID && Player_Positions_Player_Positions_ID = 24;";
							$rsData=getTableData($conn,$sqlData);
							$arrayDataMT=checkResultSet($rsData);
							foreach($arrayDataMT as $row1) {
							$MTUserid24=$row1['User_User_ID'];  //get the current PK value
							}
							foreach($arrayDataAllUsers as $row) {
							$name = $row['First_Name']. ' ' .$row['Last_Name'];
							$id=$row['User_ID'];  //get the current PK value 
						?>
						<option value="<?php echo $id; ?>" <?php if ($MTUserid24 == $row['User_ID']) { echo 'selected'; } ?> ><?php echo $name; ?></option>
						<?php 
							} 
						?>
						</select>

			<!--Player 25-->
						<select class="playerbutton" id="playerbutton25" name="player25">
						<option value="default">Player25</option>
						<?php
							//$sqlData="CALL gaaplayermanager2. sevenMatchdayGetPositions ($UserTeamID, $position)";
							$sqlData="SELECT * FROM gaaplayermanager2.matchday_team WHERE Match_Match_ID = $matchID && Player_Positions_Player_Positions_ID = 25;";
							$rsData=getTableData($conn,$sqlData);
							$arrayDataMT=checkResultSet($rsData);
							foreach($arrayDataMT as $row1) {
							$MTUserid25=$row1['User_User_ID'];  //get the current PK value
							}
							foreach($arrayDataAllUsers as $row) {
							$name = $row['First_Name']. ' ' .$row['Last_Name'];
							$id=$row['User_ID'];  //get the current PK value 
						?>
						<option value="<?php echo $id; ?>" <?php if ($MTUserid25 == $row['User_ID']) { echo 'selected'; } ?> ><?php echo $name; ?></option>
						<?php 
							} 
						?>
						</select>

			<!--Player 26-->
						<select class="playerbutton" id="playerbutton26" name="player26">
						<option value="default">Player26</option>
						<?php
							//$sqlData="CALL gaaplayermanager2. sevenMatchdayGetPositions ($UserTeamID, $position)";
							$sqlData="SELECT * FROM gaaplayermanager2.matchday_team WHERE Match_Match_ID = $matchID && Player_Positions_Player_Positions_ID = 26;";
							$rsData=getTableData($conn,$sqlData);
							$arrayDataMT=checkResultSet($rsData);
							foreach($arrayDataMT as $row1) {
							$MTUserid26=$row1['User_User_ID'];  //get the current PK value
							}
							foreach($arrayDataAllUsers as $row) {
							$name = $row['First_Name']. ' ' .$row['Last_Name'];
							$id=$row['User_ID'];  //get the current PK value 
						?>
						<option value="<?php echo $id; ?>" <?php if ($MTUserid26 == $row['User_ID']) { echo 'selected'; } ?> ><?php echo $name; ?></option>
						<?php 
							} 
						?>
						</select>
						<!--</form>-->

					</div>
										<h3><?php echo "$selectedTeamName"; ?> vs <?php echo "$matchopposition" ?><h3><br>
										<button class="index_page_buttons"  name="SaveMatchdayTeam" type="submit" >Save Matchday Team</button>
				
				</div>

			<!--Show current matches-->
				<div class="col-xs-12 col-md-6">
					<div class="gamepage_box" style="overflow:scroll">
					<?php
						//edit an existing match
						if(isset($_POST['editrecord']))  {//if the form has been submitted 
							$selectedID=$_POST['editrecord'];  //get the ID of the record we want to edit from the form
							$_SESSION['primarykey'] = $selectedID;
							echo "<script> window.location.assign('7.2_Games_Edit.php'); </script>";
						}

						if(isset($_POST['chooseopposition']))  {//if the form has been submitted 
							$matchID=$_POST['chooseopposition'];
							//$sqlData="CALL gaaplayermanager2. sevenMatchdayGetGameData ($matchID)";
							$sqlData="SELECT * FROM gaaplayermanager2.games WHERE Game_id = $matchID;";
							$rsData=getTableData($conn,$sqlData);
							$arrayData=checkResultSet($rsData);
							//echo "$sqlData";
							foreach($arrayData as $row) {
								$matchOpposition = $row['Opposition'];
							}
  							//get the ID of the record we want to edit from the form
							$_SESSION['matchOpposition'] = $matchOpposition;
							$_SESSION['matchID'] = $matchID;
							echo "<script> window.location.assign('7_Games.php'); </script>";
						}


							if(isset($_POST['SaveMatchdayTeam']))  {//if the form has been submitted 
							$selectedID=$matchID;  //get the ID of the record we want to edit from the form

							for ($i=1; $i<=26; $i++) {
								$user = ($_POST['player'.$i]);
								$position = $i;

								if ($user != 'default'){
								//$sqlDataAllUsers="CALL gaaplayermanager2. sevenMatchdaySaveTeam ($matchID, $position, $user)";
								$sqlInsert= "INSERT INTO matchday_team (Match_Match_ID, Player_Positions_Player_Positions_ID, User_User_ID) VALUES('$matchID', '$position', '$user');";
									if(queryInsert($conn,$sqlInsert)==1) {//execute the INSERT query
										echo "<h3>New data inserted successfully</h3>";
									}
									else {
									echo "<h3>Error data cannot be entered</h3>";
									}
								}
								echo "<script> window.location.assign('7_Games.php'); </script>";
								}
							}


							if(isset($_POST['deletematch']))  {//if the form has been submitted 
							$delMatchID=$_POST['deletematch'];  //get the ID of the record we want to edit from the form
							$sqlDel="DELETE FROM gaaplayermanager2.games WHERE Game_ID = $delMatchID;";

								if (deleteRecord($conn,$sqlDel))  {//call the deleteRecord() function
									echo "<h3>RECORD WITH PK=$selectedID DELETED</h3>";
									echo "<script> window.location.assign('7_Games.php'); </script>";
								}
								else {
									echo "<h3 >RECORD WITH PK=$selectedID CANNOT BE DELETED</h3>";
								}
							}


						else {
							//$sqlDataGames="CALL gaaplayermanager2. sevenMatchdayGetAllGames ($selectedTeamID)";
							$sqlDataGames="SELECT * FROM gaaplayermanager2.games AS g INNER JOIN gaaplayermanager2.season AS s ON s.Season_ID = g.Season_Season_ID WHERE g.Team=$selectedTeamID ORDER BY g.Game_Date";
							$rsDataGames=getTableData($conn,$sqlDataGames);
							$arrayDataGames=checkResultSet($rsDataGames);
							$conn->close();
							foreach($arrayDataGames as $row) {
							$name = $row['Competition']. '  v  ' .$row['Opposition']. ' - ' .$row['Game_Date'];
							$id=$row['Game_ID'];  //get the current PK value
							$buttonText=$name;
							include 'FORMS/buttonWithText3getopposition.html';
							}
						}

					?>
					</div><br><br>
				
				<a class="index_page_buttons" href="7.1_Games_Create.php" role="button">Create New Match Fixture</a>
				</div>
			</div>

		<div class="row"><br>
			<div class="col-xs-12 col-md-6">
				<!--<form  class="" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">-->
					
				<!--</form>-->
			</div>

			<div class="col-xs-12 col-md-6">
				
			</div><br>
		</div>





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
	</form>
</div><!--end of container-->

</body>
</html>
















 



