<?php
require_once ('client_utilities.php');

if (is_array($_POST) && array_key_exists('service_name',$_POST))
{
	if ($_POST['action']=='add')
	{
		$service_name=urlencode($_POST['service_name']);
		$description=urlencode($_POST['description']);
		$req['service']='service';
		$req['action']='add';
		$req['service_name']=$service_name;
		$req['description']=$description;
		call_handler($req);
	}
	elseif ($_POST['action']=='delete')
	{
		$service_name=urlencode($_POST['service_name']);
		$req['service']='service';
		$req['action']='delete';
		$req['service_name']=$service_name;
		call_handler($req);
	}
	elseif ($_POST['action']=='update')
	{
		$service_name=urlencode($_POST['service_name']);
		$description=urlencode($_POST['description']);
		$req['service']='service';
		$req['action']='update';
		$req['service_name']=$service_name;
		$req['description']=$description;
		call_handler($req);
	}
}
$req['service']='service';
$req['action']='list';
$services=call_handler($req);
include('views/services_form.php');
?>
