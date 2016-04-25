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
                				<h1><?php echo $selectedTeamName; ?> Injuries</h1>
            			</div><br>
        		</div>
    	</div>

<!--//----------------MAIN SECTION----------------------------//-->
<!--//========================================================//-->

<div class="row">
<div class="col-xs-12 col-md-12">
<?php 


if(isset($_POST['send']))  //if the form has been submitted previously
{
	$table='injury';  //table to insert values into
	
	//INSERT QUERY

	//get the values entered in the form	
	$user=$conn->real_escape_string($_POST['Users']);
	$Team=1;
	$injurytype=$conn->real_escape_string($_POST['InjuryType']);
	$recoverystatus=$conn->real_escape_string($_POST['RecoveryStatus']);
	$comment=$conn->real_escape_string($_POST['Comment']);
	$dateinjured=$conn->real_escape_string($_POST['DateInjured']);
	$dateofreturn=$conn->real_escape_string($_POST['DateOfReturn']);
	

	//$sqlInsert="CALL gaaplayermanager2. eightInjuriesCreate ($user,$Team,$injurytype,$recoverystatus,'$comment',$dateinjured, $dateofreturn)";

	$sqlInsert= "INSERT INTO $table (Users_User_ID,Team_ID,Injury_Types_Injury_Types_ID,Recovery_Status_Recovery_Status_ID,Comment,Date_Occured,Date_Of_Return) VALUES('$user','$Team','$injurytype','$recoverystatus','$comment','$dateinjured', '$dateofreturn');";

		
	if(queryInsert($conn,$sqlInsert)==1) //execute the INSERT query
	{ 
	echo "<h3>New data inserted successfully</h3>";
	echo "<script> window.location.assign('8_Injuries.php'); </script>";
	}
	else
	{
	echo "$sqlInsert";
	echo "<h3>Error data cannot be entered</h3>";
	}
		
	
	}
	


	


else 
{
	// display the user registration form
	//include 'FORMS/newUserForm.txt';  //without validation
	include 'FORMS/newInjuryForm.html'; //with validation


}


?>

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
















 



