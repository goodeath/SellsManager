<?php
  
  ##########################################
  ##                                      ##
  ##  Created by Alex Anderson            ##
  ##  Date: 06/05/2015                    ##
  ##  Contact: alexandersonbm@hotmail.com ##
  ##                                      ##
  ##########################################
  
  //Include class
  namespace controller\moves;
  
  class mainView extends main
  {
   
    
    public function viewMoves()
    {
      session_start();
      
   //Array of fields
  $fields = array($_POST['campos'],$_POST['campos2']);
  $date = $_POST['date'];
   

  $this->setFielda($fields);
  
  //Identifica os intervalos dos períodos  escolhidos
  $periodos = \controller\period::getPeriod($date);
  
  
  //Table name
  //=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
  $nameFilter = $this->name;
  $tableField = $this->table;
  
  $lista = $this->moves($periodos);
  
  $_SESSION['campo'] = $nameFilter;


  $inativo = count($lista['inativo']);
  $recuperado = count($lista['Recuperados']);
  $constante = count($lista['constante']);
  $novos = count($lista['novos']);

  ###########################################
  ##               Sessions                ##
  ########################################### 
  $_SESSION['field']  = $fields;
  $_SESSION['date'] = $date;
  require_once $this->getView();
    }

  }

?>