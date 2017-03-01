<?php

//Show the most recent 100 logs

require_once('db_connect.php');
require_once('utilities.php');

$check['user']=$_SESSION["user"];
$check['service']='logs';
$check['action']='list';
if (check_perm($check))
{
	$query="select userid,execution_dttm,key,request,response,messages from log_messages order by execution_dttm desc limit 100;";
	$logs=db_retrieve($query);
	include ('views/show_logs.php');
}
else 
{
	print"No access";
}
?>
