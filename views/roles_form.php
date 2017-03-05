<html>
<body>
<table border=1>
<tr><th>Role Name</th><th>Description</th></tr>
<?php
foreach ($roles as $role)
{
	if (is_array($role) && array_key_exists('role_name',$role))
	{
		?>
<form method=post>
<tr><td>
<input type="text" name="role_name" value='<?=$role['role_name']?>'>
<td><input type="text" name="description" value='<?=$role['description']?>'>
<td><button type=submit name="action" value="delete">Remove</button>
<button type=submit name="action" value="update">Update</button>
</form>
<?php }} ?>
<form method=post>
<tr><td>
<input type="text" name="role_name">
<td><input type="text" name="description">
<td><button type=submit name="action" value="add">Add</button>
</form>
</table>
</body>
</html>
