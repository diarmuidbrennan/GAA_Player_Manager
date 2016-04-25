<?php
//helper functions for database interaction

function queryInsert($connection,$sql)
{
	try {
		if ($connection->query($sql)===TRUE)  //execute the insert sql
		{
		return 1;  //if successful
		}
		else
		{
		return 0;  //if not successful
		}
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

function updateRecord($connection,$sql)  
{
	try {
		if ($connection->query($sql)===TRUE) 
		{
		return 1;  //if successful
		}
		else
		{
		return 0;  //if not successful
		}
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

function deleteRecord($connection,$sql)  //identical to above so we dont really need it
{
	try {
		if ($connection->query($sql)===TRUE)  //execute the sql
		{
		return 1;  //if successful
		}
		else
		{
		return 0;  //if not successful
		}
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



function query($connection,$sql)
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

?>