<html>
<body>
<form method=post>
<select name=service_name>
<?php
foreach($services as $service)
{
	if (is_array($service) && array_key_exists('service_name',$service))
	{
		?>
		<option value="<?=$service['service_name']?>"><?=$service['service_name']?> - <?=$service['description']?></option>
		<?php
	}
}
?>
</select>
<input type=hidden name=action value=list>
<input type=submit>
</form>
</body>
</html>
