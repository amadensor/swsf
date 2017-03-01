<html><head>
</head>
<body >
Role: <?=$roles['role']?>
<form method=post>
<input type=hidden name=upd_role value='<?=$role?>'>
<table border=1>
<th>Service<th>Action
<?php
    foreach ($roles as $role)
    {
      if(array_key_exists('action',$role))
      {
?>
<tr>
<td><input type=text name=upd_service_name[] value='<?=$role['service_name']?>'> 
<td><input type=test name=upd_action[] value='<?=$role['action']?>'> 
<?php
      }
    }
    print"</table><input type=submit></form>";
?>
</body></html>
