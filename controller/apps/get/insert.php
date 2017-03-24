<?php
  //Get constants of directories
  //=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
	include $_SERVER['DOCUMENT_ROOT'].'/sys/con_dir.php';
  
  //Include class that executes operations with datebase
  //=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
  include CLASSE.'class_crud.php';
  
  ini_set('max_execution_time', 0); 

  
  $myfile = fopen("CEG.txt", "r");
  $x = 0;
  while($file = fgets($myfile))
  {
    $array[$x] = explode("|",$file);
    ++$x;
  }
  
  foreach($array as $key)
  {
    $values = "'".implode("', '", array_values($key))."'";
    mysql_query("insert into produtos2 VALUES($values)");
  } 
  /*
  $array = crud::read("vendas","group by CLIENTE","CLIENTE");
  foreach($array as $key)
  {
    mysql_query("INSERT into clientes (nome) VALUES('$key[0]')");
  }*/
  
?>

