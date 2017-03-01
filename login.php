<html><head>
</head>
<body>
<?php

//Start a new session.

session_start();
require 'db_connect.php';

if (array_key_exists('login',$_POST))
{
$login=urlencode($_POST['login']);
$query="select userid,pass from users where login='".$login."';";
$login_result=db_retrieve($query);
$pass=$login_result[0]['pass'];
$user=$login_result[0]['userid'];
if ($pass=='reset')
{
$pass_hash=password_hash($_POST['pass'],PASSWORD_DEFAULT);
//print "<br>pass hash: $pass_hash<br>\n";
//$_POST['pass']=$pass_hash;
$pass=$pass_hash;
$query="update users set pass='$pass_hash' where userid=$user;";
//print "<br>$query<br>";
db_exec($query);
}
if (password_verify($_POST['pass'], $pass))
{
    $_SESSION['user']=$user;
    $new_key=uniqid();
    $_SESSION["session_key"]=$new_key;
    $query="delete from sessions where userid=$user;";
    db_exec($query);
    $query="insert into sessions (userid,key) values($user,'$new_key');";
    db_exec($query);
    //If the password was good, create a new web service session and put it in the PHP session
}
else
{
print "<br>Login failed\n".$_POST['pass']."     :      ". $pass;
}
}
else
{
?>
<form method=post>
<br>Login:<input type=text name=login>
<br>Pass:<input type=text name=pass>
<br><input type=submit>


<?php
}
?>
</body></html>
