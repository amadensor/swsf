<?php

session_start();
require_once 'config.php';



function check_perm($json)
{
  //print"check perm";
  $query="select count(*) from role_actions ra,roles r,user_roles ur,users u where r.role_name=r.role_name and ur.role_name=r.role_name and ur.userid=u.userid and u.userid=".$json["user"]." and ra.service_name='".$json["service"]."' and ra.action='".$json["action"]."';";
  //print "<br><br>".$query." <br><br>\n";
  $perm=db_retrieve($query);
  //var_dump($perm);
  $perm_count=$perm[0]["count"];
  //print "count:".$perm_count;
  if ($perm_count==0) 
    return false;
  else 
    return true;
  
  
}

function get_func($json)
{
  //print"Get Func";
  $query="select function from service_actions where service_name='".$json["service"]."' and action='".$json["action"]."';";
  //print "<br>Get Function: $query<br>";
  $func=db_retrieve($query);
  //var_dump($func);
  
  //$func_name=db_retrieve($func,0);
  //var_dump($func_name);
  $func_name=$func[0]["function"];
  if (check_perm($json))
  {
    //print"permitted";
    return $func_name;
  }
  else
  {
    //print"Denied";
    return NULL;
  }
  
}

function verify_session($json)
{
  //print"verify session";
  //print "<br>User: ".$json["user"]."\n";
  if ($json["session_key"])
  {
  $query="select count(*) from sessions where userid=".$json["user"]." and key='".$json["session_key"]."';";
  $key=db_retrieve($query);
  $count=$key[0]["count"];
  $new_key=uniqid();
  //print "Old Key: $old_key <br>\n";
  //print "New Key: $new_key <br>\n";
  if ($count==1)
  {
    $json["session_key"]=$new_key;
    $query="update sessions set key='$new_key'where userid=".$json["user"].";";
    db_exec($query);
  }
  else
  {
    $query="delete from sessions where userid=".$json["user"].";";
    db_exec($query);
    $json=false;
    die("Session hijack error");
  }
  
  return $json;
  }
  else
  {
    return null;
  }
}

function call_handler($call_vars)
{
  global $handler_url;
  $call_vars["user"]=$_SESSION["user"];
  $call_vars["session_key"]=$_SESSION["session_key"];
  $json_request=json_encode($call_vars);
  $service_request = "service_request=" . $json_request . "&";
  //print "\n<br>SR : $service_request <br>\n";
  $ch = curl_init($handler_url);
  curl_setopt($ch, CURLOPT_POST, true);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_POSTFIELDS, $service_request);
  //print "\n<br><br>Request: $json_request\n<br><br>";
  $result = curl_exec($ch);
  //print "\n<br>Result: $result <br><br>\n";
  $return_vars=json_decode($result,TRUE);
  $_SESSION["session_key"]=$return_vars["session_key"];
  return $return_vars;
}


function get_role_action ($call_vars)
{
  
  $role_name=urlencode($call_vars['role']);
  $query="select service_name, action from role_actions where role_name='$role_name';";
  $role_results=db_retrieve($query);
  $role_results['role']=$role_name;
  return $role_results;
  
}

function list_roles($call_vars)
{
  $query="select role_name, description from roles;";
  $role_list=db_retrieve($query);
  return $role_list;
}

function update_role($call_vars)
{
  $role=urlencode($call_vars['upd_role']);
  $query="delete from role_actions where role_name='$role'";
  db_exec($query);
  foreach($call_vars as $role_update) {
  	if (array_key_exists('upd_action',$role_update))
  	{
  	$service_name=urlencode($role_update['upd_service_name']);
  	$action=urlencode($role_update['upd_action']);
  	if ($action and $service_name)
  	{
  	  	$query="insert into role_actions (role_name,service_name,action) values('$role','$service_name','$action');";
  	  	db_exec($query);
  	}
  }
  }
}

?>

