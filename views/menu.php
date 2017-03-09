<?php
$menu['actions.php']='Actions';
$menu['login.php']='Login';
$menu['logs.php']='Logs';
$menu['role_actions.php']='Role Actions';
$menu['roles.php']='Roles';
$menu['service_actions.php']='Service Actions';
$menu['services.php']='Services';
//$head=getallheaders();
//var_dump($head);
//var_dump($_SERVER);

//var_dump($_SERVER['HTTP_HOST']);
//var_dump($_SERVER['REQUEST_URI']);
//print_r($_SERVER);
$base= basename($_SERVER['REQUEST_URI']);
print "<center></center><table border=0 align=center><tr>";
foreach ($menu as $key=>$item)
{
	print "<td>";
	if ($base != $key)
	{
		print "<a href='$key'>";
	}
	print "$item";
	if ($base != $key)
	{
		print "</a>";
	}
}
print "</table></center>";
?>
