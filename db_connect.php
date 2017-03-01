<?php

require_once 'MDB2.php';
require_once 'config.php';

  
  $dbconn=& MDB2::singleton($dsn)	;
  if (PEAR::IsError($dbconn)){
    print "conn error\n";
    die($dbconn->getMessage());
  };
  ;
  
  
  function db_exec($query)
  {
    $dbconn=& MDB2::singleton();
    
    if (PEAR::IsError($dbconn)){
      print "exec conn error\n";
      die($dbconn->getMessage());
    };
    log_message("DB_EXEC $query");
    
    $result=& $dbconn->exec($query);
    
    if (PEAR::IsError($result)){
      print "<br>exec error\n";
      print "<br>DB_EXEC $query <BR>\n";
      //var_dump($result);
      die($result->getMessage());
    }
    ;
    
    return TRUE;
  }
  
  function db_retrieve($query)
  {
    $dbconn=& MDB2::singleton();
    
    if (PEAR::IsError($dbconn)){
      print "conn error\n";
      die($dbconn->getMessage());
    };
    log_message("DB_GET $query");
    
    $result=& $dbconn->query($query);
    
    if (PEAR::IsError($result)){
      print "<br>select error\n";
      print "<br>DB_GET $query <BR>\n";
      die($result->getMessage());
    }
    ;
    
    $rows=$result->fetchAll(MDB2_FETCHMODE_ASSOC);
    return $rows;
  }

  function log_message($text)
{
  static $logs=array();
  if ($text)
    $logs[]=$text;
  return $logs;
}

  ?>
  
  
  
