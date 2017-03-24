<?php



  namespace controller;
  //Query to database, max execution time. 0 = no limit;
  ini_set('max_execution_time', 0);
class fieldView extends field
{
    public function viewRefresh(){
      $this->refresh_sells();
      $this->refreshCity();
    }

    public function viewVendasdia()
    {

    	$a = $this->refreshVen();

      $current = $a[1];
      # Day Goal
      $daygoal = $a[5];


      if(isset($_GET['vendedor'])){
        $goal = $a[0]/6;
        $dgoal = $daygoal[0]/6;
      }else{
        $goal = $a[0] ;
        $dgoal = $daygoal[0];
      }

      $dsum = $daygoal[1];
      $rest2 = $dgoal - $dsum;

      $rest = $goal - $current;
      $string = $a[2];
      $c = $a[3];
      $seg = '';
      $toal = 0;
      $serie = '';
      foreach($c as $key=>$value)
      {
        $seg .= "'$key',";
        $toal += $value;
        $serie .= "$value,";
      }
      $seg = substr($seg, 0,-1);
      $serie = substr($serie, 0,-1);



      $vendedores = $a[4];
      $menus = '';
      foreach($vendedores as $key=>$value)
      {
        $idx = strpos($key," ");
        $keya = substr($key,0,$idx);
        $menus .= "<h4>{$keya}</h4>
        <div class='tabbody'>
          <object data='/vendas/bi/geral/?vendedor={$key}''></object>
        </div>";
      }

      $tend = $a[6];
      $lbls ='';
      $lbls2 ='';

      $tendv = [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30];

      $b = array_map(function($n){return 15000;/*return $n*450000/30;*/},$tendv);

      $ab = implode(",", $tendv);
      $ac = implode(",", $b);
      $y = 1;
      ksort($tend);
      

      foreach($tend as $key=>$value)
      {
        while($key != $y)
        {
          $lbls .= "$y,";
          $lbls2 .= "0,";
          ++$y;
          if($y >= date("d")) break;

        }
        $lbls .= "$key,";
        $lbls2 .=  "$value,";
        ++$y;

      }
      $lbls = substr($lbls,0,-1);
      $lbls2 = substr($lbls2,0,-1);

    	require_once $this->getView();

    }

    public function viewVendedor()
    {

    }

}


?>
