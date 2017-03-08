<?php

require_once('client_utilities.php');

if (is_array($_POST))
{
	if(array_key_exists('action',$_POST))
	{
		$req['service']='service';
		$req['action']='list';
		$services=call_handler($req);
		$req['service']='action';
		$req['action']='list';
		$actions=call_handler($req);
		if ($_POST['action']=='add')
		{
			$req['service']='service_action';
			$req['action']='add';
			$req['service_name']=urlencode($_POST['service_name']);
			$req['action_name']=urlencode($_POST['action_name']);
			$req['function']=urlencode($_POST['function']);
			$service_actions=call_handler($req);
		}
		if ($_POST['action']=='update')
		{
			$req['service']='service_action';
			$req['action']='update';
			$req['service_name']=urlencode($_POST['service_name']);
			$req['action_name']=urlencode($_POST['action_name']);
			$req['function']=urlencode($_POST['function']);
			$service_actions=call_handler($req);
		}
		if ($_POST['action']=='delete')
		{
			$req['service']='service_action';
			$req['action']='delete';
			$req['service_name']=urlencode($_POST['service_name']);
			$req['action_name']=urlencode($_POST['action_name']);
			$service_actions=call_handler($req);
		}		
		//Always show the grid
		$req['service_name']=$_POST['service_name'];
		$req['service']='service_action';
		$req['action']='list';
		$service_actions=call_handler($req);
		include('views/service_actions_form.php');
	}
	else //No action
	{
		$req['service']='service';
		$req['action']='list';
		print "Show service list select";
		$services=call_handler($req);
		include('views/service_actions_choose.php');
	}
}

		
?>
