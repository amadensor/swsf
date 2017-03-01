<?php

//Maintain what actions a role is allowed to execute.

require_once 'utilities.php';

if (array_key_exists('upd_action',$_POST))
{
  print"Update";
  var_dump($_POST);
  print"<br><br><br>";
  $actions=$_POST['upd_action'];
  $services=$_POST['upd_service_name'];
  $i=0;
  $count=count($actions);
  print "Items: $count";
  for($i=0;$i<$count;$i++) {
    print"<br>$services[$i]:$actions[$i]<br>/n";
    $update_request[]=array(
    'upd_action'=>$actions[$i],
    'upd_service_name'=>$services[$i]
    );
  	
  }
  $update_request['upd_role']=$_POST['upd_role'];
  $update_request['service']='role_action';
  $update_request['action']='update';
  print "\n\n<br><br><br>\n";
  print json_encode($update_request);
  $update_result=call_handler($update_request);
  var_dump($update_result);
}
elseif (array_key_exists('role',$_POST))
{
  $role=$_POST["role"];
  if ($_POST["search"]=='y')
  {
    $req["service"]="role_action";
    $req["action"]="get";
    $req["role"]=$_POST["role"];
    $roles=call_handler($req);
    //var_dump($roles);
//    print "Role: ".$roles['role'];
include ('views/role_actions_form.php');    
  }
}
else
{
  $req["service"]="role_action";
  $req["action"]="list";
  $roles=call_handler($req);
include ('views/role_actions_choose.php');

  
  ?>
  <?php
}
?>

