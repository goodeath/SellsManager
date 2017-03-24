<?php

  ##########################################
  ##                                      ##
  ##  Created by Alex Anderson            ##
  ##  Date: 06/05/2015                    ##
  ##  Contact: alexandersonbm@hotmail.com ##
  ##                                      ##
  ##########################################

  namespace controller\inative;

  class mainView extends main
  {

    private $limit;

    public function viewInative()
    {
      session_start();
      # Array of fields
      $fields = array($_POST['campos'],$_POST['campos2']);
      # Date
      $date = $_POST['date'];
      # Start class
      $this->setFielda($fields);
      # Table names
      $nameFilter = $this->name;
      # Set minimum limit
      $this->setLimit($_POST['limit']);
      # Get report
      $inativeData = $this->inative($date);
  # Until six months
  #$item = $inativeData[0];

  $end = explode(",",$date)[0];
  $x = date("n",strtotime($end));
  $y = 0;
  //Count items of each period
  foreach($inativeData as $key=>$value)
  {


     $inatives[$y][0] = count($value);
      $inatives[$y][1] = $key;
     # $inatives[$y][2] = $key2-$end;
     ++$y;

  }




  ###########################################
  ##             Session                   ##
  ###########################################

  $_SESSION['campos'] = $fields;
  $_SESSION['datas'] = $date;
  $_SESSION['campo'] = $nameFilter;
  $_SESSION['limit'] = $_POST['limit'];


##
  ##End##
##
    require_once $this->getView();
    }


  }


//# Register items that already were searched
        //$excludes = '';
  //$query = $and = $v = null;
        //If exists items searched
        // if($excludes != '')
        // {
        //   //Remove last comma
        //   $excludea = substr($excludes,0,-1);

        //   //Update query;
        //   $query = "$tableField not in($excludea)"; $and = "and";
        // }
        // else{$query = $and = $v = null;}

          //Register items that already were searched
    #      $excludes .= "'".$valor[1]."',";
?>
