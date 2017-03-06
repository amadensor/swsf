<?php
require_once ('client_utilities.php');

if (is_array($_POST) && array_key_exists('role_name',$_POST))
{
	if ($_POST['action']=='add')
	{
		$role_name=urlencode($_POST['role_name']);
		$description=urlencode($_POST['description']);
		$req['service']='role';
		$req['action']='add';
		$req['role_name']=$role_name;
		$req['description']=$description;
		call_handler($req);
	}
	elseif ($_POST['action']=='delete')
	{
		$role_name=urlencode($_POST['role_name']);
		$req['service']='role';
		$req['action']='delete';
		$req['role_name']=$role_name;
		call_handler($req);
	}
	elseif ($_POST['action']=='update')
	{
		$role_name=urlencode($_POST['role_name']);
		$description=urlencode($_POST['description']);
		$req['service']='role';
		$req['action']='update';
		$req['role_name']=$role_name;
		$req['description']=$description;
		call_handler($req);
	}
}
$req['service']='role';
$req['action']='list';
$roles=call_handler($req);
include('views/roles_form.php');
?>
