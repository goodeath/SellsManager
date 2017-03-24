<?php
  
  ##########################################
  ##                                      ##
  ##  Created by Alex Anderson            ##
  ##  Date: 06/05/2015                    ##
  ##  Contact: alexandersonbm@hotmail.com ##
  ##                                      ##
  ##########################################
  
  namespace controller\fotografe;
  
  class main extends \controller\field
  {
    protected $item;
    protected $item2;
    private $debug = '';

    
    public function __construct(){$this->db = new \controller\serviceDB($this);}
	
     public function old_cons($campos,$periods) {
      # Group fields by type
      $fields = $this->separate($campos[0]);
      
      # Get the query based in filters
      $this->checkFields($fields);
      # If exists two type fields, check table
      $this->checkTable($campos[1]);

      //Items of first period
      $this->item = $this->getData($periods[0]);
      
      //Items of second periond
      $this->item2 = $this->getData($periods[1]);

}
    
    ############################################
    ##              fotografe                 ##
    ##                                        ##
    ##This function is the main, and executes ##
    ##all procedures to return the data       ##
    ##                                        ##
    ############################################
    public function fotografe()
    {
      //Initialize variavel     
      $contagem = array(array(0,0),array(0,0));
      
      //Group clientes with your respectives values
      $clientes = $this->groupClients();

      $e = $r = 0;
      
      
      //Search $clientes
      foreach($clientes as $key=>$value)
      {
        //Subtract current period value of previous period values
        $dif = ($value[0])-($value[1]);
        
        //Check value of $dif ; Here have clients that evolved.
        if($dif >= 0)
        {
          // Increase the counter of evolution
          $contagem[0][1] += 1; 
          
          //Sum evolution value
          $contagem[1][1] += $dif;
          
          //Client's name
          $evoCliente[$e][0] = $key;
          
          //Newest period value
          $evoCliente[$e][1] = $value[0];
          
          //Previous period value
          $evoCliente[$e][2] = $value[1];
          
          //Get the next index
          $e  = count($evoCliente);
        }
        else
        {
          // Increase the counter of regression
          $contagem[0][0] += 1;
          
          //Subtract regression value; Note: This is a negative value
          $contagem[1][0] += $dif;
          
          //Client's name
          $regCliente[$r][0] = $key;
          
          //Newest period value
          $regCliente[$r][1] = $value[0];
          
          //Previous period value
          $regCliente[$r][2] = $value[1];
          
          //Get the next index
          $r = count($regCliente);
        }
      }
      
      //If the function find nothing, then assigns 'zero' values
      !isset($evoCliente) ? $evoCliente = array(0) : '';
      !isset($regCliente) ? $evoCliente = array(0) : '';
      
      $name = $this->name;
      $this->debug .= "$name que evoluiram: $e <br /> $name que regrediram: $r";
      
      $debug = $this->debug;
      //echo "<script>var myWindow = window.open('', 'MsgWindow', 'width=600, height=300');
      //myWindow.document.write('$debug')</script>";
      return array($contagem,$evoCliente,$regCliente);
    }
    
    
    ############################################
    ##              groupClients              ##
    ##                                        ##
    ##This function search a array of items   ##
    ##comparing your names for find equal va- ##
    ##lues. If find, group values of periods  ##
    ##in same key.                            ##
    ##                                        ##
    ############################################
    private function groupClients()
    {
      //Items for first period
      $first = $this->item; 
      
      
      //Items for second period
      $second = $this->item2 ;

      
      $x =-1;
      
      ####DEBUG VARS####
      $conta1 =0;
      $conta2 = 0;
      $equal = 0;
      ####DEBUG VARS####
      
      //Compare and group data by item.
      foreach($first as $key)
      {
        //Assigns the value of $x for $ini
        $ini = $x;
        
        foreach($second as $key2)
        { 
          //If find peoples in $second equal in $first
          if($key[1] == $key2[1])
          {
            //Idenfity the found
            ++$x;
            
            #########DEBUG########
            $conta1 += $key[0]; ##
            $conta2 += $key2[0];##
            ++ $equal;          ##
            #########DEBUG########
            
            // Register value for current period
            $clientes[$key[1]][0] = $key[0]; 
            
            // Register value for previous value
            $clientes[$key[1]][1] = $key2[0];
          }
        }
        
        //Check if $ini have the same value that in starts 
        //Indicates that not found any client
        if($ini == $x)
        {
          //Increase the counter
          ++$x;
          $conta1 += $key[0];
          // Register value for current period
          $clientes[$key[1]][0] = $key[0];
          
          // Indicates that no have values for previous periods
          $clientes[$key[1]][1] = 0;
        }
      }
      
      //This foreach makes invert search for have sure that
      //all items were included
      foreach($second as $key)
      {
        //Chech if exists the key
        if(!array_key_exists($key[1],$clientes))
        {
          //Indicates that no have values for newest period
          $clientes[$key[1]][0] = 0;
          $conta2 += $key[0];
          // Register value for previous periods
          $clientes[$key[1]][1] = $key[0];
        }
      }

      ############################
      ##         Debug          ##
      ############################
      
      $rest = $conta1-$conta2;
      $cities1 = count($first);
      $cities2 = count($second);
      $name = $this->name;
      
      

      $this->debug .= "$name iguais: $equal <br /> $name do 1° período: $cities1 <br /> $name do 2° período: $cities2 <br /> Valor Total 1° Periodo: R$ $conta1 <br /> Valor Total  2° Período: R$ $conta2 <br />   Diferença: R$ $rest  <br />";
      ############################
      ##         Debug          ##
      ############################
      
      return $clientes;
      
    }
   
    ############################################
    ##              getData                   ##
    ##                                        ##
    ##    Retrive all data to exhibition      ##
    ##                                        ##
    ############################################
   
    public function getData($periodos)
    {
      //Table column selected
      $tableField = $this->tabla;
      
      //Conditions for query
      $query = $this->getQuery();
      
      $x = 0;
      
      $value = $periodos;
      $sum = $this->field;

        //Separe period
        $temp = explode(',',$value);
       
        //First date
        $ini = date("Y-m-d",strtotime($temp[0]));
        
        //Last date
        $end = date("Y-m-d",strtotime($temp[1]));
        
        $this->db->setField("$sum,$tableField");
        //Executes query in database
        $q = $this->db->read(" $query periodo between '$ini' and '$end' group by $tableField");
        
        //Register values
        foreach($q as $key=>$valor)
        {
          $item[$x][0] = round($valor[$sum],2);
          $item[$x][1] = $valor[$tableField];
          ++$x;
        }
        
      ############################
      ##         Debug          ##
      ############################
      $this->debug .= "Periodos: $periodos <br />";
      ############################
      ##         Debug          ##
      ############################
      
      
      return $item;
    }
    

  }

?>