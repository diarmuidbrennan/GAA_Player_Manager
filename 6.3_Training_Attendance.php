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
            <link href="CSS/bootstrap.css" rel="stylesheet">
            <link href="CSS/bootstrap-switch.css" rel="stylesheet">
            <script src="JS/jquery.js"></script>
            <script src="JS/bootstrap-switch.js"></script>


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
                                <h1><?php echo $selectedTeamName; ?> Training Attendence</h1>
                        </div><br>
                </div>
        </div>


<!------------------MAIN SECTION------------------------------>
<!--========================================================-->

                                    <?php
                                        $table='training_attendence';  //table to delete records from
                                        
                                        
                                        if(isset($_POST['SAVE']))  {//if the form has been submitted
                                            $selectedID=$_SESSION['primarykey']; 
                                            
                                            foreach($arrayUserData as $row) {
                                                $id=$row['User_ID'];  //get the current PK value
                                            }
                                            for ($i=1; $i<=26; $i++) {
                                                $user = ($_POST['player'.$i]);
                                                $position = $i;
                                                if ($user != 'default'){
                                                    //$sqlInsert="CALL gaaplayermanager2. sixTrainindUpdateAttendence ($userid, $trainingid, $attendedvalue)";

                                                    $sqlInsert= "INSERT INTO training_attendence (Users_User_ID, Training_Training_ID, Attended) VALUES('$matchID', '$position', '$user');";
                                
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

                                        if(isset($_POST['CANCEL'])) {//execute the save button
                                            echo "<script> window.location.assign('7_Games.php'); </script>";
                                        }
                                        else {//this is the first time the form is loaded
                                    ?>

        <div id="indexpage_box_container">
            <div class="row">
                <div class="col-xs-12 col-md-12">
                    <h2 class="attendence_header">Training Attendence Date</h2>
                    <form  class="" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
                    <div class="trainingattendence">
                        <?php
                            $trainingID=$_SESSION["primarykey"];
                            //$sqlUserData="CALL gaaplayermanager2.fourProfilesuserbuttonsplayer($selectedTeamID)";
                            $sqlUserData="SELECT * FROM users WHERE User_Type >2 AND Enabled >0 AND Team = $selectedTeamID";
                            //$sqlTrainingData="CALL gaaplayermanager2. sixTrainingGetTraining ($trainingID)";
                            $sqlTrainingData="SELECT * FROM training_attendence WHERE Training_Training_ID = $trainingID;";
                            $rsUserData=getTableData($conn,$sqlUserData);
                            $rsTrainingData=getTableData($conn,$sqlTrainingData);
                            $arrayUserData=checkResultSet($rsUserData);
                            $arrayTrainingData=checkResultSet($rsTrainingData);
                            $PK = null;
                            //attendenceplayerbuttons($table, $PK, $arrayTrainingData, $arrayUserData);

                            $counter = 1;
                        foreach($arrayUserData as $row) {
                            $name = $row['First_Name']. ' ' .$row['Last_Name'];
                            $id=$row['User_ID'];  //get the current PK value
                            $buttonText=$name;
                            $showrecord = "showrecord".$counter;
                            foreach($arrayTrainingData as $row2) {
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
                            ?>
                            <br>
                            <button class="attendenceprofilebutton"  name="<?php echo "$showrecord" ; ?>" type="submit" value="<?php echo $id;?>"><?php echo $buttonText; ?></button>
                            <input  class="attendenceprofileswitch" type="checkbox" name="my-checkbox" value=" .$checked . " checked data-toggle="toggle" data-on="Yes" data-off="No" >
                            <!--Notes-->
                            <input class="trainingattendencenote" name="Notes" placeholder="Note" type="text" id="myText" pattern="[a-zA-Z0-9óáéí'- ]{1,200}" value=""/>
                            <?php
                            $counter = $counter+1;
                            }
                            ?>


















                        ?>
                        <br><br><button class="playerprofilemenubutton" name="SAVE" type="submit" value="<?php echo $id;?>">Save</button>
                        <button class="playerprofilemenubutton" name="CANCEL" type="submit" value="">Cancel</button>
                    </div>
                    </form>
                    <?php }//closes the else bracket ?>
                </div>
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
</div><!--end of container-->
            <script>
                $(document).ready(function() {
                    $("[name='my-checkbox']").bootstrapSwitch();
                    $("[name='box2']").bootstrapSwitch();
                });
            </script>
</body>
</html>