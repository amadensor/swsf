<html>
<body>
<?php include ('menu.php'); ?>
Show Logs:
<table border=1>
<tr><th>User</th><th>Date/Time</th><th>Key</th><th>Messages</th></tr>
<?php
foreach ($logs as $log)
{
?>
<tr>
	<td><?=$log['userid']?></td>
	<td><?=$log['execution_dttm']?></td>
	<td><?=$log['key']?></td>
	<td>
		<?=$log['request']?><br><br>
		<?=$log['response']?><br><br>
	<?php 
	$messages=json_decode(urldecode($log['messages']));
	foreach ($messages as $message)
	{
		print "$message<br>";
	}
	?>
	</td>

</tr>
<?php
}
?>
</table>
</body>
</html>
