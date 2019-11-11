
<?php
// required header
// files for decoding jwt will be here
// required to decode jwt
include_once '../JSON/core.php';
include_once '../Libs/php-jwt-master/src/BeforeValidException.php';
include_once '../Libs/php-jwt-master/src/ExpiredException.php';
include_once '../Libs/php-jwt-master/src/SignatureInvalidException.php';
include_once '../Libs/php-jwt-master/src/JWT.php';
use \Firebase\JWT\JWT;

// retrieve gieve jwt here
// get posted data
$data = json_decode(file_get_contents("php://input"));
// file_put_contents("date.txt", $data ,FILE_APPEND);
// file_put_contents("date.txt", $page ,FILE_APPEND);
// get jwt
$status = $_GET['status'];
$token=isset($data->token) ? $data->token : "";

// decode jwt here
// if jwt is not empty
if($token){
   // if decode succeed, show user details
	try {
        // decode jwt
		$decoded = JWT::decode($token, $key, array('HS256'));
		http_response_code(200);
		// if ( $decoded ->data->role == 0){

		include 'config.php';
		$uid =  $decoded ->data->id;
		$json ;
		$aplace;
		$jsonimage=null;
		$json1=null;
		if($status==0){
			$sql="SELECT `group_event`.`id`, `group_event`.`groupId`, `group_event`.`etime`, `group_event`.`placeID`, `group_event`.`stime`, `group_event`.`name`, `group_event`.`description`, `group_event`.`checkPlace` FROM `user_event`, `group_event`, `group` where `group`.`own`=".$uid." and `group`.`id`=`group_event`.`groupId` and`user_event`.`uid`=".$uid." and `user_event`.`groupEventId`= `group_event`.`id` ";
		}else
		$sql="SELECT `group_event`.`id`, `group_event`.`groupId`, `group_event`.`etime`, `group_event`.`placeID`, `group_event`.`stime`, `group_event`.`name`, `group_event`.`description`, `group_event`.`checkPlace` FROM `user_event`, `group_event` where `user_event`.`uid`=".$uid." and `user_event`.`groupEventId`= `group_event`.`id` and `user_event`.`status`=".$status." ";
		$cs = file_put_contents("date.txt", $sql, FILE_APPEND);
		$check= mysqli_query($conn, $sql);
		while ($row = mysqli_fetch_array($check,MYSQLI_ASSOC)) {
				// $jsonimage[] =array(); 
			$aplace=null;
			$id = $row['id'];
			$groupId = $row['groupId'];
			$placeID = $row['placeID'];
			$name = $row['name'];
			$description = $row['description'];
			$stime=$row['stime'];
			$etime=$row['etime'];
			$checkPlace=$row['checkPlace'];
			file_put_contents("date.txt", $checkPlace, FILE_APPEND);
			$sql1= "SELECT name from `group` where `id`=".$groupId."";

			$check1=mysqli_query($conn, $sql1);
			if ($row1=mysqli_fetch_array($check1))
				$groupName= $row1['name'];

			if($checkPlace==0){
				$sql2="SELECT * FROM `place` WHERE id ='".$placeID."'";
			} else 	$sql2="SELECT * FROM `uplace` WHERE id ='".$placeID."'";


			
				$cs = file_put_contents("date.txt", $sql2, FILE_APPEND);
			$check2= mysqli_query($conn, $sql2);
			
			if($result=mysqli_fetch_array($check2,MYSQLI_ASSOC))
			{
				$aplace []= $result;
			}

			$json1 []= array("id" => $id,"name"=>$name,"description"=>$description, "stime"=>$stime,"etime"=>$etime,"groupName"=>$groupName, "aplace"=>$aplace);
				// $cs = file_put_contents("date.txt", json_encode($aplace,JSON_UNESCAPED_SLASHES));
			unset($aplace);

				// $json1 []= array("id" => $id,"areaId"=>$areaId,"longitude"=>$longitude, "latitude"=>$latitude,"name"=>$name,"description"=>$description, "imageList"=>$jsonimage);
		}
		// $cs = file_put_contents("date.txt", $json, FILE_APPEND);
		$json2 = array("events"=>$json1);

		echo json_encode($json2,JSON_UNESCAPED_SLASHES);
		$cs = file_put_contents("date.txt",json_encode($json2,JSON_UNESCAPED_SLASHES), FILE_APPEND);
		// }
		// else {
		// 	$cat1id = $decoded ->data->cat1id;
		// 	include 'config.php';
		// 	$json =null ;
		// 	$sql="SELECT * FROM `item` where cat1id = '".$cat1id."' ORDER BY stime DESC, -etime Limit ".$offset.", ".$pageSize." ";
		// 	$check= mysqli_query($conn, $sql);
		// 	while ($row = mysqli_fetch_array($check,MYSQLI_ASSOC)) {
		// 		$json []= $row;

		// 	}

		// 	$json1 = array("items"=>$json);
		// 	echo json_encode($json1,JSON_UNESCAPED_SLASHES);
		// }
		

	}

    // if decode fails, it means jwt is invalid
	catch (Exception $e){

    // set response code
		http_response_code(401);

    // tell the user access denied  & show error message
		echo json_encode(array(
			"events" => "Access denied.",
			
		));
	}
}
// error if jwt is empty will be here
// show error message if jwt is empty
else{
    // set response code
	http_response_code(401);
    // tell the user access denied
	echo json_encode(array("events" => "Access denied."));
}
?>