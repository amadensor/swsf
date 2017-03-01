<html><head>
</head>
<body >
  <form method=post>
  <select name=role id=role>
<?php
  foreach($roles as $role) {
    if (is_array($role) && array_key_exists('role_name',$role))
    {
      $role_name=$role["role_name"];
      $description=$role["description"];
      print "<option value='$role_name'>$description</option>";
    }
  }
?>
  </select>
  <input type=hidden name=search value=y>
  <input type=submit>
  </form>
<script type="text/javascript">
document.getElementById('role').focus();
</script>
</body></html>
