<?php
//helper functions

function getTableData($connection,$sql)
{
	try {
		$rs=$connection->query($sql);
		return $rs;
	}
	//catch exception
	catch(Exception $e) {
		if (__DEBUG==1) 
			{ 
			echo 'Message: ' .$e->getMessage();
			exit('<p class="warning">PHP script terminated');
			}
		else
			{	
			header("Location:".__USER_ERROR_PAGE);
			}
	}
}

function checkResultSet($rs)
	{
	if($rs === false) {
		if (__DEBUG==1)
		{
		echo 'Wrong SQL: ' . $sql . ' Error: ' . $conn->error;
		exit('<p class="warning">PHP script terminated');
		}
		else
			{	
			header("Location:".__USER_ERROR_PAGE);
			}
	} else {
		$arr = $rs->fetch_all(MYSQLI_ASSOC);  //put the result into an array
		return $arr;
	}
}

function generateTable($tableName, $titlesResultSet, $dataResultSet)
{
	//use resultsets to generate HTML tables

	echo "<table border=1>";

	//first - create the table caption and headings
	echo "<caption>".strtoupper($tableName)." TABLE - QUERY RESULT</caption>";
	echo '<tr>';
	foreach($titlesResultSet as $fieldName) {
		echo '<th>'.$fieldName['Field'].'</th>';
	}
	echo '</tr>';

	//then show the data
	foreach($dataResultSet as $row) {
		echo '<tr>';
		foreach($titlesResultSet as $fieldName) {
			echo '<td>'.$row[$fieldName['Field']].'</td>';}
		echo '</tr>';
		}
	echo "</table>";
}

function generateDeleteTable($tableName, $primaryKey, $titlesResultSet, $dataResultSet)
{
	//use resultsets to generate HTML tables

	echo "<table border=1>";

	//first - create the table caption and headings
	echo "<caption>".strtoupper($tableName)." TABLE - QUERY RESULT</caption>";
	echo '<tr>';
	foreach($titlesResultSet as $fieldName) {
		echo '<th>'.$fieldName['Field'].'</th>';
	}
	echo '<th>DELETE</th>';
	echo '</tr>';

	//then show the data
	foreach($dataResultSet as $row) {
		echo '<tr>';
		foreach($titlesResultSet as $fieldName) {
			echo '<td>'.$row[$fieldName['Field']].'</td>';}
		echo '<td>';
		//set the button values and display the button ton the form:
		$id=$row[$primaryKey];  //get the current PK value
		$buttonText="Delete";
		include 'FORMS/buttonWithText2.html';
		echo '</td>';
		echo '</tr>';
		}
	echo "</table>";
}

function generateDeleteEditTable($tableName, $primaryKey, $titlesResultSet, $dataResultSet)
{
	//use resultsets to generate HTML tables

	echo "<table border=1>";

	//first - create the table caption and headings
	echo "<caption>".strtoupper($tableName)." TABLE - QUERY RESULT</caption>";
	echo '<tr>';
	foreach($titlesResultSet as $fieldName) {
		echo '<th>'.$fieldName['Field'].'</th>';
	}
	echo '<th>DELETE</th>';
	echo '<th>EDIT</th>';
	echo '</tr>';

	//then show the data
	foreach($dataResultSet as $row) {
		echo '<tr>';
		foreach($titlesResultSet as $fieldName) {
			echo '<td>'.$row[$fieldName['Field']].'</td>';}
		echo '<td>';
		//set the button values and display the button ton the form:
		$id=$row[$primaryKey];  //get the current PK value
		$buttonText="Delete";
		include 'FORMS/buttonWithText2.html';
		echo '</td>';
		echo '<td>';
		//set the button values and display the button ton the form:
		$id=$row[$primaryKey];  //get the current PK value
		$buttonText="Edit";
		include 'FORMS/buttonWithText3.html';
		echo '</td>';
		echo '</tr>';
		}
	echo "</table>";
}

function sendToEditPlayerForm($Username, $Password, $FirstName, $LastName, $DOB, $Height, $Weight, $email, $phone, $image)
{
		include 'FORMS/editGAAUserForm.html';
		
}

function generateplayerbuttons($tableName, $primaryKey, $titlesResultSet, $dataResultSet)
{
		foreach($dataResultSet as $row) {
			$name = $row['First_Name']. ' ' .$row['Last_Name'];
			$id=$row[$primaryKey];  //get the current PK value
			$buttonText=$name;
			include 'FORMS/playerprofilesbutton.html';
	}
}


/*function attendenceplayerbuttons($tableName, $primaryKey, $titlesResultSet, $dataResultSet)
{
		foreach($dataResultSet as $row) {
			$name = $row['First_Name']. ' ' .$row['Last_Name'];
			$id=$row[$primaryKey];  //get the current PK value
			$buttonText=$name;
			include 'FORMS/attendenceprofilesbutton.html';
	}
}*/

function attendenceplayerbuttons($tableName, $primaryKey, $datatrainingarray, $datauserarray)
{

		foreach($datauserarray as $row) {
			$name = $row['First_Name']. ' ' .$row['Last_Name'];
			$id=$row['User_ID'];  //get the current PK value
			$buttonText=$name;
			foreach($datatrainingarray as $row2) {
				$userid = $row2['Users_User_ID'];
				$attended = $row2['Attended'];
				if ($id = $userid) {
					if ($attended = 1){
						$checked = "Yes";
					}
					else {
						$checked = "No";
					}
				}
				else {
					$checked = "Yes";
				}
			}
			include 'FORMS/attendenceprofilesbutton.html';
		}
}

function sendToEditInjuryForm($Username, $Password, $FirstName, $LastName, $DOB, $Height, $Weight, $email, $phone)
{
		include 'FORMS/editInjuryForm.html';
		
}

function generateInjurybuttons($tableName, $primaryKey, $titlesResultSet, $dataResultSet)
{
		foreach($dataResultSet as $row) {
			$name = $row['Injury_ID']. ' ' .$row['Users_User_ID']. ' ' .$row['Injury_Types_Injury_Types_ID'];
			$id=$row[$primaryKey];  //get the current PK value
			$buttonText=$name;
			include 'FORMS/buttonWithText3.html';
	}
}

function sendToDisplayPlayerForm($Username, $Password, $FirstName, $LastName, $DOB, $Height, $Weight, $email, $phone, $image)
{
		include 'FORMS/displayGAAUserForm.html';
		
}

function sendToEditTeamForm($Teamname)
{
		include 'FORMS/EditGAAPlayerTeamForm.html';
		
}

function randomPassword() {
    $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
    $pass = array(); //remember to declare $pass as an array
    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
    for ($i = 0; $i < 8; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
    }
    return implode($pass); //turn the array into a string
}


function smtpmailer($to, $from, $from_name, $subject, $body, $is_gmail = true) 
{

	global $error;
	require 'PHPMailerAutoload.php';
	$mail = new PHPMailer();

	$mail->IsSMTP();
	$mail->SMTPAuth = true; 
	if ($is_gmail) {
		$mail->SMTPSecure = 'ssl'; 
		$mail->Host = 'smtp.gmail.com';
		$mail->Port = 465;  
		$mail->Username = GUSER;  
		$mail->Password = GPWD;   
	} else {
		$mail->Host = SMTPSERVER;
		$mail->Username = SMTPUSER;  
		$mail->Password = SMTPPWD;
	}        
	$mail->SetFrom($from, $from_name);
	$mail->Subject = $subject;
	$mail->Body = $body;
	$mail->AddAddress($to);
	if(!$mail->Send()) {
		$error = 'Mail error: '.$mail->ErrorInfo;
		return false;
	} else {
		$error = 'Message sent!';
		return true;
	}
}





?>