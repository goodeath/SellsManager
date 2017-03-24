<?php
  
  ##########################################
  ##                                      ##
  ##  Created by Alex Anderson            ##
  ##  Date: 06/05/2015                    ##
  ##  Contact: alexandersonbm@hotmail.com ##
  ##                                      ##
  ##########################################
  
  namespace controller\ranking;

  class main extends \controller\field
  {
    protected $item;
    protected $item2;
    public $total;
    
    public function __construct()
    {
      $this->db = new \controller\serviceDB($this);
    }
	
    public function old_cons($campos) {
      # Group fields by type
      $fields = $this->separate($campos[0]);
      # Get the query based in filters
      $this->checkFields($fields);
      # If exists two type fields, check table
      $this->checkTable($campos[1]);
 
}
    
    public function ranking($date)
    {
      ###########################################
      ##              Data                     ##
      ###########################################
      
      //Conditions to query in database
      $query = $this->getQuery();

      //Table column
      $tableField = $this->tabla;
      
      //Period
      $data = explode(",",$date);
      
      //Counter
      $x = 0;
      
      //First date of period
      $ini = $data[0];
      
      //Last date of period
      $end = $data[1];
      $this->db->setField("sum(VALOR_TOTAL) as total");
      //Query total value of period
      $row = $this->db->read("$query periodo between '$ini' and '$end'")[0];
      
      
      //Stores total value
      $this->total = round($row['total'],2);
      $total = $this->total;
      
      $this->db->setField("sum(VALOR_TOTAL) as total,$tableField");
      //Total value group by field
      $q = $this->db->read("$query 
      periodo between '$ini' and '$end' group by $tableField order by sum(VALOR_TOTAL) desc");
              
      foreach($q as $key=>$valor){
        
      
        //Total value
        $item[$x][0] = round($valor['total'],2);
        
        //Name of item
        $item[$x][1] = $valor["$tableField"];
        
        //Percent
        $item[$x][2] = round(($valor['total']/$total)*100,2);
        
        //Counter
        ++$x;
      }
      
      return $item;
    }
    
  }

?>