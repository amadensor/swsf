<?php
require_once ('client_utilities.php');

if (is_array($_POST) && array_key_exists('action_name',$_POST))
{
	if ($_POST['action']=='add')
	{
		$action_name=urlencode($_POST['action_name']);
		$description=urlencode($_POST['description']);
		$req['service']='action';
		$req['action']='add';
		$req['action_name']=$action_name;
		$req['description']=$description;
		call_handler($req);
	}
	elseif ($_POST['action']=='delete')
	{
		$action_name=urlencode($_POST['action_name']);
		$req['service']='action';
		$req['action']='delete';
		$req['action_name']=$action_name;
		call_handler($req);
	}
	elseif ($_POST['action']=='update')
	{
		$action_name=urlencode($_POST['action_name']);
		$description=urlencode($_POST['description']);
		$req['service']='action';
		$req['action']='update';
		$req['action_name']=$action_name;
		$req['description']=$description;
		call_handler($req);
	}
}
$req['service']='action';
$req['action']='list';
$actions=call_handler($req);
include('views/actions_form.php');
?>
