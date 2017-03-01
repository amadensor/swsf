<?php
require 'db_connect.php';
require 'utilities.php';
require 'application.php';
$service_request=$_POST["service_request"];
//var_dump ($service_request);
$json_request=json_decode($service_request,TRUE);

$json_request=verify_session($json_request);
$user=$json_request["user"];
$session_key=$json_request["session_key"];
//print"<br><br><br>\n $service_request<br><br><br>\n";
//var_dump( $json_request);

//print"<br><br><br>\n";
//print $json_request["service"];
//print"<br><br><br>\n";

//print "\n<br>JR : ".$json_request["user"].$json_request["session_key"]."<br>\n";
$func=get_func($json_request);

//print "<br>Function:".$func."<br>\n";
$results=$func($json_request);
$results['user']=$user;
$results['session_key']=$session_key;

//var_dump($results);

$ret_json=json_encode($results);
$log_messages=log_message("");
$messages=urlencode(json_encode($log_messages));
$query ="insert into log_messages(userid,execution_dttm,key,request,response,messages) values ($user,now(),'$session_key','".$service_request."','".$ret_json."','".$messages."');";
db_exec($query);
print $ret_json;

?>
