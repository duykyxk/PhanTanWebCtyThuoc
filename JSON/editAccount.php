<?php
include "config.php";


$data = json_decode(file_get_contents("php://input"));
$id = $data->id;
$name = $data->name;
$phone =  $data->phone;
$address= $data->address;
$email = $data->email;

if (property_exists($data,"password")){
	$password = $data->password;
	if($password!=null){
	$password_hash = password_hash($password, PASSWORD_BCRYPT);
	$sql = "UPDATE `user` SET `password`='".$password_hash."',`name`='".$name."',`phone`='".$phone."',`address`='".$address."', `email`='".$email."' WHERE id='".$id."'";
	$cs = mysqli_query($conn,$sql);
	$cs = file_put_contents("date.txt", $sql, FILE_APPEND);
	echo json_encode(array("message" => "Data successfully uploaded") );
}
}else{

	$sql ="UPDATE `user` SET `name`='".$name."',`phone`='".$phone."',`address`='".$address."', `email`='".$email."' WHERE id='".$id."'";
	 $cs = mysqli_query($conn,$sql);
	 $cs = file_put_contents("date.txt", $sql, FILE_APPEND);
		echo json_encode(array("message" => "Data successfully uploaded") );
}
?>