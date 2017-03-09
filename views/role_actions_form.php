<html><head>
</head>
<body>
<?php include ('menu.php'); ?>	
Role: <?=$roles['role']?>
<table border=1>
<th>Service<th>Action
<?php
    foreach ($roles as $role)
    {
      if(is_array($role) && array_key_exists('action',$role))
      {
?>
<tr>
<form method=post>
<input type=hidden name=role value='<?=$roles['role']?>'>
<td><input type=hidden name=upd_service_name value='<?=$role['service_name']?>'> <?=$role['service_name']?>
<td><input type=hidden name=upd_action value='<?=$role['action']?>'> <?=$role['action']?>
<input type=hidden name=action value=delete>
<td><input type=submit value="-"></form>
<?php
      }
    }
    ?>
    <form method="post">
		<tr>
<input type=hidden name=role value='<?=$roles['role']?>'>
<td><select name=upd_service_name >
	<?php foreach ($select_services as $select_service){ if (is_array($select_service) && array_key_exists('service_name',$select_service)){?>
	<option value=<?=$select_service['service_name']?>><?=$select_service['service_name']?>:<?=$select_service['description']?></option>
	<?php }} ?>
<td><select name=upd_action > 
	<?php foreach ($select_actions as $select_action){ if (is_array($select_action) && array_key_exists('action',$select_action)){?>
	<option value=<?=$select_action['action']?>><?=$select_action['action']?>:<?=$select_action['description']?></option>
	<?php }} ?>
<input type=hidden name=action value=add>
<td><input type=submit value="+"></form>
		</tr>
		</form>
    </table>
<a href="role_actions.php">Choose new role</a>
</body></html>
