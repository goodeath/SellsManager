<?php

  # ROOT
  define('ROOT', $_SERVER['DOCUMENT_ROOT']."/vendas/");
  # Define controller path
  define("CONTROLLER",ROOT."controller/");
  # Define view path
  define("VIEW",ROOT."view/");
  # Define root
  define("MODEL",ROOT."model/");
  # Define HTML
  define("HTML",VIEW."html/");
  define("DEFAULT_ITEMS",HTML."default_items/");
  define("NAV2",DEFAULT_ITEMS."nav2.php");
  define("NAV3",DEFAULT_ITEMS."nav3.php");
  define("NAV4",DEFAULT_ITEMS."nav4.php");
  define("CENTERNAV",DEFAULT_ITEMS."centerNav.php");
  # Define header
  define("HEADER",HTML."header.php");
  define("SYSTEM",HTML."sys/");
	define("MATERIAS",ROOT."materias/");
	define("FOOT",HTML."foot.php");
	define("PHPMAILER","$_SERVER[DOCUMENT_ROOT]/apps/phpmailer/class.phpmailer.php");
	define("FUNC","$_SERVER[DOCUMENT_ROOT]/apps/funcoes/");
	define("RESTRITO",HTML."restrito/painel/");

	define("CLASSE",ROOT."apps/class/");
	define("FORM",HTML."sys/form/");
	  
	  
	  define("INTERFACES",ROOT."apps/interface/");
	  define("PDO_DB",CONTROLLER."database_controller.php");
	  define("SYS",CONTROLLER."system_controller.php");

#define('BASE_PATH', realpath(dirname(__FILE__)));

function my_autoloader($class)
{

    $class = str_replace('\\', "/", $class);

     #echo "<br >";
    if(file_exists(''.$class. '.php')){
     # echo  $class. '_controller.php'."<br />";
      require_once ''.$class. '.php';
    }elseif(file_exists('../'.$class. '.php')){
     #echo ''.$class. '_controller.php';
      require_once ''.$class. '.php';
    }elseif(file_exists(''.$class. '.php')){
     #echo ''.$class. '.php';
      require_once ''.$class. '.php';
    }elseif(file_exists('../'.$class. '.php')){
      #echo ''.$class. '.php';
      require_once ''.$class. '.php';
    }
    elseif(file_exists('../'.$class. '_trait.php')){
      # echo  ''.$class. '_trait.php'."<br />";
      require_once ''.$class. '_trait.php';
    }
 
} 
spl_autoload_register('my_autoloader');
