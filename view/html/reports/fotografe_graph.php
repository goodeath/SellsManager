<!DOCTYPE html>
<html lang='pt-br'>
  <head>
    <title>Gerenciador de Vendas</title>
    <meta charset='UTF-8' />
    <link href="/vendas/view/css/bootstrap3.3.6/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" type="text/css" href="/vendas/view/css/main.css" />
    <link rel="stylesheet" href="/c-g/view/css/yaml/add-ons/accessible-tabs/tabs.css" type="text/css"/>
     <script src="/vendas/view/js/jquery-2.1.4.min.js" type="text/javascript"></script>
    <script src="/vendas/view/css/yaml/add-ons/accessible-tabs/jquery.tabs.js" type="text/javascript"></script>

    <link rel="stylesheet" type="text/css" href="/vendas/view/css/main.css" />
    <script src="/vendas/view/js/general.js"></script>
    <script src="/vendas/view/js/Chart.js"></script>
    <script src="/vendas/view/js/reportChange.js"></script>
        <script>                                        

    var options = {
        responsive:true
    };

    var data = {
        labels: ["Evolução","Regressão","Diferença"],
        datasets: [
            {
                label: "Evolução",
                fillColor: "rgba(220,220,220,0.5),rgba(020,020,020,0.5)",
                strokeColor: "rgba(120,120,220,0.8)",
                highlightFill: "rgba(120,120,220,0.75)",
                highlightStroke: "rgba(120,120,220,1)",
                data: [<?php echo "$eValue,$rValue,'$difstring'"; ?>]
            }
        ]
    };                

    window.onload = function(){$('.jquery_tabs').accessibleTabs();
    active(7)
     var ctx = document.getElementById("GraficoLine").getContext("2d");
        var LineChart = new Chart(ctx).Bar(data, options);
        
        var report = document.getElementById("wrapperReport");
        report = report.getElementsByTagName("select");
        report[0].addEventListener("change",function(){turnRelat(report[0].value,"Visão Geral","fotografe")});

        ajax('/vendas/controller/frontEnd.php?action=fotografe_details',"report")
 }
    
    </script>
 
  </head>
  <body>
   <?php require_once HEADER; ?>

    <div class="jquery_tabs">
      <h4 ><p>Gráfico</p></h4>
      <div class='tabbody'>
        <!------------- Graphic ------------>
        <div id="wrapper">
          <div id="legenda">
            <h3>Fotografe</h3>
            <?php echo "Evolução: $evolução $nameFilter<br />
            Regressão: $regressão  $nameFilter <br />
            Diferença: R$ $diferença"; ?>
            <br /><br />
          </div>
          <div class="box-chart"><canvas id="GraficoLine" ></canvas></div>
        </div>
        <!------------- Graphic ------------>
      </div>
      <h4><p>Listagem</p></h4>
      <div class='tabbody'>
        <!------------- Report ------------>
        <div id="wrapperReport">
          <select>
            <option value='Val'>Valores</option>
            <option value='Qntd'>Quantidade</option>
          </select>
          <div id="report"></div>
        </div>
        <!------------- Report ------------>
      </div>
    </div>
  </body>
</html> 