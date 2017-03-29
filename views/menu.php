<?php
$menu['actions.php']='Actions';
$menu['logs.php']='Logs';
$menu['role_actions.php']='Role Actions';
$menu['roles.php']='Roles';
$menu['user_roles.php']='User Roles';
$menu['service_actions.php']='Service Actions';
$menu['services.php']='Services';
$menu['logout.php']='Logout';


$base= basename($_SERVER['REQUEST_URI']);
print "<center></center><table border=0 align=center><tr>";
if (array_key_exists('session_key',$_SESSION) && $_SESSION["session_key"]<>"")
{
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
}
else
{
	print "<td><a href='login.php'>Login</a>";
}
print "</table></center>";
?>
