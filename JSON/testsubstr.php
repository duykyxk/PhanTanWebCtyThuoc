
<?php
include 'config.php';

// insert
// $stime=date('Y/m/d H:i:s');
		
		// $sql="update `group` set description='aaaa' where name = 'group 10'";
		// $check= mysqli_query($conn, $sql);
	// $sql="INSERT INTO `user_event`( `groupEventId`, `uid`,  `status`) VALUES (5,1,1)";
	// 	$check= mysqli_query($conn, $sql);


// $sql="UPDATE `user_event` SET `status`=5 WHERE `id`=3";
// 		$check= mysqli_query($conn, $sql);
		// $sql="INSERT INTO `group_event`(`groupId`, `placeID`, `name`, `description`, `stime`, `etime`) VALUES (3,6,'Cầu Long Biên','Chạy qua cầu ','2019/07/27 00:00:00','2019/07/31 00:00:00') ";
		// $check= mysqli_query($conn, $sql);
		// $sql="INSERT INTO `group_event`(`groupId`, `placeID`, `name`, `description`, `stime`, `etime`) VALUES (2,5,'Đại học Bách Khoa','Thăm thư viện','2019/07/27 00:00:00','2019/07/31 00:00:00') ";
		// $check= mysqli_query($conn, $sql);
	// request table
// echo "a";
		$sql="SELECT * FROM `group` ";
		echo ($sql);
		// $cs = file_put_contents("date.txt", $sql, FILE_APPEND);
		$check= mysqli_query($conn, $sql);
		while ($r=mysqli_fetch_array($check)) {
			echo $r['id'];
			echo "_______";
			echo $r['name'];
			echo "_______";
			echo $r['description'];
			echo "_______";
			// echo $r['email'];
			echo "_______";
		}







// if($check= mysqli_query($conn, $sql)){
// 	echo json_encode(array('message' => "update success" ));
// }


// $dt = "longitude,"."latitude,"."time"."\n";
// // $stime=date('Y/m/d H:i:s');

// $locationFile="../Maps/Location/1_1.txt";

// file_put_contents($locationFile,$dt, FILE_APPEND );
// echo json_encode(array('message' =>"success") );
// $pieces;
// $route;
// $file_lines = file('../Location/2_1.txt');
// foreach ($file_lines as $line) {
//     // echo $line;
//     $pieces = explode(",", $line);
//     $pieces[2] = str_replace("\r\n", "", $pieces[2]);
//     $route[]= array('longitude'=>$pieces[0], 'latitude'=>$pieces[1],'time'=>$pieces[2]);

// }
// $json= array('location' => $route );
// echo json_encode($json) ;
// echo file_get_contents("../Location/2_1.txt" );
?>


</body>
</html> 