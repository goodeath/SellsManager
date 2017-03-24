<?php
  namespace controller;
  # Insert initialize php config
  require_once $_SERVER['DOCUMENT_ROOT']."/vendas/phpInit.php";


  class frontEnd implements database{

    private $table = "faq";
    private $db;
    private $sys;


    public function __construct(){
      # Initialize DB class
      $this->db = new serviceDB($this);
      # Check action
      $this->{$_GET['action']}();
    }

    #########################
    ##      SET METHODS    ##
    #########################


    public function setTable($table){
      $this->table = $table;
    }


    #########################
    ##      GET METHODS    ##
    #########################

    public function getTable(){
      return $this->table;
    }
    public function getView() {
        return $this->view;
    }
    #########################
    ##    OTHER METHODS    ##
    #########################

    public function getItems(){

      $cond = null;
      $this->setTable("vendas");
      switch($_GET['item']){
        case 'Unidades':
          $name = 'UNIDADE';
          break;
        case 'Estados':
          $name = 'ESTADO';
          break;
        case 'Cidades':
          $name = 'CIDADE';
          break;
        case 'Clientes':
          $name = 'CLIENTE';
          break;
        case 'Produtos':
          $name = 'DESCRICAO';
          break;
        case 'Grupos':
          $name = 'GRUPO';
          break;
        case 'Linhas':
          $name = 'LINHA';
          break;
        case 'Segmentos':
          $name = 'SEGMENTO';
          break;
        case 'Canais':
          $name = 'CANAL';
          break;
        case 'Gerentes':
          $name = 'LOJISTA';
          break;
        case 'Marcas':
          $name = 'FORNECEDOR';
          break;
        case 'Representantes':
          $name = 'VENDEDOR';
          break;
        case 'Regiao':
          $this->setTable("regiao");
          $name = "reg_nome";
          break;
      }
      echo $cond;
      $this->db->setField($name);
      $cond = "1=1 group by $name";
      $data = $this->db->read($cond);
      foreach($data as $key=>$value){
        $_name = $value[$name];
        echo "<option value='$_name'>$_name</option>";
      }

    }

    public function evolution_details()
    {
      session_start();

  $x = 0;

  if(isset($_REQUEST['Val']))
  {
     $fild = "sum(VALOR_TOTAL)" ;
     $real = "R$";
     $itens = null;
  }
  else
  {
    $fild = "sum(QUANTIDADE)";
         $real = null;
     $itens = "Itens";
  }

  $fields = $_SESSION['campos'];
  $date = $_SESSION['date'];

  ###########################################
  ##           Retrieve Data               ##
  ###########################################

  //Start classes
  $evolution = new \controller\evolution\main();
  $evolution->setFielda($fields);
  $periods = $evolution->getPeriod($date);

  $values = $evolution->evolution();


  $limit = count($periods);


  echo "<table class='bordertable'>
    <thead>
      <th>Data</th>
      <th>Período anterior</th>
      <th>Período Selecionado</th>
      <th>Evolução</th></thead><tbody>";

         for($x=0,$y=0;$x<$limit;$x++,$y++){
          $d = explode(",",$periods[$x])[0];
          $dataIni = date("m/Y",strtotime($d));

          $periodSelected = number_format(round($values[0][$y][1],2),2,",",".");
          $periodBefore = number_format(round($values[1][$y][1],2),2,",",".");
          if($periodBefore <= 0 ){$evolut = "100";}
          else{  $evolut = round((($periodSelected*100)/$periodBefore)-100,2);}
          $cl = ($evolut < 0) ? "color:red;" : "color:green;";
          echo "<tr>
            <td>$dataIni
            <td>$real $periodBefore $itens</td>
            <td>$real $periodSelected $itens</td>
            <td style='$cl'><b>$evolut %</b></td>
            </tr>";


         }
       echo "</tbody></table>";

    }
    //======================
    //       Comparison
    //======================
    public function comparison_details()
    {


      ###########################################
      ##              Data                     ##
      ###########################################
      session_start();
      //Start classes
      //=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
      $comparison = new \controller\comparison\main();
              $comparison->setFielda($_SESSION['fields']);
      $query =  $_SESSION['query'];
      $query2 = $_SESSION['query2'];
      $x = 0;

//      if(isset($_REQUEST['Val']))
//      {
         $fild = "sum(VALOR_TOTAL)" ;
         $real = "R$";
         $itens = null;
//      }
//      else
//      {
//        $fild = "sum(QUANTIDADE)";
//             $real = null;
//         $itens = "Itens";
//      }


     $comparison->getPeriod($_SESSION['periodos']);

      $boughts = $comparison->comparison();
      $sells = $boughts[0];
      $sellsA = $boughts[1];
      $string = $boughts[2];
      $valores = $boughts[3];
      $valores2 = $boughts[4];
      $datas = $comparison->periodos;

      $x = 0;


          $limit = count($datas);
      echo "<table class='table table-hover table-bordered'>
              <thead>

                <th>Data</th>
                <th>Quadro1</th>
                <th>Quadro2</th>
                <th>Participação</th>
              </thead>
              <tbody>
              ";
               for($x=0;$x<$limit;$x++)
               {
                $dataI = explode(",",$sells[$x][0]);
                $dataIni = date("m/Y",strtotime($dataI[0]));

                $periodSelected = round($sells[$x][1],2);
                $periodBefore = round($sellsA[$x][1],2);
                if($periodBefore <= 0 ){$evolut = "100";}
                else{  $evolut = round((($periodSelected *100)/$periodBefore),2);}

                echo "<tr>
                  <td>$dataIni
                  <td>$real $periodSelected $itens</td>
                  <td>$real $periodBefore $itens</td>
                  <td>$evolut %</td>
                  </tr>";
               }
             echo "</tbody></table>";

    }


    public function participation_details()
    {
      session_start();


  $fields = $_SESSION['fields'];
  $date = $_SESSION['date'] ;


//  if(isset($_REQUEST['Val']))
//  {
     $fild = "sum(VALOR_TOTAL)" ;
     $real = "R$";
     $itens = null;
//  }
//  else
//  {
//    $fild = "sum(QUANTIDADE)";
//         $real = null;
//     $itens = "Itens";
//  }


  //Start class
  $part = new \controller\participation\main();
  $part->setFielda($fields);
  $data = $part->participation($date);
  $sells = $part->sells;
  $sellsA = $part->sells2;
  $limit = count($sells);
   echo "<table class='table table-hover table-bordered'>
        <thead>
          <th>Data</th>
          <th>Quadro1</th>
          <th>Quadro2</th>
          <th>Evolução</th><thead/><tbody>";
         for($x=0;$x<$limit;$x++)
         {
          $dataI = explode(",",$sells[$x][0]);
          $dataIni = date("m/Y",strtotime($dataI[0]));

          $periodSelected = round($sells[$x][1],2);
          $periodBefore = round($sellsA[$x][1],2);
          if($periodBefore <= 0 ){$evolut = "100";}
          else{  $evolut = (($periodSelected*100)/$periodBefore);}
          $evolut = round($evolut,2);

          echo "<tr>
            <td>$dataIni
            <td>$real $periodSelected $itens</td>
            <td>$real $periodBefore $itens</td>
            <td>$evolut %</td>
            </tr>";


         }
       echo "</tbody></table>";

    }

    public function moves_details()
    {
      session_start();

  //Array of fields
  $fields = $_SESSION['field'];
  $date = $_SESSION['date'];

  if(isset($_REQUEST['Val']))
  {
     $fild = "sum(VALOR_TOTAL)" ;
     $real = "R$";
     $itens = null;
  }
  else
  {
    $fild = "sum(QUANTIDADE)";
         $real = null;
     $itens = "Itens";
  }

  //Start class
  $moves = new \controller\moves\main();
  $moves->setFielda($fields);
  //Identifica os intervalos dos períodos  escolhidos
  $periodos =period::getPeriod($date);


  //Table name
  //=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
  $nameFilter = $moves->name;
  $tableField = $moves->tabla;

  $lista = $moves->moves($periodos);



  $x = 1 ;
    $dados = $lista;

    echo "<h3>Movimento de $_SESSION[campo] </h3>";

    echo "<h3> $_SESSION[campo] Inativos</h3>";
        echo "<table class='table table-hover table-bordered'>
        <thead>
          <th>$_SESSION[campo]</th>
          <th>Valor total vendido no período</th></thead><tbody>";
    foreach($dados['inativo'] as $key=>$value)
    {
      echo "<tr><td>$key</td><td>R$ $value </td></tr>";
    }

     echo "</tbody></table>";

     echo "<h3> $_SESSION[campo] Recuperados</h3>";
        echo "<table class='table table-hover table-bordered'>
        <thead>
          <th>$_SESSION[campo]</th>
          <th>Valor total vendido no período</th></thead><tbody>";
    foreach($dados['Recuperados'] as $key=>$value)
    {
      echo "<tr><td>$key</td><td>R$ $value </td></tr>";
    }

     echo "</tbody></table>";

        echo "<h3> $_SESSION[campo] constante(s) </h3>";
        echo "<table class='table table-hover table-bordered'>
        <thead>
          <th>$_SESSION[campo]</th>
          <th>Valor total vendido no período</th></thead>";
    foreach($dados['constante'] as $key=>$value)
    {
      echo "<tr><td>$key</td><td>R$ $value</td></tr>";
    }

     echo "</tbody></table>";

        echo "<h3> $_SESSION[campo] novos(s) </h3>";
        echo "<table class='table table-hover table-bordered'>
        <thead>
          <th>$_SESSION[campo]</th>
          <th>Valor total vendido no período</th></thead><tbody>";
    foreach($dados['novos'] as $key=>$value)
    {
      echo "<tr><td>$key</td><td>R$ $value</td></tr>";
    }

     echo "</tbody></table>";


    }
    public function ranking_details(){
      session_start();
      //Array of fields
      $fields = array($_SESSION['campos'][0],$_SESSION['campos'][1]);

  ###########################################
  ##           Retrieve Data               ##
  ###########################################

  //Start classes
  $ranking = new \controller\ranking\main();
  $ranking->old_cons($fields);
  //Check information type
  //=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
  if(isset($_REQUEST['Val']))
  {
     $fild = "sum(VALOR_TOTAL)" ;
     $rs = "R$";
     $itens = null;
  }
  else
  {
    $fild = "sum(QUANTIDADE)";
         $rs = null;
     $itens = "Itens";
  }

  //Datas
  //=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
  $x = 0;

  $tableField = $ranking->tabla;
  $nameFilter = $ranking->name;
  $item = $ranking->ranking($_SESSION['datas']);
  $total = $ranking->total;
  $outros =0;

  $limit = count($item);
  for($x = 4;$x<$limit;$x++){$outros += round($item[$x][0],2);}
  $outrosCent = round(($outros/$total)*100,2);

$x = 1 ;
    $dados = $item;
    echo "<h3>Ranking de $_SESSION[campo] </h3>";
    echo "<table class='table table-hover table-bordered'>
    <thead>
      <th>$_SESSION[campo]</th>
      <th>Valor</th>
      <th>Participação</th>
    </thead><tbody>";
    foreach($dados as $key)
    {
      echo "<tr><td>$key[1]</td><td>$rs $key[0] $itens </td><td>$key[2] %</td></tr>";
    }
    echo "</tbody></table>";
    }

    public function inative_details()
    {
      session_start();
  # Array of fields
  $fields =  $_SESSION['campos'];
  # Date
  $datas = $_SESSION['datas'];

  # Start class
  $inative = new \controller\inative\main();
  $inative->setFielda($fields);
  # Table name
  $nameFilter = $inative->name;
  # Set minimum limit
  $inative->setLimit($_SESSION['limit']);
  if(isset($_REQUEST['Qntd']))
  {
    $inative->field = "sum(QUANTIDADE)";
    $rs = null;
    $itens = "itens";
  }
  else{$inative->field = "sum(VALOR_TOTAL)"; $itens = null ; $rs = "R$";}

  # Get report
  $inativeData = $inative->inative($datas);
  # Get data
  $item = $inativeData[0];

  $x = 0;
  //Count items of each period
  foreach($item as $key=>$value)
  {
     $inatives[$x][0] = count($value);
    $inatives[$x][1] = $key;
    ++$x;
  }

  ###########################################
  ##           Retrieve Data               ##
  ###########################################
  $x = 1 ;
    #$dados = $item;
    $dados = $inativeData;
    #echo "<pre>";print_r($inativeData);echo "</pre>";
     echo "<br /><h4>Foco: $datas</h4>";
    echo "<h3>$_SESSION[campo] ativo  no mês </h3>";
        echo "<table class='table table-hover table-bordered'>
        <thead>
          <th>$_SESSION[campo]</th>
          <th>Última compra</th>
          <th>Valor gasto(Ultimo mês)</th>
          <th>Data da última compra</th></thead><tbody>";
    foreach($dados as $key)
    {
      #echo "<pre>";print_r($key);exit();
      foreach($key as $value)
      {
       echo "<tr><td>".$value[1]."</td><td>$rs ".$value[2]." $itens</td><td>$rs ".$value[0]." $itens</td>
       <td>".$value[3]."</td></tr>";

      }
    echo "</tbody></table>";

    if($x>7){break;}
    $y = explode("-",$datas);

    $p = $y[0] - $x;
    if($p <= 0){
      $p = 12 - $p;
      $o = $y[1] - 1;
    }
    $o = $y[1];
    $n = $o-1;
    $z = $p."/".$o;
    echo "<br /><h3>$_SESSION[campo] ativos à $x mês(es)  </h3>";
            echo "<table class='table table-hover table-bordered'>
        <thead>
          <th>$_SESSION[campo]</th>
          <th>Última compra</th>
          <th>Valor gasto</th>
          <th>Data da última compra</th></thead><tbody>";
          ++$x;
    }

     echo "</tbody></table>";


}
public function fotografe_details() {

  session_start();

  ###########################################
  ##              Data                     ##
  ###########################################

  $fields =  array($_SESSION['campos'][0],$_SESSION['campos'][1]);
  $periods = array($_SESSION['datas'][0],$_SESSION['datas'][1]);

  ###########################################
  ##           Retrieve Data               ##
  ###########################################

  //Start classes
  $fotografe = new \controller\fotografe\main();
$fotografe->old_cons($fields,$periods);

  //Check information type
  if(isset($_REQUEST['Qntd']))
  {
    $fotografe->field = "sum(QUANTIDADE)";
    $rs = null;
    $itens = "itens";
  }
  else
  {
    $fotografe->field = "sum(VALOR_TOTAL)";
    $itens = null;
    $rs = "R$";
  }

  //Execute fotografe function
  $fotografe = $fotografe->fotografe();
  $contagem = $fotografe[0];

  //Clients that evolved
  $evolucao  = $fotografe[1];

  //Clients that regressed
  $regressao = $fotografe[2];
   echo "<br /><h5>Período A: '$periods[0]'</h5> <h5>Período B: '$periods[1]'</h5>  ";
     echo "<h3>$_SESSION[campo] que regrediram</h3>";
        echo "<table class='table table-hover table-bordered'>
        <thead>
          <th>$_SESSION[campo]</th>
          <th>Periodo A</th>
          <th>Periodo B</th>
          <th>Variação</th></thead><tbody>";
          foreach($regressao as $key)
          {
            if($key[2] == 0){$variação = '---';}
            else{$variação = round(($key[1]/$key[2])*100-100,2);}
            echo "<tr><td>$key[0]</td><td>$rs $key[1] $itens</td><td>$rs $key[2] $itens</td>
            <td>$variação %</td></tr>";
          }

       echo "</tbody></table>";
    echo "<h3>$_SESSION[campo] que Evoluiram </h3>";

        echo "<table class='table table-hover table-bordered'>
        <thead>
          <th>$_SESSION[campo]</th>
          <th>Periodo A</th>
          <th>Periodo B</th>
          <th>Variação</th></thead><tbody>";
          foreach($evolucao as $key)
          {
            if($key[2] == 0){$variação = '0';}
            else{$variação = round(($key[1]/$key[2])*100-100,2);}
            echo "<tr><td>$key[0]</td><td>$rs $key[1] $itens</td><td>$rs $key[2] $itens</td>
            <td>$variação %</td></tr>";
          }

       echo "</tbody></table>";

}

public function trend_details() {
  session_start();
    if(isset($_REQUEST['Val']))
  {
     $fild = "sum(VALOR_TOTAL)" ;
     $rs = "R$";
     $itens = null;
  }
  else
  {
    $fild = "sum(QUANTIDADE)";
         $rs = null;
     $itens = "Itens";
  }

  ###########################################
  ##               Includes                ##
  ###########################################



  ###########################################
  ##              Data                     ##
  ###########################################

  $fields = $_SESSION['campos'];
  $date = $_SESSION['datas'];

  ###########################################
  ##           Retrieve Data               ##
  ###########################################
  $trend = new \controller\trend\main();
  $trend->old_cons($fields,$date);
  $campo = $trend->name;
  $lista = $trend->trend();
  $dias = $trend->dias;
  $registros = $lista[1];
  $lista = $lista[0];


 $x = 1 ;
    $dados = $lista;

    //echo "<pre>";print_r($dados['more']); echo "</pre>";break;
    echo "<h3> Tendência(s) $campo  </h3>";

    echo "<h3> $campo  Acima da média </h3>";
        echo "<table class='table table-hover table-bordered'>
        <thead>
          <th>$campo </th>
          <th>N° de compras do período</th>
          <th>Média Atual</th>
          <th>Média Histórica</th>
          <th>Variação</th></thead><tbody>";
    foreach($dados['more'] as $key=>$value)
    {
      //echo $key ;echo "<pre>";print_r($value);echo "</pre>";break;
      $bought = $value[0][0];
      $c = round($value[1][0],2);
      $d = round($value[1][1],2);
      $a = round($value[0][2],2);
      $b = round($value[0][1],2);
      $e = round($value[2],2);
      echo "<tr><td>$key</td>
      <td>$bought</td>
      <td>$a compras de $b Reais a cada 30 dias </td>
      <td>$c compras de $d Reais a cada 30 dias </td><td>$e %</td></tr>";
    }

     echo "</tbody></table>";

     echo "<h3> $campo na media </h3>";
       echo "<table class='table table-hover table-bordered'>
        <thead>
          <th>$campo</th>
          <th>N° de compras do período</th>
          <th>Média Atual</th>
          <th>Média Histórica</th>
          <th>Variação</th></thead><tbody>";
    foreach($dados['equal'] as $key=>$value)
    {
     $bought = $value[0][0];
      $a = round($value[0][2],2);
      $b = round($value[0][1],2);
      $c = round($value[1][0],2);
      $d = round($value[1][1],2);
      $e = round($value[2],2);
      echo "<tr><td>$key</td>
      <td>$bought</td>
      <td>$a compras de $b Reais a cada 30 dias </td>
      <td>$c compras de $d Reais a cada 30 dias </td><td>$e %</td></tr>";
    }

     echo "</tbody></table>";

        echo "<h3> $campo Abaixo da média </h3>";
       echo "<table class='table table-hover table-bordered'>
        <thead>
          <th>$campo</th>
          <th>N° de compras do período</th>
          <th>Média Atual</th>
          <th>Média Histórica</th>
          <th>Variação</th></thead><tbody>";
    foreach($dados['less'] as $key=>$value)
    {
      $bought = $value[0][0];
      $a = round($value[0][2],2);
      $b = round($value[0][1],2);
      $c = round($value[1][0],2);
      $d = round($value[1][1],2);
      $e = round($value[2],2);
      echo "<tr><td>$key</td>
      <td>$bought</td>
      <td>$a compras de $b Reais a cada 30 dias </td>
      <td>$c compras de $d Reais a cada 30 dias </td><td>$e %</td></tr>";
    }

     echo "</tbody></table>";
    if (isset($lista['noHistory']))
    {

        echo "<h3> $campo sem registro </h3>";
         echo "<table class='table table-hover table-bordered'>
        <thead>
          <th>$campo</th>
          <th>N° de compras do período</th>
          <th>Média Atual</th>
          <th>Média Histórica</th>
          <th>Variação</th></thead><tbody>";
    foreach($dados['noHistory'] as $key=>$value)
    {
      $bought = $value[0][0];
      $a = round($value[0][2],2);
      $b = round($value[0][1],2);
      $c = round($value[1][0],2);
      $d = round($value[1][1],2);
      $e = round($value[2],2);
      echo "<tr><td>$key</td>
      <td>$bought</td>
      <td>$a compras de $b Reais a cada 30 dias </td>
      <td>$c compras de $d Reais a cada 30 dias </td><td>$e %</td></tr>";
    }

     echo "</tbody></table>";
     }
}
}
  new frontEnd();
  ?>
