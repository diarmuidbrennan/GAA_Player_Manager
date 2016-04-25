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
		</div><!--end of row-->

    <div class="row">
        <div class="col-xs-12 col-md-12">
            <div id="navigation_option">
                <h1><?php echo $selectedTeamName; ?> Player Profiles</h1>
            </div><br>
        </div>
    </div>



<div class="row">
<div class="col-xs-12 col-md-12">
<?php


//----------------MAIN SECTION----------------------------//
//========================================================//

$table='users';  //table to delete records from
$PK="User_ID";  //Specify the PK of the table;
if(isset($_POST['SAVE']))	//execute the save button
{
						$target_dir = "IMAGES/profile_images";
						$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
						$filename = "$selectedUserID.png";
						$uploadOk = 1;
						$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
						// Check if image file is a actual image or fake image
 
 	//save the edited fields to the table in database 
	$selectedID=$_SESSION["primarykey"];
	$username = $_POST["Username"];
    $password1 = $_POST["Password1"];
    $password2 = $_POST["Password2"];
    $firstname = $_POST["FirstName"];
    $lastname = $_POST["LastName"];
    $DOB =  $_POST["DOB"];
    $Height = $_POST["Height"];
    $Weight = $_POST["Weight"];
    $Email = $_POST["Email"];
	$Phone = $_POST["Phone"];

    $username=$conn->real_escape_string($username);
	$salt = "tipperaryhurlers";
	$pass1=$conn->real_escape_string($password1);
	$pass2=$conn->real_escape_string($password2);
	$pass3=$pass1.$salt;
    $firstname = $conn->real_escape_string($firstname);
    $lastname = $conn->real_escape_string($lastname);
	$DOB=$conn->real_escape_string($DOB);
	$Height=$conn->real_escape_string($Height);
	$Weight=$conn->real_escape_string($Weight);
	$Email=$conn->real_escape_string($Email);
	$Phone=$conn->real_escape_string($Phone);



		if ($pass1===$pass2)
	{

	$passEncrypt= hash('ripemd160', $pass3); 

	//$sql="//$sqlInsert="CALL gaaplayermanager2.fourProfileCreateInsertUser('$Username','$passEncrypt','$FirstName','$LastName', $DOB,'$Height','$Weight','$Email','$Phone', '$filename', $selectedID)";
	$sql = "UPDATE $table SET" 
	    . " " . "Username = '$username'"	
	    . "," . "Password = '$passEncrypt'"
	    . "," . "First_Name = '$firstname'"
	    . "," . "Last_Name = '$lastname'"
	    . "," . "DOB = '$DOB'"
	    . "," . "Height = '$Height'"
	    . "," . "Weight = '$Weight'"
	    . "," . "email = '$Email'"
	    . "," . "phone = '$Phone'"
	    . "," . "image = '$filename'"
	    . " WHERE $PK = '$selectedID';";
	
	if (updateRecord($conn,$sql))  //call the updateRecord() function
	{
	echo "<h3>RECORD WITH PK=$selectedID UPDATED</h3>";

//_______________________________________________________________________________


								// Check if image file is a actual image or fake image
    								$check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    								if($check !== false) {
        								echo "File is an image - " . $check["mime"] . ".";
        								$uploadOk = 1;
    								} 
    								else {
        								echo "File is not an image.";
        								$uploadOk = 0;
    								}							
									// Check if file already exists
									if (file_exists($target_file)) {
    									echo "Sorry, file already exists.";
    									$uploadOk = 0;
									}
									// Check file size
									if ($_FILES["fileToUpload"]["size"] > 500000) {
    									echo "Sorry, your file is too large.";
    									$uploadOk = 0;
									}
									// Allow certain file formats
									if($imageFileType != "png") {
    									echo "Sorry, only PNG files are allowed.";
    									$uploadOk = 0;
									}
									// Check if $uploadOk is set to 0 by an error
									if ($uploadOk == 0) {
    								echo "Sorry, your file was not uploaded.";
									// if everything is ok, try to upload file
									} 
									else {
    									if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        									echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
    									} 
    									else {
       										echo "Sorry, there was an error uploading your file.";
    									}
									}
//________________________________________________________________________________


	//echo "<script> window.location.assign('4_Profiles.php'); </script>";
	}
	else
	{
	echo "<h3 >RECORD WITH PK=$selectedID CANNOT BE UPDATED</h3>";
	}
	

	//close the connection
	$conn->close();
	}
	else
	{ 
		echo "<p>Passwords dont match - data not entered";
	}
	

}

if(isset($_POST['CANCEL']))	//execute the save button
{
	echo "<script> window.location.assign('4_Profiles.php'); </script>";
}
	

else //this is the first time the form is loaded
{
	

	$selectedID=$_SESSION["primarykey"];  //get the ID of the record we want to update from the form
	//$sqlData="CALL gaaplayermanager2.fourProfilesuserprofile($selectedUserID)";
	$sqlData="SELECT * FROM $table WHERE $PK = '$selectedID'";  //get the data from the table

	//execute the 2 queries
	//echo $sqlData;
	$rsData=getTableData($conn,$sqlData);

	//check the results
	//$arrayData=checkResultSet($rsData);
	$row = $rsData->fetch_assoc();

	//use resultsets to generate HTML tables with EDIT button
    sendToEditPlayerForm($row["Username"], $row["Password"], $row["First_Name"] , $row["Last_Name"], $row["DOB"], $row["Height"], $row["Weight"], $row["email"], $row["phone"], $row["image"]);	

	//close the connection
	$conn->close();
}

?>

</div>
</div>

<div class="row">
<div class="col-xs-12 col-md-12">
<?php


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

</body>
</html>
















 



