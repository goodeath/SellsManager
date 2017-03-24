<?php
	
	namespace controller;

	class bean
	{
		//==============================
    //          __CALL  
    //============================== 
    public function __call($name,$value)
    {
      # Check if 'get' is in $name
      if(preg_match_all("/get/",$name)){
        # Replace 'get' with "blank space"
        $n = preg_replace("/get/", "",$name);
        # Transform lower case first character
        $n = lcfirst($n);
        # If attribute is !empty , returns
        if(!empty($this->$n)) return $this->$n;
        else exit("$name Não existe");
      } # Chek if 'set' is in $name 
      elseif(preg_match_all("/set/",$name)){
        # Replace 'set' with "blank space"
        $n = preg_replace("/set/", "",$name);
        # Transform lower case first character
        $n = lcfirst($n);
        # If attribute is set
        if(isset($n)){
          # Assigns the value
          $this->$n = $value[0];
          # Return itself
          return $this;
        }
      }else{
        exit($name." não existe");
      }
    }
		//==============================
    //       __SET METHODS  
    //============================== 
    public function setRoute(routes $routes)
    {
      # Get route
      $this->route = $routes;
      # View
      $this->setView($routes->getActive()[0]);
    }

    public function openConnection($obj)
    {
      return new $obj();
    }
	}