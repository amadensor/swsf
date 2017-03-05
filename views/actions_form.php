<html>
<body>
<table border=1>
<tr><th>Action Name</th><th>Description</th></tr>
<?php
foreach ($actions as $action)
{
	if (is_array($action) && array_key_exists('action',$action))
	{
		?>
<form method=post>
<tr><td>
<input type="text" name="action_name" value='<?=$action['action']?>'>
<td><input type="text" name="description" value='<?=$action['description']?>'>
<td><button type=submit name="action" value="delete">Remove</button>
<button type=submit name="action" value="add">Add</button>
<button type=submit name="action" value="update">Update</button>
</form>
<?php }} ?>
</table>
</body>
</html>
