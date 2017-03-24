<?php
  
  ##########################################
  ##                                      ##
  ##  Created by Alex Anderson - G00D34TH ##
  ##  Date: 06/05/2015                    ##
  ##  Contact: alexandersonbm@hotmail.com ##
  ##                                      ##
  ##########################################
  
  namespace controller\evolution;
  
  class main extends \controller\field
  { 
    public $periodos;

    public function __construct(){$this->db = new \controller\serviceDB($this);}
    
    public function setFielda($campos = null)
    {
      if(!isset($campos)) exit("Nenhum campo para avaliação foi escolhido");
      parent::__construct($campos);
    }
    
    /*
     * @Name: Evolution
     * @Description: Gerenates graphics of evolution
     * @Arguments: {}
     */
    
    public function evolution()
    {
      # Get periods
      $periodos = $this->periodos;
      # Get query
      $query = $this->getQuery();
      # Get db
      $this->db->setField("sum(VALOR_TOTAL) as total");
      # Get sells of current chosen year
      $sells = $this->getValues($periodos,$query,"currentYear");
      # Get sells of current chosen year ago
      $sellsA = $this->getValues($periodos,$query,"oneYearAgo");
      # Return an array with all data  
      return [$sells,$sellsA]; 
    }

    /*
     * @Name: getValues
     * @Desc: Get sells of current chosen year
     */
    
    private function getValues($periodos,$query,$type)
    {
      if($type == "currentYear"): 
        $y = 0; $z = 1;
      else:
        $y = 2; $z = 3;
      endif;

      # Initialize counter
      $x = 0;
      # :: Foreach :: #
      foreach($periodos as $key=>$value)
      {
        # Separate periods
        $date = $this->separate_period($value);
        # First date
        $ini = $date[$y];
        # Last date
        $end = $date[$z];
        # Query current period
        $q = $this->db->read("$query periodo between '{$ini}' and '{$end}'")[0];
        # Format date
        $ini = date("d/m/Y",strtotime($ini));
        # Format date
        $end = date("d/m/Y",strtotime($end));
        # Store period
        $sells[$x][0] = "'$ini ~ $end'";
        # check if $q['total'] have a value and assigns
        $sells[$x][1] = $q['total'] == "" ? 0 : round($q['total'],2);
        # Increase counter
        ++$x;
      }
      return $sells;
    }
        
    
    public function separate_period($value)
    {
      # Separate period
      $temp = explode(',',$value);
      # First date
      $date[0] = date("Y-m-d",strtotime($temp[0]));
      # Second date
      $date[1] = date("Y-m-d",strtotime($temp[1]));

      //Get a year ago
      $iniA =  strtotime("-1 Year",strtotime($date[0]));

      //Starts date a year ago
      $date[2] = date("Y-m-d",$iniA);

      //End date a year ago
      $endA = strtotime("-1 Year",strtotime($date[1]));
      $date[3] = date("Y-m-d",$endA);
      
      return $date;
    }  
  }
?>