<?php
$deets = $_POST['deets'];
$deets = preg_replace('#[^0-9/]#i', '', $deets);

include ("connection.php");

$events = '';
$query = mysqli_query('SELECT * FROM match WHERE Season_Season_ID ="'.$deets.'"');
$num_rows= mysql_num_rows($query);
if ($num_rows > 0) {
    $events.= '<div id="eventsControl"><button onMouseDown="overlay()">Close</button><br /><b> ' . $deets . '</b><br /><br /></div>';

    while($row= mysql_fetch_array($query)) {
        $desc = $row['description'];
        $events .='<div id="eventsBody">'.$desc .'<br /><hr><br /></div>';
    }

}
echo $events;
?>