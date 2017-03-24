<?php
  //Get constants of directories
  //=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
	include $_SERVER['DOCUMENT_ROOT'].'/vendas/sys/con_dir.php';
    include DATABASE;
  //Include class that executes operations with datebase
  //=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
  include CLASSE.'class_crud.php';
  
  ini_set('max_execution_time', 0); 
  
  /*$myfile = fopen("exporta.txt", "r");
  $x = 0;
  while($file = fgets($myfile))
  {
    $array[$x] = explode(";",$file);
    ++$x;
  }

  foreach($array as $key)
  {
	$dia = $key[17].'-'.$key[16].'-'.$key[15]." 00:00:00";
		
    $values = "'".implode("', '", array_values($key))."'";
    mysql_query("insert into vendas VALUES($values,'$dia')");
	echo "insert into vendas VALUES($values,'$dia') <br />";
    //$check = crud::read("vendas","where N='$key[0]' and DESCRICAO='$key[12]'");
    //count($check) == 0 ? crud::insert("vendas",$key) : '';
  }
*/
  echo "LOL";
  $myfile = fopen("cidade.txt", "r");
  $x = 0;
  while($file = fgets($myfile))
  {
    $array[$x] = explode("|",$file);
    ++$x;
  }

  $translate = ['Nao classificada'=>0,'R 2'=>1,'R 3'=>2, 'R 4'=>3,'R 5'=>15,'R 6'=>4,'R 7'=>5,'R 8'=>6,'R 9'=>7,'R 10'=>8,'R 11'=>9,'R 12'=>10,'R 13'=>11,'R 14'=>12,'R 15'=>13,'R 16'=>14];
  foreach($array as $key)
  {
    $id = $translate[$key[1]];
    $name = $key[0]


    mysql_query("insert into vendas (name,cid_regiao) VALUES('$name',$id)");
  echo "insert into vendas (name,cid_regiao) VALUES('$name',$id) <br />";
    //$check = crud::read("vendas","where N='$key[0]' and DESCRICAO='$key[12]'");
    //count($check) == 0 ? crud::insert("vendas",$key) : '';
  }

?>

