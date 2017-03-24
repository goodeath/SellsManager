<?php
  
  ##########################################
  ##                                      ##
  ##  Created by Alex Anderson            ##
  ##  Date: 06/05/2015                    ##
  ##  Contact: alexandersonbm@hotmail.com ##
  ##                                      ##
  ##########################################
  
  namespace controller\trend;

  class main extends \controller\field
  {
    protected $item;
    protected $item2;
    public $total;
    public $lastDate;
    public $firstDate;
    protected $period;
    
    public function __construct(){$this->db = new \controller\serviceDB($this);}
    
    public function old_cons(array $campos, $date) {

      # Group fields by type
      $fields = $this->separate($campos[0]);

      # Get the query based in filters
      $this->checkFields($fields);
      # If exists two type fields, check table
      $this->checkTable($campos[1]);
      $array = explode(',',$date);
      $this->firstDate = strtotime($array[0]);
      $this->lastDate = strtotime($array[1]);
      $this->period = \controller\period::getPeriod($date);
    }
	
  
  public function trend()
  {
    ###########################################
    ##              Data                     ##
    ###########################################
    $query = $this->getQuery();
    $tableField = $this->tabla;
    $typeData = $this->field;
    $period = $this->period;

    ###########################################
    ##           Retrieve Data               ##
    ###########################################

    $clientes = $this->getFirstClients();

    $completeList = $this->getLastClients();
    
    //Initialize var
    $dias = '';
    
    //Get how many days there is
    foreach($period as $key=>$value)
    {
      $temp = explode(',',$value);
      $dias += date("d",strtotime($temp[1]));
    }
    
    $x = 0;
    $med = round($dias/30.4,1);
 echo $dias;
    foreach($clientes as $key=>$value)
    {
      $control = $x;
      
      foreach($completeList as $key2=>$value2 )
      {
        if($key == $key2)
        {
          //Calculates how many month shopping of selected period
          $comprasMes = round($value[0]/$med,2);
          #if($value[1] == 0 || $value[0] == 0){continue;}
          //Calculates value shopping at month at selected period.
          $valorMes = $value[1]/$med;
          
          //Calculates how many month shopping of a previous period
          $comprasMes2 = round(($value2[0]/365)*30,2);
          
          //Calculates value shopping at month at a previous period
          $valorMes2 = ($value2[1]/365)*30;
          if($valorMes2 == 0){continue;}
          ###Assings values###
          $registros[$key][0] = array($value[0],$valorMes,$comprasMes);
          $registros[$key][1] = array($comprasMes2,$valorMes2);
          $variation = (($valorMes*100)/$valorMes2-100);
          $registros[$key][2] = $variation;
          ###Assings values###
          
          ++$x;
        }
      }
       /*
      trend returned index 0 
          $value[0][0] - Total bought
          $value[1][0] - Historical media sells
          $value[1][1] - Historical media value
          $value[0][0] - Current media sells
          $value[0][1] - Current media value
          $value[2] - Variation
          aa
      */
      
      //If nothing finded
      if($control == $x)
      {
        //Calculates how many month shopping of selected period
        $comprasMes = round(($value[0]/$dias)*30,2);
        
        //Calculates value shopping at month at selected period.
        $valorMes = ($value[1]/$dias)*30;
        
        ###Assings values###
        $registros[$key][0] = array($comprasMes,$valorMes,$comprasMes);
        $registros[$key][1] = array("Sem Registro","Sem Registro",
        "Sem Registro","Sem Registro");
        $registros[$key][2] = "Sem Registro";
        ###Assings values###

      }
    }
      
    


    //This foreach makes invert search for have sure that
    //all items were included
    foreach($completeList as $key=>$value)
    {
      //Check if exists the key
      if(!array_key_exists($key,$clientes))
      {
        //Calculates how many month shopping of a previous period
        $comprasMes = ($value[0]/$dias)*30;
        
        //Calculates value shopping at month at a previous period
        $valorMes = ($value[1]/$dias)*30;
        
        ###Assings values###
        $registros[$key][0] = array("Sem Registro","Sem Registro",
        "Sem Registro","Sem Registro");
        $registros[$key][1] = array($comprasMes,$valorMes,$comprasMes);
        $registros[$key][2] = "Sem Registro";
        ###Assings values###
      }
    }

    foreach($registros as $key=>$value)
    {

      if($value[2] == "Sem Registro")
      {
        //Products that not have found registers
        $lista['noHistory'][$key] = $value; 
      }
      elseif($value[2] < -30)
      {
        //Products below average
        $lista['less'][$key] = $value; 
      }
      elseif($value[2] > 30)
      {
        //Products up average
        $lista['more'][$key] = $value;
      }
      else
      {
        //Products in average
        $lista['equal'][$key] = $value;
      }
    } 
    $this->dias = round($dias/30);



   
    return array($lista,$registros);
  }
  
  

  //////////////////////////////////////////////////////////////////////
  //////////////////////////////////////////////////////////////////////
  //////////////////////////////////////////////////////////////////////
   
    
  ############################################
  ##            getFirstClients             ##
  ##                                        ##
  ##  Get client's data in selected period  ##
  ##                                        ##
  ############################################  
  private function getFirstClients()
  {
    $query = $this->getQuery();
    
    $tableField = $this->tabla;
    $typeData = $this->field;
    
   
    //First date in period
    $firstDate = $this->firstDate;
    
    //Last date in period
    $lastDate = $this->lastDate;
    
    //Starts date
    $ini = date("Y-m-d",$firstDate);

    //End date
    $end = date("Y-m-d",$lastDate);
    
    $this->db->setField("*,$typeData");
    $q = $this->db->read("$query
    periodo between '$ini' and '$end' group by N,$tableField");
 
    
    foreach($q as $key=>$row)
    {
      //Check if $clientes is set and if exists a key
      if(isset($clientes) && array_key_exists($row["$tableField"],$clientes))
      {
        //Shopping quantity
        ++$clientes[$row["$tableField"]][0];
        
        //Value total of shopping
        $clientes[$row["$tableField"]][1] += $row["$typeData"];
      }
      else
      {
        //Assings the item, and your value
        $clientes[$row["$tableField"]] = array(1,$row["$typeData"]);
      }
    }

    return $clientes;
    
  }
  
  
  //////////////////////////////////////////////////////////////////////
  //////////////////////////////////////////////////////////////////////
  //////////////////////////////////////////////////////////////////////
  
  
  ############################################
  ##            getLastClients              ##
  ##                                        ##
  ##  Get client's data in previous period  ##
  ##                                        ##
  ############################################
  /* Get a year ago until the day */
  private function getLastClients()
  {
    $query = $this->getQuery();
    $tableField = $this->tabla;
    $typeData = $this->field;
    
    //First date in period
    $firstDate = $this->firstDate;

    //Starts date
    $ini = date("Y-m-d",$firstDate);

    //Get one year ago
    $previouYear = date("Y",strtotime($ini))-1;
    
    //Get one year ago
    $endo = "$previouYear-".date("m-d",strtotime($ini));

    $this->db->setField("*,$typeData");
    $q = $this->db->read(" $query
    periodo between '$endo' and '$ini' group by N,$tableField");



    foreach($q as $key=>$rowa)
    {
      if(isset($completeList) && array_key_exists($rowa["$tableField"],$completeList))
      {
        //Shopping quantity
        ++$completeList[$rowa["$tableField"]][0];
        
        //Value total of shopping
        $completeList[$rowa["$tableField"]][1] += $rowa["$typeData"];
      }
      else
      {
        //Assings the item, and your value
        $completeList[$rowa["$tableField"]] = array(1,$rowa["$typeData"]);
      }
    }
    
    return $completeList;
  }
  

}

?>