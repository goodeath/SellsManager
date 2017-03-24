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

    var data = [
        {
            value: <?php echo $inativo  ?>,
            color:"#00FF00",
            highlight: "rgb(0,213,0)",
            label: "Acima da média"
        },
        {
            value: <?php echo $recuperado  ?>,
            color: "#FFD700",
            highlight: "rgb(213,181,0)",
            label: "Na média"
        },
        {
            value: <?php echo $constante ?>,
            color: "#FF0000",
            highlight: "rgb(213,0,0)",
            label: "Abaixo da média"
        },
        {
            value: <?php echo $novos ?>,
            color: "#00BFFF",
            highlight: "rgb(0,159,213)",
            label: "Sem registros"
        }
    ]


    window.onload = function(){$('.jquery_tabs').accessibleTabs();
    active(4)
     var ctx = document.getElementById("GraficoLine").getContext("2d");
        var LineChart = new Chart(ctx).Pie(data, options);
        
        
        var report = document.getElementById("wrapperReport");
        report = report.getElementsByTagName("select");
        report[0].addEventListener("change",function(){turnRelat(report[0].value,"Visão Geral","trend")});

        ajax('/vendas/controller/frontEnd.php?action=trend_details',"report")
         }         
</script>
  </head>
  <body>
    <!--Add header-->
    <?php require_once HEADER; ?>
    
    <div class="jquery_tabs">
      <h4 ><p>Gráfico</p></h4>
      <div class='tabbody'>
        <div id="wrapper">
          <div id="legenda">
            <h3>Tendência(s) de <?php echo $nameFilter; ?></h3><br /><br />
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
            <option value='Val'>Valores</option>
            <option value='Qntd'>Quantidade</option>
          </select>

          <div id="report"></div>
        </div>
      </div>
    </div>  
  </body>
</html>