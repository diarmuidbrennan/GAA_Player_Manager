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



<!--//----------------MAIN SECTION----------------------------//-->
<!--//========================================================//-->
		<div id="profile_page_container">
			<div class="row">
				<div class="col-xs-12 col-md-12">
				<?php
					if(isset($_POST['send']))  {//if the form has been submitted previously
						$table='users';  //table to insert values into
						//$target_dir = "IMAGES/profile_images";
						//$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
						$filename = "$selectedUserID.png";
						//$uploadOk = 1;
						//$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
						// Check if image file is a actual image or fake image

						//get the values entered in the form	
						$Username=$conn->real_escape_string($_POST['Username']);
						$salt = "tipperaryhurlers";
						$pass1=$conn->real_escape_string($_POST['Password1']);
						$pass2=$conn->real_escape_string($_POST['Password2']);
						$pass3=$pass1.$salt;
						$usertype = 3;
						$FirstName=$conn->real_escape_string($_POST['FirstName']);
						$LastName=$conn->real_escape_string($_POST['LastName']);
						$DOB=$conn->real_escape_string($_POST['DOB']);
						$Height=$conn->real_escape_string($_POST['Height']);
						$Weight=$conn->real_escape_string($_POST['Weight']);
						$Email=$conn->real_escape_string($_POST['Email']);
						$Phone=$conn->real_escape_string($_POST['Phone']);
						$enabled=1;
						$Team=$selectedTeamID;

						if ($pass1===$pass2) {
							//see PHP manual  http://php.net/manual/en/function.password-hash.php
							//this hashing method works in PHP 5.1.2. +
							//the first parameter is the hash algorithm
							$passEncrypt= hash('ripemd160', $pass3);  //this algorithm requires 40 chars field length
							//$sqlInsert="CALL gaaplayermanager2.fourProfileCreateInsertUser('$Username','$passEncrypt', $usertype,'$FirstName','$LastName', $DOB,'$Height','$Weight','$Email','$Phone', $enabled, $Team, '$filename')";
							$sqlInsert= "INSERT INTO $table (Username,Password,User_Type,First_Name,Last_Name,DOB,Height,Weight,email,phone,Enabled,Team, image) VALUES('$Username','$passEncrypt','$usertype','$FirstName','$LastName','$DOB','$Height','$Weight','$Email','$Phone','$enabled','$Team', '$filename')";

							if(queryInsert($conn,$sqlInsert)==1) {//execute the INSERT query
								echo "<h3>New data inserted successfully</h3>";
//_______________________________________________________________________________
/*
require_once ('phpmailer/PHPMailerAutoload.php');
//require_once('phpmailer/class.phpmailer.php');
//require_once ('phpmailer/PHPMailerAutoload.php');
$mail = new PHPMailer();

//$mail->IsSMTP();
$mail->SMTPAuth = true;
$mail->Host = "smtp.mail.yahoo.com";
$mail->Port = 587;
$mail->Username = "diarmuidbren@yahoo.co.uk";
$mail->Password = "Sofill2methepartingglass";


$mail->SetFrom('diarmuidbren@yahoo.co.uk', 'GAA Player Manager');
$mail->Subject = "A Transactional Email From Web App";
$mail->MsgHTML("Your username is ");
$mail->AddAddress($Email, $FirstName);

$headers = 'From: <diarmuidbren@yahoo.co.uk>' . "\r\n" .
'Reply-To: <diarmuidbrennan09@gmail.com>';

mail('<diarmuidbren@yahoo.co.uk>', 'the subject', 'the message', $headers,
  '-diarmuidbrennan09@gmail.com');

if($mail->Send()) {
  echo "Message sent!";
} else {
  echo "Mailer Error: " . $mail->ErrorInfo;
}

function smtp_mail($to, $from, $message, $user, $pass, $host, $port)
{
	if ($h = fsockopen($host, $port))
	{
		$data = array(
			0,
			"EHLO $host",
			'AUTH LOGIN',
			base64_encode($user),
			base64_encode($pass),
			"MAIL FROM: <$from>",
			"RCPT TO: <$to>",
			'DATA',
			$message
		);
		foreach($data as $c)
		{
			$c && fwrite($h, "$c\r\n");
			while(substr(fgets($h, 256), 3, 1) != ' '){}
		}
		fwrite($h, "QUIT\r\n");
		return fclose($h);
	}
}
*/

/*
This is a very tiny proof-of-concept SMTP client. Currently it's over 320 characters (if the var names are compressed). Think you can build one smaller?
*/
/*
ini_set('default_socket_timeout', 3);
$user = 'brennanonthemoor@gmail.com';
$pass = 'Sofill2methepartingglass';
$host = 'ssl://smtp.gmail.com';
//$host = 'ssl://email-smtp.us-east-1.amazonaws.com'; //Amazon SES
$port = 465;
$to = 'diarmuidbrennan09@gmail.com';
$from = 'brennanonthemoor@gmail.com';
$template = "Subject: =?UTF-8?B?VGVzdCBFbWFpbA==?=\r\n"
."To: <diarmuidbrennan09@gmail.com>\r\n"
."From: brennanonthemoor@gmail.com\r\n"
."MIME-Version: 1.0\r\n"
."Content-Type: text/html; charset=utf-8\r\n"
."Content-Transfer-Encoding: base64\r\n\r\n"
."PGgxPlRlc3QgRW1haWw8L2gxPjxwPkhlbGxvIFRoZXJlITwvcD4=\r\n.";
if(smtp_mail($to, $from, $template, $user, $pass, $host, $port))
{
	echo "Mail sent\n\n";
}
else
{
	echo "Some error occured\n\n";
}
        



//_______________________________________________________________________________

								/* Check if image file is a actual image or fake image
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
*/
								echo "<script> window.location.assign('4_Profiles.php'); </script>";
							}
							else {
								echo "<h3>Error data cannot be entered</h3>";
							}
						}
						else {
							echo "<p>Passwords dont match - data not entered";
						}
					}
					else {
					// display the user registration form
					//include 'FORMS/newUserForm.txt';  //without validation
					include 'FORMS/newGAAPlayerForm.html'; //with validation
					}
				?>
			</div>
		</div><!--end of row-->





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