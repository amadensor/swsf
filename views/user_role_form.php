<html>
	<body>
<?php include ('menu.php'); ?>		
<form method=post>
		Select users by role: <select name='role'>
<?php
foreach ($roles as $role)
{
	if (is_array($role))
	{
		?>
		<option value='<?= $role['role_name']?>'> <?= $role['description']?></option>;
		<?php
	}
}
?>	</select>
<input type=hidden name='list' value='by_role'>
<input type=submit>
</form>
<form method=post>
		Select roles by user: <select name='role_user'>
<?php

foreach ($users as $role_user)
{
	if (is_array($role_user))
	{
		?>
		<option value='<?= $role_user['userid']?>'><?= $role_user['login']?></option>
		<?php 
	}
}
?>	</select>
<input type=hidden name='list' value='by_user'>
<input type=submit>
</form>
<table border=1>
	<tr><th>User<th>Role</th><th>Delete</th>
<?php 
if (isset($user_roles))
{
	foreach ($user_roles as $user_role)
	{
			if (is_array($user_role))
				{
					?>
					<form method=post><input type=hidden value=delete name=action>
					<input type=hidden name=role_user value='<?= $user_role['userid']?>'>
					<input type=hidden name=role value='<?= $user_role['role_name']?>'>
					<tr><td><?= $user_role['login']?> 
					<td><?= $user_role['role_name']?>
					<td><input type=submit>
					</form>
					<?php
				}
	}
}
?>
</table>
<hr>
Add a role/user combination: 
<form method=post><input type=hidden value=add name=action>
User: 
		<select name='role_user'>
<?php

foreach ($users as $role_user)
{
	if (is_array($role_user))
	{
		print "<option value='".$role_user['userid']."'>".$role_user['login']."</option>";
	}
}
?>	</select>

Role: 
		<select name='role'>
<?php
foreach ($roles as $role)
{
	if (is_array($role))
	{
		print "<option value='".$role['role_name']."'>".$role['description']."</option>";
	}
}
?>	</select>

<input type=submit>
</form>

	</body>
</html>
	
