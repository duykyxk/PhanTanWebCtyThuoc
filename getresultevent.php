<?php
require_once("config.php");
require_once("pagination.class.php");
$db_handle = new DBController();
$perPage = new PerPage();

$groupId=$_GET['group'];

$userId=$_GET['user'];


if($groupId!=" "){
  $sql = "SELECT * from `group_event` where `groupId`='".$groupId."'";

}else $sql = "SELECT * from `group_event`";



if($userId!=" "){
 $sql= "SELECT * FROM `user_event`, `group_event` where `user_event`.`uid`=".$userId." and `user_event`.`groupEventId`= `group_event`.`id` " ;
}else $sql = "SELECT * from `group_event`";


$paginationlink = "getresultevent.php?page=";	
$pagination_setting = $_GET["pagination_setting"];

$page = 1;
if(!empty($_GET["page"])) {
  $page = $_GET["page"];
}

$start = ($page-1)*$perPage->perpage;
if($start < 0) $start = 0;

$query =  $sql . " limit " . $start . "," . $perPage->perpage; 
$faq = $db_handle->runQuery($query);

if(empty($_GET["rowcount"])) {
  $_GET["rowcount"] = $db_handle->numRows($sql);
}

if($pagination_setting == "prev-next") {
	$perpageresult = $perPage->getPrevNext($_GET["rowcount"], $paginationlink,$pagination_setting);	
} else {
	$perpageresult = $perPage->getAllPageLinks($_GET["rowcount"], $paginationlink,$pagination_setting);	
}

$output = '';

?>


<script language="JavaScript" type="text/javascript">
  function checkDelete(){
    return confirm('Are you sure you want to delete?');
  }
</script>



<style>
  .link {padding: 10px 15px;background: transparent;border:#bccfd8 1px solid;border-left:0px;cursor:pointer;color:#607d8b}
  .disabled {cursor:not-allowed;color: #bccfd8;}
  .current {background: #bccfd8;}
  .first{border-left:#bccfd8 1px solid;}
  .question {font-weight:bold;}
  .answer{padding-top: 10px;}
  #pagination{margin-top: 20px;padding-top: 30px;border-top: #F0F0F0 1px solid;}
  .dot {padding: 10px 15px;background: transparent;border-right: #bccfd8 1px solid;}
  #overlay {background-color: rgba(0, 0, 0, 0.6);z-index: 999;position: absolute;left: 0;top: 0;width: 100%;height: 100%;display: none;}
  #overlay div {position:absolute;left:50%;top:50%;margin-top:-32px;margin-left:-32px;}
  .page-content {padding: 20px;margin: 0 auto;}
  .pagination-setting {padding:10px; margin:5px 0px 10px;border:#bccfd8  1px solid;color:#607d8b;}

</style>

<div class="box">
  <div class="box-header">
    <h3 class="box-title"><i class="fa fa-list-ol fa-5" aria-hidden="true"></i>All Event</h3>

    <div class="box-tools">
      
      <div class="input-group input-group-sm" style="width: 150px;">
       <input type="text" id="myInput" onkeyup="myFunction()" placeholder="Search here...." title="Type a name ">
 

       <div class="input-group-btn">
        
       </div>
       
     </div>
     
   </div>
 </div>


 <!-- /.box-header -->

 <div class="box-body table-responsive no-padding">
  <table class="table table-hover" id="myTable">
    <tbody><tr>
      
      <th>Name</th>
      <th>Group</th>
      <th>Place</th>
      <th>Description</th>
      <th>Start time</th>
      <th>End time</th>
      <th>Member</th>
      <th>Add Member</th>
      <th style="width: 40px">Action</th>
    </tr>
    <?php if (is_array($faq) || is_object($faq))
    {foreach($faq as $k=>$v) { 
      
        $sql = "SELECT name from `group` where id = '".$faq[$k]['groupId']."'";
        $getname = mysqli_query($conn, $sql);
        if($tr=mysqli_fetch_array($getname)){
          $namegroup = $tr[0];
        }

        $sql = "SELECT name from `place` where id = '".$faq[$k]['placeID']."'";
        $getname = mysqli_query($conn, $sql);
        if($tr=mysqli_fetch_array($getname)){
          $nameplace = $tr[0];
        }
      
       $sql1 = "SELECT count(`uid`) from `user_event` where `groupEventId`= '".$faq[$k]['id']."'";
       $check11= mysqli_query($conn, $sql1);
       if($rr= mysqli_fetch_array($check11)){
        $count = $rr[0];
      }
        
      ?>
      <tr>
        

       <td><?php echo $faq[$k]['name'];?></td>
       <td><?php echo $namegroup;?></td>
       <td><?php echo $nameplace;?></td>
       <td><?php echo  $faq[$k]['description'];?></td>
       <td><?php echo $faq[$k]['stime'];?></td>
       <td><?php echo  $faq[$k]['etime'];?></td>
        <td><?php echo $count;?></td>
         <td><a href="addMemberEvent.php?id=<?php echo base64_encode($faq[$k]['id']);?>"><button class=" btn btn-primary " >ADD<i class="fa fa-pencil" aria-hidden="true"></i></button></a>
       <td><a href="editevent.php?id=<?php echo base64_encode($faq[$k]['id']);?>"><button class=" btn btn-primary btn-warning" >Edit<i class="fa fa-pencil" aria-hidden="true"></i></button></a>
        <td><a href="deleteevent.php?id=<?php echo base64_encode($faq[$k]['id']);?>" class="btn btn-social-icon btn-google" onClick="return checkDelete()" ><i class="fa fa fa-trash-o"></i></a>
        <?php  } }else { echo '<center><h2><br> No result to display. Please add category.</h2></center>'; }?>
      </tr>
    </tbody></table>





    <script>
      function myFunction() {
        var input, filter, table, tr, td, i;
        input = document.getElementById("myInput");
        filter = input.value.toUpperCase();
        table = document.getElementById("myTable");
        tr = table.getElementsByTagName("tr");
        for (i = 0; i < tr.length; i++) {
          td = tr[i].getElementsByTagName("td")[0];
          if (td) {
            if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
              tr[i].style.display = "";
            } else {
              tr[i].style.display = "none";
            }
          }       
        }
      }
   </script>


    <?php
    
    if(!empty($perpageresult)) {
      $output .= '<div id="pagination" class="pagination">' . $perpageresult . '</div>';
    }
    print $output;
    ?>
