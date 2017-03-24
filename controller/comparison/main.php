<?php
  
  ##########################################
  ##                                      ##
  ##  Created by Alex Anderson            ##
  ##  Date: 10/05/2015                    ##
  ##  Contact: alexandersonbm@hotmail.com ##
  ##                                      ##
  ##########################################
  
  namespace controller\comparison;
  
  class main extends \controller\field{
    
    private $query;  # Query
    public $periodos; # Periods
    
    #######################
    ## ~~ Constructor ~~ ##
    #######################
    
    public function __construct($routes = null){
      $this->db = new \controller\serviceDB($this);

    }
    
    #######################
    ##    SET METHODS    ##
    #######################
    
    /*
     * @Name: setQuery
     * @Desc: Assigns a query to search in db.
     * @Args: {String} $query
     */
    
    private function setQuery($query){
      if(isset($this->query[0])) 
        $this->query[1] = $query;
      else
        $this->query[0] = $query;
    }
    
    #######################
    ##    GET METHODS    ##
    #######################
    
    /*
     * @Name: setQuery
     * @Desc: Assigns a query to search in db.
     * @Args: {String} $query
     */
    
    public function getQuery($i){
      return $this->query[$i];
    }

    
    #########################
    ##    OTHER METHODS    ##
    #########################
    
    /*
     * @Name: setFielda
     * @Desc: Separates the fields, generate queries and assigns its.
     * @Args: {Array} $campos
     */
    
	public function setFielda(array $campos = null){
      # If $campos is null
      if(!isset($campos)) exit("Nenhum campo para avaliação foi escolhido");
      # Group fields by type
      $fields = $this->separate($campos[0]);
      # Group fields by type
      $fields2 = $this->separate($campos[1]);
      //Get the query based in filters
      $this->setQuery($this->checkFields($fields));
      $this->setQuery($this->checkFields($fields2));
    }
    
    
    /*
     * @Name : comparison
     * @Desc: Generates a comparison graphic
     * @Arguments: {}
     */
    
    
    public function comparison(){
      # Initialize variable
      $x =0 ;
      # Get the first query
      $query1 = $this->getQuery(0);
      # Get the second query
      $query2 = $this->getQuery(1);

      //Get periods
      $periodos = $this->periodos;
      
      foreach($periodos as $key=>$value)
      {
        //Separate period
        $temp = explode(',',$value);
        
        //First date
        $ini = date("Y-m-d",strtotime($temp[0]));
        
        //Second date
        $end = date("Y-m-d",strtotime($temp[1]));
        
        $this->db->setField("sum(VALOR_TOTAL) as total");
        //Query first group value
        $valor = $this->db->read("$query1 periodo between '$ini' and '$end'")[0];

        $valor2 = $this->db->read("$query2 periodo between '$ini' and '$end'")[0];
        
        
        //Store period
        $sells[$x][0] = $ini.' , '.$end;
        
        //check if $valor[0] have a value and assigns
        $sells[$x][1] = $valor["total"] == "" ? 0 : $valor["total"];

        //check if $valor2[0] have a value and assigns
        $sellsA[$x][1] = $valor2["total"] == "" ? 0 : $valor2["total"];
        
        //Increase counter
        ++$x;
      }
          
      
      $d = $this->first_sells($sells);
      $valores = $this->separateValues($sells);#$d[0];
      $string = $d[1];
      $valores2 = $this->separateValues($sellsA);
      
      
      return array($sells,$sellsA,$string,$valores,$valores2);
    }
    
    public function separateValues($sells) {
      $x = count($sells)-1;
      $z = 0;
      $values = '';
      foreach($sells as $key)
      {
        //Round value
        $reais2 = round($key[1],0);
        
        //List with values
        $values .= "'$reais2'"; 
        
        //Add comma or no
        $z < $x ? $values .= ',' : '';
        
        //Increase counter
        ++$z;
      }
      return $values;
    }
    
    public function first_sells($sells) {
      
      $x = count($sells)-1;
      $z = 0;
      $valores = $string =  '';
      foreach($sells as $key)
      {
        
        //Generates a list with name months
        $string .= "'$key[0]'";
        
        //Add comma or no
        $z < $x ? $string .= ',' : '';
        //Increase counter
        ++$z;
      }
      return [$valores,$string];
      
    }
   

  }
