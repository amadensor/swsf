<?php
require_once ('utilities.php');

if (is_array($_POST) && array_key_exists('service_name',$_POST))
{
	var_dump($_POST);
	print "<br><br><br>";
	if ($_POST['action']=='add')
	{
		print "add";
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
		print "delete";
		$service_name=urlencode($_POST['service_name']);
		$req['service']='service';
		$req['action']='delete';
		$req['service_name']=$service_name;
		call_handler($req);
	}
	elseif ($_POST['action']=='update')
	{
		print "update";
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
$services=call_handler($req);print "Get form data";
include('views/services_form.php');
?>
