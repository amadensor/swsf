<?php

//Maintain what actions a role is allowed to execute.

require_once 'client_utilities.php';

if (is_array($_POST) && array_key_exists('upd_action',$_POST))
{
	if ($_POST['action']=='delete')
	{
		$req['service']='role_action';
		$req['action']='delete';
		$req['upd_role']=$_POST['role'];
		$req['upd_service_name']=$_POST['upd_service_name'];
		$req['upd_action']=$_POST['upd_action'];
		call_handler($req);
	}
	if ($_POST['action']=='add')
	{
		$req['service']='role_action';
		$req['action']='add';
		$req['upd_role']=$_POST['role'];
		$req['upd_service_name']=$_POST['upd_service_name'];
		$req['upd_action']=$_POST['upd_action'];
		call_handler($req);
	}
}

if (is_array($_POST) && array_key_exists('role',$_POST))
{
	$act_req['service']='action';
	$act_req['action']='list';
	$select_actions=call_handler($act_req);
	$ser_req['service']='service';
	$ser_req['action']='list';
	$select_services=call_handler($ser_req);
    $role=$_POST["role"];
    $req["service"]="role_action";
    $req["action"]="get";
    $req["role"]=$_POST["role"];
    $roles=call_handler($req);
    include ('views/role_actions_form.php');    
}
else
{
  $req["service"]="role";
  $req["action"]="list";
  $roles=call_handler($req);
  include ('views/role_actions_choose.php');
}
?>

