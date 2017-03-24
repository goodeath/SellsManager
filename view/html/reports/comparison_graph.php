<!DOCTYPE html>
<html lang='pt-br'>
  <head>
    <title>Gerenciador de Vendas</title>
    <meta charset='UTF-8' />
    <link href="/vendas/view/css/bootstrap3.3.6/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" type="text/css" href="/vendas/view/css/main.css" />
    <link rel="stylesheet" href="/vendas/view/css/yaml/add-ons/accessible-tabs/tabs.css" type="text/css"/>
     <script src="/vendas/view/js/jquery-2.1.4.min.js" type="text/javascript"></script>
    <script src="/vendas/view/css/yaml/add-ons/accessible-tabs/jquery.tabs.js" type="text/javascript"></script>
    <script src="/vendas/view/js/appearence.js"></script>
    <link rel="stylesheet" type="text/css" href="/vendas/view/css/main.css" />
    <script src="/vendas/view/js/general.js"></script>
    <script src="/vendas/view/js/Chart.js"></script>
    <script src="/vendas/view/js/reportChange.js"></script>
    <script>                                        

    var options = {
        responsive:true
    };

    var data = {
        labels: [<?php echo $string; ?>],
        datasets: [
            {
                label: "Dados primários",
                fillColor: "rgba(0,0,220,0.6)",
                strokeColor: "rgba(0,0,120,0.4)",
                highlightFill: "rgba(0,0,120,0.75)",
                highlightStroke: "rgba(0,0,120,1)",
                  pointStrokeColor: "#fff",
                pointHighlightFill: "#fff",
                pointHighlightStroke: "rgba(220,220,220,1)",
                data: [<?php echo $valores; ?>]
            },
            {
                label: "Dados secundários",
                fillColor: "rgba(220,0,0,0.3)",
                strokeColor: "rgba(120,0,0,0.8)",
                highlightFill: "rgba(120,0,0,0.75)",
                highlightStroke: "rgba(120,0,0,1)",
                  pointStrokeColor: "#fff",
                pointHighlightFill: "#fff",
                pointHighlightStroke: "rgba(220,220,220,1)",
                data: [<?php echo $valores2; ?>]
            }
        ]
    };                

    window.onload = function(){
    $('.jquery_tabs').accessibleTabs();
     var ctx = document.getElementById("GraficoLine").getContext("2d");
        var LineChart = new Chart(ctx).Line(data,options);
    
        var report = document.getElementById("wrapperReport");
        report = report.getElementsByTagName("select");
        report[0].addEventListener("change",function(){showRelat2(report[0].value)});

        ajax('/vendas/controller/frontEnd.php?action=comparison_details',"report")
         }         

</script>

  </head>
  <body>
    <?php require_once HEADER; ?>
    <script>active(1)</script>
    <div class="jquery_tabs">
      <h4 ><p>Gráfico</p></h4>
        <div class='tabbody'>
          <div id="wrapper">
            <div id="legenda">
      
              <h3>Comparação das vendas em valores</h3>

              <div class="legendas">
                <div class="legenda1"></div><p class="text"> 
                <select>
                  </p>
                </select>
              </div>
              <div class="legendas">
               <div class="legenda2"></div><p class="text"><?php foreach($fields[1] as $key=>$value){echo $value.",";}?></p>
              </div>

              <br /><br />
            </div>

      <div class="box-chart">
       <canvas id="GraficoLine" ></canvas>

      </div>

    </div>
    </div>
    <!------------- Graphic ------------>
    <h4 ><p>Listagem</p></h4>
      <div class='tabbody'>
    <div id="wrapperReport">
    
     <select>
        <option value='Valores'>Valores</option>
        <option value='Quantidade'>Quantidade</option>

      </select>

      <div id="report">

      </div>
    </div>
    </div>
    <!------------- Report ------------>
      </div>
  </body>
  </html>