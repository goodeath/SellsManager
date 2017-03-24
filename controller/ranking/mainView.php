<?php
  
  ##########################################
  ##                                      ##
  ##  Created by Alex Anderson            ##
  ##  Date: 06/05/2015                    ##
  ##  Contact: alexandersonbm@hotmail.com ##
  ##                                      ##
  ##########################################
  
  namespace controller\ranking;

  class mainView extends main
  {
    
    public function viewRanking() {
      session_start();
      //Array of fields
  $fields = array($_POST['campos'],$_POST['campos2']);
  
  ###########################################
  ##           Retrieve Data               ##
  ###########################################

  $this->old_cons($fields);
  $item = $this->ranking($_POST['date']);
  $total = $this->total;
  $tableField = $this->tabla;
  $nameFilter = $this->name;
  

  $outros = 0;
  $limit = count($item);
  for($x = 4;$x<$limit;$x++){$outros += round($item[$x][0],2);}
  $outrosCent = round(($outros/$total)*100,2);
 
###################################################################
##                          SESSIONS                             ##
###################################################################
  $_SESSION['campos'] = array($_POST['campos'],$_POST['campos2']);
  $_SESSION['datas'] = $_POST['date'];
  $_SESSION['campo'] = $nameFilter;
      require_once $this->getView();
}
  }

?>