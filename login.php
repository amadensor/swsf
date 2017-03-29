<?php

session_start();
require 'db_connect.php';



switch (true)
{
case (array_key_exists('login_request',$_POST)):
	$login_request=json_decode($_POST['login_request']);
	$login=login_request['login'];
	$pass=login_request['pass'];
	$result=login($login,$pass);
	$json_result=json_encode($result);
	print $json_result;
	break;

case (array_key_exists('pass_confirm',$_POST) ):
	$login=$_POST['login'];
	$pass=$_POST['pass'];
	$new_pass=$_POST['pass_confirm'];
	$result=change_pass($login,$pass,$new_pass);
	include ('views/menu.php');
	break;

case ($_POST['change']):
      print "<html><body><form method=post>ID:<input type=text name=login>Old:<input type=password name=pass>New:<input type=password name=pass_confirm><input type=submit></form></body></html>";
      break;


case (array_key_exists('pass',$_POST)):
	$login=$_POST['login'];
	$pass=$_POST['pass'];
	$result=login($login,$pass);
	$_SESSION['session_key']=$result['session_key'];
	$_SESSION['user']=$result['userid'];
	

case (array_key_exists('session_key',$_SESSION) && $_SESSION['session_key']<>""):
	include ('views/menu.php');
	break;


default:
print "<html><body><form method=post>ID:<input type=text name=login>Password:<input type=password name=pass>Change:<input type=checkbox name=change><input type=submit></form></body></html>";
}

function login($name,$attempt_pass)
{
	$query="select userid,pass from users where login='".$name."';";
	$login_result=db_retrieve($query);
	$correct_pass=$login_result[0]['pass'];
	$user=$login_result[0]['userid'];
	$retval['name']=$name;
	$retval['session_key']='';
	$retval['userid']=0;


	if (password_verify($attempt_pass, $correct_pass))
	{
		$retval['userid']=$user;
		$new_key=uniqid();
		$retval["session_key"]=$new_key;
		$query="delete from sessions where userid=$user;";
		db_exec($query);
		$query="insert into sessions (userid,key) values($user,'$new_key');";
		db_exec($query);
		//If the password was good, create a new web service session and put it in the PHP session
    }
	
	return $retval;
	
}

function change_pass($name,$old_pass,$new_pass)
{

$query="select userid,pass from users where login='".$name."';";
$login_result=db_retrieve($query);
$pass=$login_result[0]['pass'];
$user=$login_result[0]['userid'];
if (password_verify($old_pass, $pass) || ($pass=='reset' && $old_pass==$new_pass))
{
	$pass_hash=password_hash($new_pass,PASSWORD_DEFAULT);
	$pass=$pass_hash;
	$query="update users set pass='$pass_hash' where userid=$user;";
	db_exec($query);
}
else
{
	print "Password change failed.";
}


}
?>
