a<?php

include "config.php";
include "sendToASub.php";
include "sendToASubFlutter.php";

$eventId = $_POST['eventId'];
$uid = $_POST['uid'];

$stime=date('Y/m/d H:i:s');
$sql = "INSERT INTO `user_event`(`groupEventId`, `uid`,`status`) VALUES ('".$eventId."','".$uid."',1)";
file_put_contents("date.txt", $sql);
$check=mysqli_query($conn, $sql);
if($check){
	echo json_encode(array("message" => "success"));
	//send notify
	$name;
	$re= mysqli_query($conn, "select `name` from `group_event` where `id` ='".$eventId."' ");
	if($r = mysqli_fetch_array($re)){
		$name = $r['name'];
	}
	$message = "Bạn đã được thêm vào event ".$name;
	$re1=mysqli_query($conn, "select `playerId` from `device` where `uid`=".$uid." and `status`=1");
	while ($r1 =mysqli_fetch_array($re1)) {
		$playerId = $r1['playerId'];
		sendMessage($message, $playerId);
		sendMessageFlutter($message, $playerId);
	}
}else echo json_encode(array("message" => "fail"));

?>