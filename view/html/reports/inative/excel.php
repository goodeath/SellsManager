<?php 
  # start session
  session_start();
  # Get constants of directories
  include $_SERVER['DOCUMENT_ROOT']."/vendas/sys/con_dir.php";
  # Include class
  include CLASSE."class_inative.php";  
  //Array of fields
  $fields =  $_SESSION['campos'];
  
  //Date
  $date = $_SESSION['datas'];
  
  ###########################################
  ##           Retrieve Data               ##
  ###########################################
  
  # Start class
  $inative = new inative($fields);
  # Table names
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
  $inativeData = $inative->inative($date);
  # Until six months
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

  // Incluimos a classe PHPExcel
  include  EXCEL;

  // Instanciamos a classe
  $objPHPExcel = new PHPExcel();

  // Definimos o estilo da fonte
  $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
  $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(90);
  $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
  $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(30);

  // Criamos as colunas
  $objPHPExcel->setActiveSheetIndex(0)
              ->setCellValue('A1', "$_SESSION[campo] ativos no mês" )
              ->setCellValue('A3', "$_SESSION[campo]" )
              ->setCellValue("B3", "Última compra" )
              ->setCellValue("C3", "Valor gasto" )
              ->setCellValue("D3", "Data da última compra");
              $row = 4;
  
  $x = 1 ;
    $dados = $item;


    foreach($dados as $key)
    {
      foreach($key as $value)
      {
          // Também podemos escolher a posição exata aonde o dado será inserido (coluna, linha, dado);
          $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $row, $value[1]);
          $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $row, "$rs ".$value[2]);
          $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $row, "$rs ".$value[0]);
          $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $row, $value[3]);
          ++$row;

       #echo "<tr><td>".$value[1]."</td><td>$rs ".$value[2]." $itens</td><td>$rs ".$value[0]." $itens</td></tr>";
      }

    
    if($x>7){break;}
    $t = $row+1;
    $a1 = "A".$t;
    $y = $row+3;
    $a2 = "A".$y;
    $b2 = "B".$y;
    $c3 = "C".$y;
    $d3 = "D".$y;
    $row = $row+4;
    $objPHPExcel->setActiveSheetIndex(0)
              ->setCellValue($a1, "$_SESSION[campo] ativos a $x mês(es)" )
              ->setCellValue($a2, "$_SESSION[campo]" )
              ->setCellValue($b2, "Última compra" )
              ->setCellValue($c3, "Valor gasto" )
              ->setCellValue($d3, "Data da última compra" );
              
              ++$x;
    // echo "<br /><h3>$_SESSION[campo] ativos a $x mês(es) </h3>";
    //         echo "<table class='noBorder'>
    //     <tr>
    //       <td>$_SESSION[campo]</td>
    //       <td>Última compra</td>
    //       <td>Valor gasto</td><tr/>";
    //       ++$x;
    }
     
 
 
// Podemos renomear o nome das planilha atual, lembrando que um único arquivo pode ter várias planilhas
$objPHPExcel->getActiveSheet()->setTitle('Inatividade');

// Cabeçalho do arquivo para ele baixar
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Inativos.xlsx"');
header('Cache-Control: max-age=0');
// Se for o IE9, isso talvez seja necessário
header('Cache-Control: max-age=1');

// Acessamos o 'Writer' para poder salvar o arquivo
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');

// Salva diretamente no output, poderíamos mudar arqui para um nome de arquivo em um diretório ,caso não quisessemos jogar na tela
$objWriter->save('php://output'); 

exit;

?>