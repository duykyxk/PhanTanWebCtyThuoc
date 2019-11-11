<?php
include 'config.php';

$locationFile = $_POST['locationFile'];
$id = $_POST['id'];
$uid =$_POST['uid'];
$locationFile= "../Location/".$locationFile;
$sql="UPDATE `user_event` SET `locationFile`='".$locationFile."' WHERE `groupEventid` =".$id." and `uid`=".$uid." ";
if($check= mysqli_query($conn, $sql)){
	echo json_encode(array('message' => "update success" ));
}

?>