<?php
namespace controller;
/**
 * Description of routers_controller
 *
 * @author Alex Anderson
 */
class routes {
  //put your code here
  
  public $routes;
  private $active;
  
  public function addRoute($route,$path,$controller = null,$action = null){
    $this->routes[$route][0] = $path;
    if($controller){
       $this->routes[$route][2] = "\\controller\\".$controller."View";
      $action = ucfirst(strtolower($action));
      $this->routes[$route][3] = "view".$action;
    }
    return $this;
  }
 
  public function getRoute($uri){
     $x = 0;
    $struri = '';
    $r = explode("/", $uri);
    
    foreach($r as $key=>$value){
      ++$x;
      
      $struri .= $value;
      if(!isset($r[$x][0]) ||  $r[$x][0] == "?") break;
       $struri .= "/";
    }

    
    if(isset($r[count($r)-1][0]) && $r[count($r)-1][0] == "?"){
      $qstring = $r[count($r)-1][0];
      $pairs = explode("&",$qstring);
      if(count($pairs) > 0){
      foreach($pairs as $key=>$value){
        $v = explode("=",$value);
        if(isset($v[1])) $_GET[$v[0]] = $v[1];
        
      }}else{
        $v = explode("=",$qstring);
        if(isset($v[1])) $_GET[$v[0]] = $v[1];
      }
      
      
    
    }

    $ro = isset($this->routes[$struri]) ? $this->routes[$struri] : $this->routes["404"] ;
    $this->active = $ro;
    
    return $ro;
  }
 
  
  public function getActive(){
    return $this->active;
}
}
