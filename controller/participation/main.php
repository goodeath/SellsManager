<?php
  
  ##########################################
  ##                                      ##
  ##  Created by Alex Anderson            ##
  ##  Date: 06/05/2015                    ##
  ##  Contact: alexandersonbm@hotmail.com ##
  ##                                      ##
  ##########################################
  namespace controller\participation;

  class main extends \controller\field
  {
    public $periodos;
    protected $query1;
    protected $query2;
    public $sells;
    public $sells2;
    
    public function __construct()
    {
      $this->db = new \controller\serviceDB($this); 
      
    }
	public function setFielda($campos = null){
      if(!isset($campos)) exit("Nenhum campo para avaliação foi escolhido");
     
      //Group fields by type
      $fields = $this->separate($campos[0]);
      $fields2 = $this->separate($campos[1]);
      //Get the query based in filters
      $this->query1 = $this->checkFields($fields);
      $this->query2 = $this->checkFields($fields2);
    }
    
    public function participation($periodos)
    {
      //first query
      $query = $this->query1;
      
      //second query
      $query2 = $this->query2;
      
      $x =0;
      
      //get periods
      $periodos = \controller\period::getPeriod($periodos);
      
      foreach($periodos as $key=>$value)
      {
        //Separate period
        $temp = explode(',',$value);
        
        //Get first date
        $ini = date("Y-m-d",strtotime($temp[0]));
        
        //Get second date
        $end = date("Y-m-d",strtotime($temp[1]));
        $this->db->setField("sum(VALOR_TOTAL) as total");
        //Query first data
        $valor = $this->db->read("$query $query2 periodo between '$ini' and '$end'")[0]; 

        //Query second data
        $valor2 = $this->db->read("$query2 periodo between '$ini' and '$end'")[0];

    
        //Store period
        $sells[$x][0] = $ini.' , '.$end;
        
        //check if $valor[0] have a value and assigns
        $sells[$x][1] = $valor['total'] == "" ?  0 : $valor['total'];
        
        //check if $valor2[0] have a value and assigns
        $sellsA[$x][1] = $valor2['total'] == ""  ?  0 : $valor2['total'];
        
        //Increase counter
        ++$x;
      }

      //Initialize vars
      $string = $string2 = $valores = $valores2 = '';

      $x = count($sells)-1;
      $z = 0;
     
      foreach($sells as $key)
      {
        //Round value
        $reais = round($key[1],2);
        
        //Generates a list with name months
        $string .= "'$key[0]'"; 
        
        //Add comma or no
        $z < $x ? $string .= ',' : '';
        
        //List with values
        $valores .= "'$reais'"; 
        
        //Add comma or no
        $z < $x ? $valores .= ',' : '';
        
        //Increase counter
        ++$z;
      }
      
      $x = count($sellsA)-1;
      $z = 0;
      
      foreach($sellsA as $key)
      {
        //Round value
        $reais2 = round($key[1],2);
        
        //List with values
        $valores2 .= "$reais2";
        
        //Add comma or no
        $z < $x ? $valores2 .= ',' : '';
        
        //Increase counter
        ++$z;
      }
      
      $this->sells = $sells;
      $this->sells2 = $sellsA;
      
      return array($string,$valores,$valores2);
    }
    
    ########################################
    ##       Get and separe periods       ## 
    ########################################
    
    public function  getPeriod($date)
    {
      $periodos = period::getPeriod($date);
      $this->periodos = $periodos;
      return $periodos;
    }
    
    public function participation_view() {
        ###########################################
  ##              Data                     ##
  ###########################################
  
  //Array of fields
  $fields = [$_POST['campos'],$_POST['campos2']];
  $date = $_POST['date'];
  
  $this->setFielda($fields);
  $data = $this->participation($date);
  
  $string = $data[0];
  $valores = $data[1];
  $valores2 = $data[2];

    $_SESSION['fields'] =  $fields;
    $_SESSION['date'] = $date;
      require_once $this->getView();
    }
  }

?>