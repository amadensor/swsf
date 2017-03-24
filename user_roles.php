<?php

//Which users have which roles

require_once 'client_utilities.php';


if (is_array($_POST) && array_key_exists('action',$_POST) && $_POST['action']=='add')
{
	$req['service']='user_role';
	$req['action']='add';
	$user=urlencode($_POST['role_user']);
	$role=urlencode($_POST['role']);
	$req['role_user']=$user;
	$req['role']=$role;
	call_handler($req);
}

if (is_array($_POST) && array_key_exists('action',$_POST) && $_POST['action']=='delete')
{
	$req['service']='user_role';
	$req['action']='delete';
	$user=urlencode($_POST['role_user']);
	$role=urlencode($_POST['role']);
	$req['role_user']=$user;
	$req['role']=$role;
	call_handler($req);
}

//get roles
$req['service']='role';
$req['action']='list';
$roles=call_handler($req);

//get users
$req['service']='user';
$req['action']='list';
$users=call_handler($req);

if (is_array($_POST) && array_key_exists('list',$_POST) && $_POST['list']=='by_role')
{
	$role=urlencode($_POST['role']);
	$req['service']='user_role';
	$req['action']='list';
	$req['role']=$role;
	$user_roles=call_handler($req);
}

if (is_array($_POST) && array_key_exists('list',$_POST) && $_POST['list']=='by_user')
{
	$user=urlencode($_POST['role_user']);
	$req['service']='user_role';
	$req['action']='list';
	$req['role_user']=$user;
	$user_roles=call_handler($req);
}
include ('views/user_role_form.php');
?>
