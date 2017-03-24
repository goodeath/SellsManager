<?php
  
  ##########################################
  ##                                      ##
  ##  Created by Alex Anderson            ##
  ##  Date: 06/05/2015                    ##
  ##  Contact: alexandersonbm@hotmail.com ##
  ##                                      ##
  ##########################################
  
  namespace controller\fotografe;
  
  class mainView extends main
  {
    
    
    public function viewFotografe(){
      session_start();
      ###########################################
  ##              Data                     ##
  ###########################################
  
  //Array of fields
  $fields = array($_POST['campos'],$_POST['campos2']);
  
  //Array with dates
  $periods = array($_POST['date'],$_POST['date2']);
   
  ###########################################
  ##           Retrieve Data               ##
  ###########################################
  
  //Start classes
  
  $this->old_cons($fields,$periods);
  //Table name
  $nameFilter = $this->name;
  
  //Execute fotografe function
  $data = $this->fotografe();
  
  //Clients that evolved
  $evoCliente = $data[1];
  
  //Clients that regressed
  $regCliente = $data[2];
  
  //How many evolved.
  $evolução = count($evoCliente);
  
  //How many regressed.
  $regressão = count($regCliente);
  
  $contagem = $data[0];
  
  //Evolution values.
  $eValue = $contagem[1][1];
  
  //Regression values.
  $contagem[1][0] < 0 ?  $rValue = (-1)*$contagem[1][0] :  $rValue = $contagem[1][0]; 
 
  ##Verifica a diferença, e se for negativa, multiplica por -1 devido ao gráfico
  $diferença = ($contagem[1][0]) + ($contagem[1][1]);
  $diferença < 0 ? $difstring = $diferença*(-1) : $difstring = $diferença;
  
  
  
###################################################################
##                          SESSIONS                             ##
###################################################################
  $_SESSION['campos'] = array($_POST['campos'],$_POST['campos2']);
  $_SESSION['datas'] = array($_POST['date'],$_POST['date2']);
  $_SESSION['campo'] = $nameFilter;
    require_once $this->getView();
    }

  }

?>