<?php

require_once 'config.php';



function check_perm($json) //Return true or false based on whether user has a role with this permission
{
  $query="select count(*) from role_actions ra,roles r,user_roles ur,users u where ra.role_name=r.role_name and ur.role_name=r.role_name and ra.service_name='".$json["service"]."' and ra.action='".$json["action"]."' and ur.userid=u.userid and (u.userid=".$json["user"]." or r.role_name='public');";
  $query="select count(*) from role_actions ra,roles r,user_roles ur,users u where ra.role_name=r.role_name and ur.role_name=r.role_name and (ur.userid=u.userid and u.userid=".$json["user"]." and ra.service_name='".$json["service"]."' and ra.action='".$json["action"]."') ;";
  $perm=db_retrieve($query);
  $perm_count=$perm[0]["count"];
  if ($perm_count==0) 
    return false;
  else 
    return true;
  
  
}

function get_func($json) //Get the appropriate function name for this action for this service.
{
  if (check_perm($json))
  {
	$query="select function from service_actions where service_name='".$json["service"]."' and action='".$json["action"]."';";
	$func=db_retrieve($query);
	$func_name=$func[0]["function"];
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

function list_service_action($call_vars)
{
  $service=urlencode($call_vars['service_name']);
  $query="select service_name, action, function from service_actions where service_name='$service';";
  $service_action_list=db_retrieve($query);
  return $service_action_list;
}

function add_service_action($call_vars)
{
	$service=urlencode($call_vars['service_name']);
	$action=urlencode($call_vars['action_name']);
	$function=urlencode($call_vars['function']);
	$query="insert into service_actions (service_name,action,function) values ('$service','$action','$function')";
	db_exec($query);
}

function update_service_action($call_vars)
{
	$service=urlencode($call_vars['service_name']);
	$action=urlencode($call_vars['action_name']);
	$function=urlencode($call_vars['function']);
	$query="update service_actions set function='$function' where service_name='$service' and action='$action';";
	db_exec($query);
}

function delete_service_action($call_vars)
{
	$service=urlencode($call_vars['service_name']);
	$action=urlencode($call_vars['action_name']);
	$query="delete from service_actions where service_name='$service' and action='$action';";
	db_exec($query);
}

function list_users($call_vars)
{
  $query="select userid,login from users;";
  $user_list=db_retrieve($query);
  return $user_list;
}

function list_user_roles($call_vars)
{
	if (array_key_exists('role',$call_vars))
	{
		$role=urlencode($call_vars['role']);
		$query="select a.userid, b.login, a.role_name from user_roles a, users b where a.role_name='$role' and a.userid=b.userid;";
	}
	if (array_key_exists('role_user',$call_vars))
	{
		$role_user=urlencode($call_vars['role_user']);
		$query="select userid, role_name from user_roles where userid='$role_user';";
		$query="select a.userid, b.login, a.role_name from user_roles a, users b where a.userid=$role_user and a.userid=b.userid;";
	}
	$user_roles=db_retrieve($query);
	return $user_roles;
}

function add_user_role($call_vars)
{
	$role_user=urlencode($call_vars['role_user']);
	$role=urlencode($call_vars['role']);
	$query="insert into user_roles (userid,role_name) values ($role_user,'$role');";
	db_exec($query);
}

function delete_user_role($call_vars)
{
	$role_user=urlencode($call_vars['role_user']);
	$role=urlencode($call_vars['role']);
	$query="delete from user_roles where userid=$role_user and role_name='$role';";
	db_exec($query);
}

function queue($json_request)
{
	$req_json=json_encode($json_request,0,512);
	$user=$json_request["user"];
	$query ="insert into queue(userid,arrival_dttm,request) values ($user,now(),'".$req_json."');";
	db_exec($query);

}

?>
