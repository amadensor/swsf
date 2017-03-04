<?php
require_once ('utilities.php');

if (is_array($_POST) && array_key_exists('role_name',$_POST))
{
	var_dump($_POST);
	print "<br><br><br>";
	if ($_POST['action']=='add')
	{
		print "add";
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
		print "delete";
		$role_name=urlencode($_POST['role_name']);
		$req['service']='role';
		$req['action']='delete';
		$req['role_name']=$role_name;
		call_handler($req);
	}
	elseif ($_POST['action']=='update')
	{
		print "update";
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
$roles=call_handler($req);print "Get form data";
include('views/roles_form.php');
?>
