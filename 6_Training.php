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
                </div>
        </div><!--end of row-->

        <div class="row">
                <div class="col-xs-12 col-md-12">
                        <div id="navigation_option">
                                <h1><?php echo $selectedTeamName; ?> Training</h1>
                        </div><br>
                </div>
        </div>


<!------------------MAIN SECTION------------------------------>
<!--========================================================-->
        

            <?php
                $table='games';  //table to delete records from
                $PK="Game_ID";
                $Team="Team_ID";  //Specify the PK of the table
            ?>

        <div id="indexpage_box_container">
            <div class="row">
                <div class="col-xs-12 col-md-6">
                    <div id="linechart" style="height: 400px; margin: 0 auto">

                        <script src="JS/indexpageleftchart.js"></script>

                    </div>
                </div><!--end of col-->


                <div class="col-xs-12 col-md-6"><br>
                    <div class="indexpage_box" style="overflow:scroll">

                    <?php
                        //edit an existing match
                        if(isset($_POST['editrecord'])) { //if the form has been submitted  
                            //DELETE query
                            $selectedID=$_POST['editrecord'];  //get the ID of the record we want to edit from the form  
                            $_SESSION['primarykey'] = $selectedID;
                            echo "<script> window.location.assign('6.2_Training_Edit.php'); </script>";
                        }

                        
                        if(isset($_POST['Attendance'])) { //if the form has been submitted  
                            //DELETE query
                            $selectedID=$_POST['Attendance'];  //get the ID of the record we want to edit from the form  
                            $_SESSION['primarykey'] = $selectedID;
                            echo "<script> window.location.assign('6.3_Training_Attendance.php'); </script>";
                        }

                        else {
                            //$sqlDataTraining="CALL gaaplayermanager2.sixTrainingSelectTrainings($selectedTeamID)";
                            $sqlDataTraining="SELECT * FROM gaaplayermanager2.training AS t INNER JOIN gaaplayermanager2.training_type AS tt ON tt.Training_Type_ID = t.Training_Type_Training_Type_ID INNER JOIN gaaplayermanager2.season AS s ON s.Season_ID = t.Season_Season_ID WHERE t.Team=$selectedTeamID && t.Season_Season_ID=2 ORDER BY t.Training_Date DESC;";
                            $rsDataTraining=getTableData($conn,$sqlDataTraining);
                            $arrayDataTraining=checkResultSet($rsDataTraining);
                            $conn->close();
                            foreach($arrayDataTraining as $row) {
                                $training = $row['Training_Type']. ' - ' .$row['Training_Date'];
                                $id=$row['Training_ID'];  //get the current PK value
                                $buttonText=$training;
                                include 'FORMS/buttonWithText3edittraining.html'; }
                        }
                    ?>

                    </div>

                </div><br>
            </div><!--end of row-->

            <div class="row"><br>
                <div class="col-xs-12 col-md-6">
                </div>
                <div class="col-xs-12 col-md-6">
                    <a class="index_page_buttons" href="6.1_Training_Create.php" role="button">Create New Training Session</a>
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
















 



