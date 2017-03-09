<html>
<body>
<?php include ('menu.php'); ?>
<table border=1>
<tr><th>Service Name</th><th>Description</th></tr>
<?php
foreach ($services as $service)
{
	if (is_array($service) && array_key_exists('service_name',$service))
	{
		?>
<form method=post>
<tr><td>
<input type="text" name="service_name" value='<?=$service['service_name']?>'>
<td><input type="text" name="description" value='<?=$service['description']?>'>
<td><button type=submit name="action" value="delete">Remove</button>
<button type=submit name="action" value="update">Update</button>
</form>
<?php }} ?>
<form method=post>
<tr><td>
<input type="text" name="service_name">
<td><input type="text" name="description">
<td><button type=submit name="action" value="add">Add</button>
</form>

</table>
</body>
</html>
