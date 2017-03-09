<html>
<body>
<?php include ('menu.php'); ?>
	<table border=1>
<?php
foreach($service_actions as $service_action)
{
	if (is_array($service_action) && array_key_exists('service_name',$service_action))
	{
		$service=$service_action['service_name'];
		$action=$service_action['action'];
		$function=$service_action['function'];
		?>
		<form method=post>
		<tr><td><?=$service?><td><?=$action?><td>
			<input type=hidden name=service_name value='<?=$service?>'>
			<input type=hidden name=action_name value='<?=$action?>'>
			<input type=text name=function value='<?=$function?>'><br>
		<td><button type=submit name="action" value="update">Update</button><button type=submit name="action" value="delete">Delete</button>
		</form>
		<?php

	}
}
?>
<form method=post>
<tr><td>
	<select name='service_name'>
	<?php
	foreach($services as $service)
	{
		if(is_array($service) && array_key_exists('service_name',$service))
		{
			?>
			<option value='<?=$service['service_name']?>'><?=$service['service_name']?>-<?=$service['description']?></option>";
			<?php
		}
	}
	?>
	</select>
<td>
	<select name='action_name'>
	<?php
	//var_dump($actions);
	foreach($actions as $action)
	{
		if(is_array($action) && array_key_exists('action',$action))
		{
			?>
			<option value='<?=$action['action']?>'><?=$action['action']?>-<?=$action['description']?></option>";
			<?php
		}
	}
	?>
	<td><input type=text name=function></td>
	<td><button type=submit name="action" value="add">Add</button>
	</select>
	</form>
</table>
<a href='service_actions.php'>Pick new service/action</a>
</body>
</html>
