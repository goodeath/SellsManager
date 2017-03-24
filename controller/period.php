<?php
namespace controller;
class period
{

  //Format: FIELD-VALUE
  public static function getPeriod($date)
  { 
    # Separate date
    $data = explode(",",$date);
    # Get first date
    $firstDate = $data[0];
    # Month's day of first date
    $firstDay =date("j-n-Y",strtotime($firstDate));
    # Last month's day
    $lastDay = date("t-n-Y",strtotime($firstDate));
    # First period
    $periodos[0] = $firstDay.','.$lastDay;
    
    $z = 1;
    
    $current=0;

    #Define the last date
    $dataMax = strtotime($data[1]);
    # Get first month
    $month = date("n",strtotime($data[0]));
    # Get first year
    $year = date("Y", strtotime($data[0]));
    # While the current date is less than max date, then continue
    while($current <= $dataMax){
    # Get next month
    $month = $month+1;
    # First date's period
    $p1 = "1-$month-$year"; //2014-02-01
    # Last day of date's period
    $p2D = date("t",strtotime($p1)); // 28
    # Get second date's period
    $p2 = "$p2D-$month-$year";
    # 
    $limit1 = strtotime($p1);
    # Check if first date of this period is bigger than max date
    if( $limit1 > $dataMax){
      break;
    }
    $periodos[$z] = "$p1,$p2";
    if($month >= 12)
    {
     $month = 0;
     $year = $year+1;
    }
    
    $current = strtotime($p2);
    if($current >= $dataMax)
    {
      $p2 = date("j-n-Y",$dataMax); 
      $periodos[$z] = "$p1,$p2";
      break;
    }
    ++$z;
  }
  return $periodos;
  $x = 0;
  
  }

} 


?>