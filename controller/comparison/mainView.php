<?php
  
  ##########################################
  ##                                      ##
  ##  Created by Alex Anderson            ##
  ##  Date: 10/05/2015                    ##
  ##  Contact: alexandersonbm@hotmail.com ##
  ##                                      ##
  ##########################################
  
  namespace controller\comparison;
  
  class mainView extends main
  {
    


    public function viewComparison()
    {
      session_start();
      # Array of fields
      $fields = [$_POST['campos'],$_POST['campos2']];
      # Set fields
      $this->setFielda($fields);
      # Get period
      $this->getPeriod($_POST['date']);

  $boughts = $this->comparison();
  $sells = $boughts[0];
  $sellsA = $boughts[1];
  $string = $boughts[2];
  $valores = $boughts[3];
  $valores2 = $boughts[4];
  $datas = $this->periodos;
  $_SESSION['fields'] = $fields;
  $x = 0;
 
   # Get the first query
      $query1 = $this->getQuery(0);
      # Get the second query
      $query2 = $this->getQuery(1);

   $limit = count($sellsA);

   $_SESSION['fields'] = $fields;
    $_SESSION['query'] =  $query1;
    $_SESSION['query2'] = $query2;
    $_SESSION['periodos'] = $_POST['date'];


    foreach($fields[0] as $key=>$value)
    {
      $tmp = explode(",",$value);
      if(isset($cache[$tmp[0]]))
      {
        $total = count($cache($tmp[0]));
        $cache[$tmp[0]][$total] = $tmp[1];
      }else
      {
        $cache[$tmp[0]][0] = $tmp[1];
      }
      echo $value.",";
    }
    require_once $this->getView();
    }

  }

?>