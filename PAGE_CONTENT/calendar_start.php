<?php
date_default_timezone_set('UTC');

$showmonth = $_POST['showmonth'];
$showyear = $_POST['showyear'];
$showmonth = preg_replace('#[^0-9]#i', '', $showmonth);
$showyear = preg_replace('#[^0-9]#i', '', $showyear);

//echo $_POST['showmonth'] . ' = ' . $showmonth . ' = ' . intval($showmonth);
$day_count = cal_days_in_month(CAL_GREGORIAN, $showmonth, $showyear);
$pre_days = date('w', mktime(0,0,0, $showmonth, 1, $showyear));
$post_days = (6 - (date('w', mktime(0,0,0, $showmonth, $day_count, $showyear))));

echo '<div class="calendar_wrap">';
echo '<div class="title_bar">';
echo '<div class="previous_month"><input name="myBtn" type="submit" value="Previous Month" onClick="javascript:last_month();"></div>';
echo '<div class="show_month">' . $showmonth . '/' . $showyear . '</div>';
echo '<div class="next_month"><input name="myBtn2" type="submit" value="Next Month" onClick="javascript:next_month();"></div>';
echo '</div><br>';

echo '<div class="week_days">';
echo '<div class="days_of_the_week">Sun</div>';
echo '<div class="days_of_the_week">Mon</div>';
echo '<div class="days_of_the_week">Tue</div>';
echo '<div class="days_of_the_week">Wed</div>';
echo '<div class="days_of_the_week">Thur</div>';
echo '<div class="days_of_the_week">Fri</div>';
echo '<div class="days_of_the_week">Sat</div>';
echo '</div>';

//previous Month filler days
if ($pre_days != 0){
	for ($i=1; $i<=$pre_days; $i++){
		echo '<div class="non_cal_day"></div>';
	}
}
//current month
//connect to mysql
//include ("CONFIG/connection.php")
//
	for ($i=1; $i<=$day_count; $i++){
		//get events logic
		//$date = $i.'/'.$showmonth.'/'.$showyear;
		//$query = "Select Match_ID FROM match WHERE Date = '$date'";
		//$num_rows = 0;
			//if($result = mysql_query($query)) {
    		//	$num_rows = mysql_num_rows($result);
			//}
    		//if($num_rows > 0) {
        	//	$event = "<input name='$date' type='submit' value='Details' id='$date'
			//	onClick='javascript:show_details(this);'>";
    		//}
    		//get events
		echo '<div class="cal_day">';
		echo '<div class="day_heading">' . $i . '</div>';
		//show events button
			//if($num_rows != 0) { echo "<div class='openings'><br/>" . $event . "</div>";}
		echo '</div>';
	}

//next month filler days
if ($post_days != 0){
	for ($i=1; $i<=$post_days; $i++){
		echo '<div class="non_cal_day"></div>';
	}
}
echo '</div>';

?>