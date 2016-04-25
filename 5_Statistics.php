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
			<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"       type="text/javascript"></script> 
			<script src="JS/highcharts.js"></script>
			<script src="http://code.highcharts.com/modules/exporting.js"></script>
			<script src="JS/highcharts-more.js"></script>
	<link rel="stylesheet" type="text/css" href="CSS/Style.css">
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
                				<h1><?php echo $selectedTeamName; ?> Statistics</h1>
            			</div><br>
        		</div>
    	</div>


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
					<div id="chart" style="height: 400px; margin: 0 auto">

						<script src="JS/indexpagerightchart.js"></script>

					</div>
				</div><!--end of col-->
			</div><!--end of row-->



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
















 



