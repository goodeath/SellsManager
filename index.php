<?php
  
  /**********************************************
  		Configuração de diretórios
  **********************************************/


  # Insert initialize php config 
  require_once "phpInit.php";
  # Get filtered url
  $uri = rtrim( dirname($_SERVER["SCRIPT_NAME"]), '/' ); 
  $uri = trim( str_replace( $uri, '', $_SERVER['REQUEST_URI'] ), '/' );
  $uri = urldecode( $uri );
  # Call layout page
  require_once(VIEW.'layout.php');
