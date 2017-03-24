<?php
  
  ##########################################
  ##                                      ##
  ##  Created by Alex Anderson - G00D34TH ##
  ##  Date: 06/05/2015                    ##
  ##  Contact: alexandersonbm@hotmail.com ##
  ##                                      ##
  ##########################################
  
  namespace controller\evolution;

  class mainView extends main
  { 
    public function viewEvolution()
    {
      session_start();
      # Get date interval
      $date = $_POST['date'];
      # GEt date period
      $this->getPeriod($date);
      $this->setFielda($_POST['campos']);
      $values = $this->evolution();
      #echo "<pre>";print_r($values);echo "</pre>";
      $string2 = implode(array_map(function($n){return $n[0];},$values[0]),",");
      $valores = implode(array_map(function($n){return $n[1];},$values[0]),",");
      $valores2 = implode(array_map(function($n){return $n[1];},$values[1]),",");
      $_SESSION['campos'] = $_POST['campos'];
      $_SESSION['date'] = $date;
      require_once $this->getView();  
    }
  }
?>