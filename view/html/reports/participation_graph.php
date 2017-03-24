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
    <script src="/vendas/view/js/appearence.js"></script>
    
    <script>                                        
var options = {
        responsive:true
    };

    var data = {
        labels: [<?php echo $string; ?>],
        datasets: [
            {
                 label: "Dados secundários",
                fillColor: "rgba(240,153,153,0.2)",
                strokeColor: "rgba(240,153,153,1)",
                pointColor: "rgba(240,153,153,1)",
                pointStrokeColor: "#fff",
                pointHighlightFill: "#fff",
                pointHighlightStroke: "rgba(240,153,153,1)",
                data: [<?php echo $valores; ?>]
            },
            {
                label: "Dados secundários",
                fillColor: "rgba(151,187,205,0.2)",
                strokeColor: "rgba(151,187,205,1)",
                pointColor: "rgba(151,187,205,1)",
                pointStrokeColor: "#fff",
                pointHighlightFill: "#fff",
                pointHighlightStroke: "rgba(151,187,205,1)",
                data: [<?php echo $valores2; ?>]
            }
        ]
    };    
   window.onload = function(){active(2)
   $('.jquery_tabs').accessibleTabs();
        var ctx = document.getElementById("GraficoLine").getContext("2d");
        var LineChart = new Chart(ctx).Line(data, options);

      
        //report[0].addEventListener("change",function(){showRelat2(report[0].value)});

        ajax('/vendas/controller/frontEnd.php?action=participation_details',"report")
         }   </script>      

  </head>
  <body>
    <!--Add header-->
    <?php require_once HEADER; ?>

    <div class="jquery_tabs">
      <h4 ><p>Gráfico</p></h4>
      <div class='tabbody'>
        <div id="wrapper">
          <div id="legenda">
            <h3>Evolução das vendas em valores</h3>
            <div class="legendas">
              <div class="legenda1"></div><p class="text"> Período</p>
            </div>    
            <div class="legendas">
              <div class="legenda2"></div><p class="text">Período anterior</p>
            </div>
            <br /><br />
          </div>
          <div class="box-chart">
            <canvas id="GraficoLine" ></canvas>
          </div>
        </div>
      </div>  
      <h4><p>Listagem</p></h4>
      <div class='tabbody'>
        <div id="wrapperReport">
          <select>
            <option value='Valores'>Valores</option>
            <option value='Quantidade'>Quantidade</option>
          </select>
          <div id="report"></div>
        </div>
      </div>
  </body>
</html>