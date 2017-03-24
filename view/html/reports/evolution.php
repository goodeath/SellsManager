<!DOCTYPE html>
<html lang='pt-br'>
  <head>
    <title>Gerenciador de Vendas</title>
    <meta charset='UTF-8' />
    <link rel="stylesheet" href="/vendas/view/css/yaml/screen/typography.css" type="text/css"/>
    
    <link rel="stylesheet" type="text/css" href="/vendas/view/css/main.css" />
    <link rel="stylesheet" href="/vendas/view/css/yaml/add-ons/accessible-tabs/tabs.css" type="text/css"/>

    
     <script src="/vendas/view/js/jquery-2.1.4.min.js" type="text/javascript"></script>
    <script src="/vendas/view/css/yaml/add-ons/accessible-tabs/jquery.tabs.js" type="text/javascript"></script>
    <script src="/vendas/view/js/Chart.js"></script>
    <script src="/vendas/view/js/general.js"></script>
    <script src="/vendas/view/js/ajax.js"></script>
    
    <script>                                        

    var options = {
        responsive:true
    };

    var data = {
        labels: [<?php echo $string2; ?>],
        datasets: [
            {
                label: "Dados secundários",
                fillColor: "rgba(220,0,0,0.5)",
                strokeColor: "rgba(220,0,0,0.8)",
                highlightFill: "rgba(220,0,0,0.75)",
                highlightStroke: "rgba(220,0,0,1)",
                data: [<?php echo $valores2; ?>]
            },
            {
                label: "Dados primários",
                fillColor: "rgba(0,0,220,0.5)",
                strokeColor: "rgba(0,0,120,0.8)",
                highlightFill: "rgba(0,0,120,0.75)",
                highlightStroke: "rgba(0,120,0,1)",
                data: [<?php echo $valores; ?>]
            }
        ]
    };                

    window.onload = function(){
      $('.jquery_tabs').accessibleTabs();
        var ctx = _$("#GraficoBarra").getContext("2d");
        var BarChart = new Chart(ctx).Bar(data, options);
     
        //initialize class
        var async = new ajax();
        var parameters = "action=evolution_details&Val=true";
        async.getProperties("report","/vendas/controller/frontEnd.php",parameters);

        async.send();
        var report = document.getElementById("wrapperReport");
        report = report.getElementsByTagName("select");
        report[0].addEventListener("change",function(){showRelat(report[0].value,report[1].value)});
        report[1].addEventListener("change",function(){showRelat(report[0].value,report[1].value)});
        //ajax('/vendas/view/reports/evolution/values.php?Val=true',"report")
         }         
</script>
  </head>
  <body>
    <?php require_once HEADER; ?>
    
    <script>active(0)</script>
    
    <!------------- Graphic ------------>
    <div class="jquery_tabs">
      <h4 ><p>Gráfico</p></h4>
        <div class='tabbody'>
          <div id="wrapper">
            <div id="legenda">
              <h3>Evolução das vendas</h3>
              <div class="legendas">
               <div class="legenda2"></div><p class="text">Período anterior</p>
              </div>
              <div class="legendas">
                <div class="legenda1"></div>
                <p class="text"> Período Escolhido</p>
              </div>
              
              <br /><br />
            </div>
            <div class="box-chart"><canvas id="GraficoBarra" ></canvas></div>
          </div>
        </div>
    <!------------- Graphic ------------>
    <h4 ><p>Listagem</p></h4>
      <div class='tabbody'>
    <!------------- Report ------------>
        <div id="wrapperReport">
          <select>
            <option value='Valores'>Valores</option>
            <option value='Quantidade'>Quantidade</option>
          </select>
          <select>
            <option value ='Visão Geral'>Visão Geral</option>
            <option value ='Unidades'>Unidades</option>
            <option value ='Estado'>Estado</option>
            <option value ='Cidade'>Cidade</option>
            <option value ='Representante'>Representante</option>
            <option value ='Canais'>Canais</option>
            <option value ='Marcas'>Marcas</option>
            <option value ='Clientes'>Clientes</option>
            <option value ='Produtos'>Produtos</option>
            <option value ='Linhas'>Linhas</option>
            <option value ='Segmentos'>Segmentos</option>
            <option value ='Grupos'>Grupos</option>
          </select>
          <div id="report"></div>
        </div>
    <!------------- Report ------------>
      </div>
  </body>
</html>