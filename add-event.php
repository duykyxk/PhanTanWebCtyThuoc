<html>
<head> <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script></head>
<body>
  <?php 
  include 'config.php';
  if(isset($_POST['addevent']))
  {
//echo 'button pressed';
    $ok=0;
    $name = $_POST['eventname'];
    $time = $_POST['time'];
    echo "$time";
///////////////////////////////////////////////////
    $sql="SELECT * FROM `group_event` ";
         // var_dump($sql);
    $check= mysqli_query($conn, $sql);
    $resultcheck= mysqli_fetch_array($check,MYSQLI_BOTH);
         // $catname=$resultcheck['category_name'];


    foreach($check as $checkevent){
      if($checkevent['name']==$name)
      {
        $ok=1;
      }else{
        $ok=0;
      }
    }

    if($ok==1){?>
     <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
     <script type="text/javascript">
      swal({
        title: "Event đã tồn tại ",
        text: "Hãy chọn một tên khác",
        icon: "error",button: "close"
      }).then(function() {
// Redirect the user
window.location.href = "event.php";
//console.log('The Ok Button was clicked.');
});
</script>
<?php 
}else{          

  $group= $_POST['groupId'];
  $sql= "select id from `group` where name='".$group."'";
  $checkgr= mysqli_query($conn, $sql);
  if($r =  mysqli_fetch_array($checkgr))
    $groupId= $r['0'];
  $place= $_POST['placeId'];
  $sql= "select id from `place` where name='".$place."'";
  echo $sql;
  $checkpl= mysqli_query($conn, $sql);
  if($r =  mysqli_fetch_array($checkpl))
    $placeId= $r['0'];
  $des= $_POST['eventdes'];
$a = explode('-', $time);
$stime= $a[0];
$etime= $a[1];
echo "INSERT INTO `group_event`(`groupId`, `placeID`, `name`, `description`, `stime`, `etime`, `checkPlace`) VALUES ('".$groupId."','".$placeId."','".$name."','".$des."','".$stime."','".$etime."')";
  $event_insert = mysqli_query($conn,"INSERT INTO `group_event`(`groupId`, `placeID`, `name`, `description`, `stime`, `etime`) VALUES ('".$groupId."','".$placeId."','".$name."','".$des."','".$stime."','".$etime."')");
  ?>

  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
  <script type="text/javascript">
    swal({
      title: "Event Added ",
      text: "Successfully",
      icon: "success",button: "close"
    }).then(function() {
// Redirect the user
window.location.href = "event.php";
//console.log('The Ok Button was clicked.');
});
</script>
<?php


}


}

else {

  header("location:dashboard.php"); }
