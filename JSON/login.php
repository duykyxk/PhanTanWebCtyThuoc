<?php
// required headers
file_put_contents("datastorage.txt", "da truy cap", FILE_APPEND);


// files needed to connect to database
include_once 'database.php';
include_once '../objects/user.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// instantiate user object
$user = new User($db);
 
// check email existence here
// get posted data
$raw = file_get_contents("php://input");
file_put_contents("datastorage.txt", $raw, FILE_APPEND);
$data = json_decode($raw);
 file_put_contents("datastorage.txt", $data, FILE_APPEND);
// set product property values
 $json;
$user->email = $data->email;
$email_exists = $user->emailExists();
file_put_contents("datastorage.txt", $data->email, FILE_APPEND);
file_put_contents("datastorage.txt", $data->password, FILE_APPEND);
 
// files for jwt will be here
// generate json web token
include_once 'core.php';
include_once '../libs/php-jwt-master/src/BeforeValidException.php';
include_once '../libs/php-jwt-master/src/ExpiredException.php';
include_once '../libs/php-jwt-master/src/SignatureInvalidException.php';
include_once '../libs/php-jwt-master/src/JWT.php';
use \Firebase\JWT\JWT;
 
// generate jwt will be here
// check if email exists and if password is correct
$a = password_verify($data->password, $user->password);
if($email_exists && password_verify($data->password, $user->password)){
 
    $token = array(
       "iss" => $iss,
       "aud" => $aud,
       "iat" => $iat,
       "nbf" => $nbf,
       "data" => array(
           "id" => $user->id,
           "name" => $user->name,
           "phone" => $user->phone,
           "email" => $user->email,
           "roleId" => $user->roleId,
           "address" => $user->address,
           "gender" => $user->gender,
       )
    );
 
    // set response code
    http_response_code(200);
 
    // generate jwt
    $jwt = JWT::encode($token, $key);
    $fileStatus=file_put_contents("datastorage.txt",$jwt,FILE_APPEND);
    // $datasend->message= "Login sucscess";
    // $datasend = new \stdClass();
    // $datasend->token=$jwt;
    
    // $json1 = array("loginResponse"=>$datasend);
    //   echo json_encode($json1,JSON_UNESCAPED_SLASHES);
    echo json_encode( array('token' =>$jwt ));
    // echo ("Thanh cong");
}
 
// login failed will be here
// login failed
else{
 
    // set response code
    http_response_code(401);
 
     // $datasend->message= "Login failed";
    // $datasend->token =   null;// tell the user login failed
   echo json_encode( array('token' =>null ));
}
?>