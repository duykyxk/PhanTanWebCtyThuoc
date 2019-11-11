<?php 
include "config.php";
$eventId = $_POST['eventId'];

$sql = "SELECT `user_event`.`locationFile`, `user`.`name` from `user`, `user_event` where `user`.`id` = `user_event`.`uid` and `user_event`.`groupEventId`=".$eventId."";
file_put_contents("date.txt", $sql);
$check = mysqli_query($conn, $sql);
while ($r=mysqli_fetch_array($check)) {
	$name = $r['name'];
	$locationFile = $r['locationFile'];
	if(strlen($locationFile) > 1){
		$pieces;
		$eventLocation;
		$file_lines = file("$locationFile");
		foreach ($file_lines as $line) {
    // echo $line;
			$pieces = explode(",", $line);
			$pieces[2] = str_replace("\r\n", "", $pieces[2]);
		
		}

		$eventLocation[] =array('name' => $name,'longitude'=>$pieces[0], 'latitude'=> $pieces[1] );
	}
	

}

echo json_encode(array('eventUpdate' => $eventLocation ));
?>