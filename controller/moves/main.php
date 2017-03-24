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
  define("QNT_MONTH_TO_BE_ACTIVE",3);
  class main extends \controller\field
  {
    public $query1;
    public $query2;
    public $periodos;
    
    public function __construct($routes = null){
      $this->db = new \controller\serviceDB($this);
      
    }
	
    public function setFielda($campos) {
      # Group fields by type
      $fields = $this->separate($campos[0]);

      # Get the query based in filters
      $this->checkFields($fields);
      # If exists two type fields, check table
      $this->checkTable($campos[1]);
      # Check type of data
      $this->checkType();
}
    
    public function moves($periodos)
    {
      ###########################################
      ##              Data                     ##
      ###########################################
        
      $tableField = $this->tabla;
      $query = $this->query1;
      
      ###########################################
      ##           Retrieve Data               ##
      ###########################################

      # Items that don't if in any category don't will be show

      //how many months there is
      $x = 0;
      
      foreach($periodos as $key=>$value)
      { 
        ++$x;
        //Separate periods
        $temp = explode(',',$value);
        
        //Firts date
        $ini = date("Y-m-d",strtotime($temp[0]));
        $mo = date("n",strtotime($temp[0]));
        //Last date
        $end = date("Y-m-d",strtotime($temp[1]));
        $this->db->setField("sum(VALOR_TOTAL) as total,$tableField as campo");
        
        //Query at database
        $q = $this->db->read("$query periodo between '$ini' and '$end' group by $tableField");
        
        foreach($q as $key=>$v){
          # Value total
          isset($clientes[$v['campo']][0]) ? $clientes[$v['campo']][0] += $v['total'] :
          $clientes[$v['campo']][0] = $v['total'];
          
          isset($clientes[$v['campo']][1]) ? $clientes[$v['campo']][1] .= $mo.',' :
          $clientes[$v['campo']][1] = $mo.',';
          
          
        }
        $montz = date('n',strtotime($temp[1]));
        
      }
      
      //Get first date
      $ini = explode(",",$periodos[0]);
      $ini = date("Y-m-d",strtotime($ini[0]));

      ///////////////////////////////////////////////

      ####################
      ##NOVOS NOVOS NOVOS#
      ####################
      $newItems = $this->newItems($query,$ini,$end,$tableField);
      $lista['novos'] = $newItems['novos'];

      
    

      //Count how many months was selected
      $todos = count($periodos);
     #echo "<pre>"; print_r($clientes); echo "</pre>"; 
     # echo $montz;
      foreach($clientes as $key=>$valor)
      {
        

        //Separate the months
        $months = explode(",",$valor[1]);
         //Count at which months the item appeared
        $months = array_slice(array_reverse($months),1);
        $monthQuant = count($months);
        
        # The last month that the item was bought
        $first = $months[0];
        
        
        # Penultimate month that item was bought
        $second = (isset($months[1])) ? $months[1] : 0;

        
        $re1 = $montz - $first;

        $re2 = $montz - $second;
        
        //Round value of item 
        $value = round($valor[0],2);
        if(isset($newItems['inativo'][$key])){unset($newItems['inativo'][$key]);}
        if($monthQuant == $todos)
        {
          
          $lista['constante'][$key] = $value;
          
        }
        //If the item not was bought from 3 months and now was purchased
        //then it's was recovered
        elseif($re1 < QNT_MONTH_TO_BE_ACTIVE && $re2 >= 3)
        {
           $lista['Recuperados'][$key] = $value;
           
        }
        
        //If not have shopping in three months then the item is inative
        else if($re1 >= 3)
        {
          $lista['inativo'][$key] = $value;
        }
        
        //If the item was purchased all the months selected, then it's is constant
        

      }
     #    print_R($newItems['inativo']);
      
      !isset($lista['Recuperados']) ? $lista['Recuperados'] = array() : '';
      !isset($lista['inativo']) ? $lista['inativo'] = array() : '';
      !isset($lista['constante']) ? $lista['constante'] = array() : '';
      #$newItems['inativo'] = array_values($newItems['inativo']);
      # echo count($lista['inativo'])."<br />".count($newItems['inativo']);
      $lista['inativo'] = array_merge($lista['inativo'],$newItems['inativo']);
     
      ksort($lista['inativo']);
      return $lista;
    }
    
    public function newItems($query,$ini,$end,$tableField)
    {

      $this->db->setField("sum(VALOR_TOTAL) as total,$tableField as campo");
      //Query at database
      $qe = $this->db->read("$query periodo between '$ini' and '$end' group by $tableField");
             
      foreach($qe as $key => $v){
        $parcialList[$v['campo']] = $v['total'];
      }
  
      //Query at database
      $allPrevious = $this->db->read("$query  periodo between '0000-0-0' and '$ini' group by $tableField");
    #  ECHO "$query periodo between '$ini' and '$end' group by $tableField --";echo count($parcialList)."<br />";
      #echo "$query  periodo between '0000-0-0' and '$end' group by $tableField";echo count($allPrevious)."<br />";
   
        $y=0; $string = '';

       //If $allPrevious return rows
        if(count($allPrevious) > 0)
        { 
            foreach($allPrevious as $key=>$v){
              $outList[$v['campo']] = $v['total'];
            }
        #  echo count($outList)."outlist<br />";

          foreach($parcialList as $key=>$value)
          {
            if(!isset($outList[$key])){$lista['novos'][$key] = round($value,2);}
            else{$lista['inativo'][$key] = round($value,2);}
          }
           foreach($outList as $key=>$value)
          {
            if(!isset($lista['novos'][$key])){$lista['inativo'][$key] = round($value,2);}
          }

/*
          foreach($outList as $key=>$value)
          {  
            $control = $y;  
            foreach($parcialList as $key2=>$value2)
            {
              if($key == $key2){++$y;}

            }       
            ($control == $y) ? $lista['novos'][$key] = round($value,2) : $lista['inativo'][$key] = round($value,2);
            #$string .= "'{$key}',";
            //If not exists a value before of selected period, then is new
           # if(!isset($parcialList[$key])){}
          }
*/
        }
        else
        {
          # If no one new, create a empty array
          $lista['novos'] = array();
        }
       # echo $string;
        #echo "<Br />Novos".count($lista['novos'])."<Br />Inativos".count($lista['inativo']);
      #  $a = array_merge($lista['novos'],$lista['inativo']);
      # $a = array_keys($a);
        #echo "produtos in ({$a})";
        return $lista;
    }

    ########################################
    ##       Get and separe periods       ## 
    ########################################
    
    public function  getPeriod($data)
    {
      $periodo = period::getPeriod($data);
      $this->periodos = $periodo;
    }
  }

?>