<?php
include 'config.php';

$status = $_POST['status'];
// file_put_contents("date.txt", $status, FILE_APPEND);
$id = $_POST['id'];
// file_put_contents("date.txt", $id, FILE_APPEND);
$time = $_POST['time'];
// file_put_contents("date.txt", $time, FILE_APPEND);
$uid =$_POST['uid'];
if ($time!="0")
$sql="UPDATE `user_event` SET `status`=".$status.",`time`='".$time."' WHERE `groupEventId` =".$id." and `uid`=".$uid."";
else $sql="UPDATE `user_event` SET `status`=".$status." WHERE `groupEventId` =".$id." and  `uid`=".$uid." ";
file_put_contents("date.txt", $sql, FILE_APPEND);
if($check= mysqli_query($conn, $sql)){
	echo json_encode(array('message' => "update success" ));
}

?>