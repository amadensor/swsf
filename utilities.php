<?php

session_start();
require_once 'config.php';



function check_perm($json) //Return true or false based on whether user has a role with this permission
{
  $query="select count(*) from role_actions ra,roles r,user_roles ur,users u where r.role_name=r.role_name and ur.role_name=r.role_name and ur.userid=u.userid and u.userid=".$json["user"]." and ra.service_name='".$json["service"]."' and ra.action='".$json["action"]."';";
  $perm=db_retrieve($query);
  $perm_count=$perm[0]["count"];
  if ($perm_count==0) 
    return false;
  else 
    return true;
  
  
}

function get_func($json) //Get the appropriate function name for this action for this service.
{
  $query="select function from service_actions where service_name='".$json["service"]."' and action='".$json["action"]."';";
  $func=db_retrieve($query);
  $func_name=$func[0]["function"];
  if (check_perm($json))
  {
    return $func_name;
  }
  else
  {
    return NULL;
  }
  
}

function verify_session($json) //Verify that the sesstion was valid and not hijacked with a rolling key.
{
  if ($json["session_key"])
  {
  $query="select count(*) from sessions where userid=".$json["user"]." and key='".$json["session_key"]."';";
  $key=db_retrieve($query);
  $count=$key[0]["count"];
  $new_key=uniqid();
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

function call_handler($call_vars) //Call the web service from PHP.   The service could also be called from an external application.
{
  global $handler_url;
  $call_vars["user"]=$_SESSION["user"];
  $call_vars["session_key"]=$_SESSION["session_key"];
  $json_request=json_encode($call_vars);
  $service_request = "service_request=" . $json_request . "&";
  $ch = curl_init($handler_url);
  curl_setopt($ch, CURLOPT_POST, true);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_POSTFIELDS, $service_request);
  $result = curl_exec($ch);
  $return_vars=json_decode($result,TRUE);
  $_SESSION["session_key"]=$return_vars["session_key"];
  return $return_vars;
}


function get_role_action ($call_vars)  //Application like code for security maintenance
{
  
  $role_name=urlencode($call_vars['role']);
  $query="select service_name, action from role_actions where role_name='$role_name';";
  $role_results=db_retrieve($query);
  $role_results['role']=$role_name;
  return $role_results;
  
}

function list_roles($call_vars)  //Application like code for security maintenance
{
  $query="select role_name, description from roles;";
  $role_list=db_retrieve($query);
  return $role_list;
}

function list_services($call_vars)  //Application like code for security maintenance
{
  $query="select service_name, description from services;";
  $service_list=db_retrieve($query);
  return $service_list;
}

function list_actions($call_vars)  //Application like code for security maintenance
{
  $query="select action, description from actions;";
  $action_list=db_retrieve($query);
  return $action_list;
}


function delete_role_action($call_vars)  //Application like code for security maintenance
{
  $role=urlencode($call_vars['upd_role']);
  $service_name=urlencode($call_vars['upd_service_name']);
  $action=urlencode($call_vars['upd_action']);
  $query="delete from role_actions where role_name='$role' and service_name='$service_name' and action='$action';";
  db_exec($query);
}

function add_role_action($call_vars)  //Application like code for security maintenance
{
  $role=urlencode($call_vars['upd_role']);
  $service_name=urlencode($call_vars['upd_service_name']);
  $action=urlencode($call_vars['upd_action']);
  $query="insert into role_actions (role_name,service_name,action) values ('$role','$service_name','$action');";
  db_exec($query);
}

function add_role($call_vars)
{
  $role=urlencode($call_vars['role_name']);
  $description=urlencode($call_vars['description']);
  $query="insert into roles (role_name,description) values ('$role','$description');";
  db_exec($query);
}	

function update_role($call_vars)
{
  $role=urlencode($call_vars['role_name']);
  $description=urlencode($call_vars['description']);
  $query="update roles set description='$description' where role_name='$role';";
  db_exec($query);
}	

function delete_role($call_vars)
{
  $role=urlencode($call_vars['role_name']);
  $query="delete from roles where role_name='$role';";
  db_exec($query);
}	


function add_service($call_vars)
{
  $service=urlencode($call_vars['service_name']);
  $description=urlencode($call_vars['description']);
  $query="insert into services (service_name,description) values ('$service','$description');";
  db_exec($query);
}	

function update_service($call_vars)
{
  $service=urlencode($call_vars['service_name']);
  $description=urlencode($call_vars['description']);
  $query="update services set description='$description' where service_name='$service';";
  db_exec($query);
}	

function delete_service($call_vars)
{
  $service=urlencode($call_vars['service_name']);
  $query="delete from services where service_name='$service';";
  db_exec($query);
}	

function add_action($call_vars)
{
  $action=urlencode($call_vars['action_name']);
  $description=urlencode($call_vars['description']);
  $query="insert into actions (action,description) values ('$action','$description');";
  db_exec($query);
}	

function update_action($call_vars)
{
  $action=urlencode($call_vars['action_name']);
  $description=urlencode($call_vars['description']);
  $query="update actions set description='$description' where action='$action';";
  db_exec($query);
}	

function delete_action($call_vars)
{
  $action=urlencode($call_vars['action_name']);
  $query="delete from actions where action='$action';";
  db_exec($query);
}	

?>
