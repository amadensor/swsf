<?php

//Very simple core handler.   Call function based on service and action in JSON, return JSON.

require 'db_connect.php';
require 'utilities.php';
require '../application.php';
$service_request=$_POST["service_request"];
$json_request=json_decode($service_request,TRUE);
if (
    is_array($json_request)
	and array_key_exists("user",$json_request)
	and array_key_exists("session_key",$json_request)
	and array_key_exists("service",$json_request)
	and array_key_exists("action",$json_request)
	)
{
	$json_request=verify_session($json_request);
	$user=$json_request["user"];
	$session_key=$json_request["session_key"];
	$func=get_func($json_request);
	
	if ($func)
	{
		$results=$func($json_request);
	}
	$results['user']=$user;
	$results['session_key']=$session_key;
	
	$ret_json=json_encode($results,0,512);
	$log_messages=log_message("");
	$messages=urlencode(json_encode($log_messages));
	$query ="insert into log_messages(userid,execution_dttm,key,request,response,messages) values ($user,now(),'$session_key','".$service_request."','".$ret_json."','".$messages."');";
	db_exec($query);
}
print $ret_json;

?>
