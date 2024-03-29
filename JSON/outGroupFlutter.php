
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
$body = $_POST['body'];
$data = json_decode($body);
$groupId = $_POST['groupId'];
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
		
		$query="DELETE FROM `group_user` where groupId='".$groupId."' and uid=".$uid." ";
		file_put_contents("date,txt", $query);
		$result=mysqli_query($conn,$query);
		$check= "SELECT `id` from `group_event` where `groupId`=".$groupId."";
		$qr= mysqli_query($conn, $check);
		while ($r = mysqli_fetch_array($qr)){
			$grevid = $r['id'];
			$query="DELETE FROM `user_event` where groupEventId='".$grevid."' and `uid`=".$uid."";
			file_put_contents("date,txt", $query, FILE_APPEND);
			$result=mysqli_query($conn,$query) or die("not Deleted". mysql_error());
		}


		echo json_encode( array('message' => "Success" ));
		
	}

    // if decode fails, it means jwt is invalid
	catch (Exception $e){

    // set response code
		http_response_code(401);

    // tell the user access denied  & show error message
		echo json_encode(array(
			"message" => "Fail",
			
		));
	}
}
// error if jwt is empty will be here
// show error message if jwt is empty
else{
    // set response code
	http_response_code(401);
    // tell the user access denied
	echo json_encode(array("message" => "Fail"));
}
?>