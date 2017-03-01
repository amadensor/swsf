<?php

//URL to handler for call_handler.   This is available for easily calling the web service from PHP.
$handler_url="http://localhost/~grant/swsf/handler.php";

//DB connection string for MDB2
$dsn = array(
  'phptype'  => 'pgsql',
  'username' => 'swsf',
  'password' => 'swsfpass',
  'hostspec' => 'localhost',
  'database' => 'swsf',
  );
?>
