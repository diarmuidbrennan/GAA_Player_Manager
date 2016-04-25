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
	<link rel="stylesheet" type="text/css" href="CSS/Style.css">
	<!--bootstrap-->
	<link href="CSS/bootstrap.min.css" rel="stylesheet" media="screen">
	<link href="CSS/calCss.css" rel="stylesheet" type="text/css" media="all">
		<!--<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.0/jquery.min.js"></script>-->
		<!--<script language="JavaScript" type="text/javascript" script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.0/jquery-ui.min.js"></script>-->
		<script language="JavaScript" type="text/javascript">

			function initialCalendar() {
        		var hr = new XMLHttpRequest();
        		var url = "PAGE_CONTENT/calendar_start.php";
        		var currentTime = new Date();
        		var month = currentTime.getMonth() + 1;
        		var year = currentTime.getFullYear();
        		showmonth = month;
        		showyear = year;
        		var vars = "showmonth="+showmonth+"&showyear="+showyear;
        		hr.open("POST", url, true);
        		hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        		hr.onreadystatechange = function() {
            		if(hr.readyState == 4 && hr.status == 200) {
                		var return_data = hr.responseText;
                		document.getElementById("showCalendar").innerHTML = return_data;
            		}
        		}
        		
        		document.getElementById("showCalendar").innerHTML = "processing..";
        		hr.send(vars);
    			}


    		function next_month(){
        		var nextmonth = showmonth + 1;
        		if(nextmonth > 12) {
            		nextmonth = 1;
            		showyear = showyear + 1;
        		}
        		showmonth = nextmonth;
        		var hr = new XMLHttpRequest();
        		var url = "PAGE_CONTENT/calendar_start.php";
        		var vars = "showmonth="+showmonth+"&showyear="+showyear;
        		hr.open("POST", url, true);
        		hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        		hr.onreadystatechange = function() {
            		if(hr.readyState == 4 && hr.status == 200) {
                	var return_data = hr.responseText;
                	document.getElementById("showCalendar").innerHTML = return_data;
            		}
        		}
        		
        		document.getElementById("showCalendar").innerHTML = "processing...";
        		hr.send(vars);
    			}


    		function last_month(){
        		var lastmonth = showmonth - 1;
        			if(lastmonth < 1) {
            			lastmonth = 1;
            			showyear = showyear - 1;
        			}
        		showmonth = lastmonth;
        		var hr = new XMLHttpRequest();
        		var url = "PAGE_CONTENT/calendar_start.php";
        		var vars = "showmonth="+showmonth+"&showyear="+showyear;
        		hr.open("POST", url, true);
        		hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        		hr.onreadystatechange = function() {
            		if(hr.readyState == 4 && hr.status == 200) {
                		var return_data = hr.responseText;
                		document.getElementById("showCalendar").innerHTML = return_data;
            		}
        		}
        		
        		document.getElementById("showCalendar").innerHTML = "processing...";
        		hr.send(vars);
    			}

    		/*function overlay() {
    			el = document.getElementById("overlay");
    			el.style.display = (el.style.display == "block") ? "none" : "block";
    			el. = document.getElementById("events");//problem Uncaught SyntaxError: Unexpected token =
    			el.style.display = (el.style.display == "block") ? "none" : "block";
    			el. = document.getElementById("eventsBody");
    			el.style.display = (el.style.display == "block") ? "none" : "block";
			}


			function show_details(theId) {
    			var deets = )theId.id);
    			el = document.getElementById("overlay");
    			el.style.display = (el.style.display == "block") ? "none" : "block";
    			el. = document.getElementById("events");
    			el.style.display = (el.style.display == "block") ? "none" : "block";
    			var hr = new XMLHttpRequest();
    			var url = "events.php";
    			var vars = "deets="+deets;
    			hr.open("POST", url, true);
    			hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    			hr.onreadystatechange= function() {
        		if (hr.readyState == 4 && hr.status == 200) {
            		var return_data = hr.responseText;
                	document.getElementById("events").innerHTML = return_data;
        			}
    			}
    			hr.send(vars);
    			document.get ElementById("events").innerHTML = "processing...";
				}*/
		</script>


</head>

<!----------------- HEADER SECTION ------------------------>
<!--====================================================-->

<body onLoad="initialCalendar();"><!--problem: Uncaught ReferenceError: initialCalendar is not defined-->
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
                <h1><?php echo $selectedTeamName; ?> Schedule</h1>
            </div><br>
        </div>
    </div>


<!--//----------------MAIN SECTION----------------------------//-->
<!--//========================================================//-->
    
        <div id="indexpage_box_container"><br>
            <div class="row">
                <div class="col-xs-12 col-md-12">
                    <div id="showCalendar">
                    </div>

                    <div id="overlay">
                        <div id="events">
                        </div>
                    </div>
                        <?php //include ("PAGE_CONTENT/calendar_start.php"); ?>
                </div>
            </div>

<!--//----------------FOOTER section--------------------------//-->
<!--//========================================================//-->
        
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
        </div><!--end of indexpage_box_container-->
</div><!--end of container-->

</body>
</html>
















 



