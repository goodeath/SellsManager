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

    var data = [
        {
            value: <?php echo $inativo  ?>,
            color:"#FF0000",
            highlight: "#FF0000",
            label: "Inativo"
        },
        {
            value: <?php echo $recuperado  ?>,
            color: "#00FF00",
            highlight: "#00FF00",
            label: "Recuperados"
        },
        {
            value: <?php echo $constante ?>,
            color: "#FFD700",
            highlight: "#FFD700",
            label: "Constante"
        },
        {
            value: <?php echo $novos ?>,
            color: "#00BFFF",
            highlight: "#00BFFF",
            label: "Novos"
        }
    ]


    window.onload = function(){$('.jquery_tabs').accessibleTabs();
     var ctx = document.getElementById("GraficoLine").getContext("2d");
        var LineChart = new Chart(ctx).Pie(data, options);
        
        
        var report = document.getElementById("wrapperReport");
        report = report.getElementsByTagName("select");
        report[0].addEventListener("change",function(){showRelat2(report[0].value)});

        ajax('/vendas/controller/frontEnd.php?action=moves_details',"report")
         }         
</script>

  </head>
  <body>
    <?php require_once HEADER; ?>
    <script>active(3)</script>
    
    <div class="jquery_tabs">
      <h4 ><p>Gráfico</p></h4>
      <div class='tabbody'>
        <!------------- Graphic ------------>
        <div id="wrapper">
          <div id="legenda">
            <h3>Movimento de <?php echo $nameFilter; ?></h3>
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
            <option value='Valores'>Valores</option>
            <option value='Quantidade'>Quantidade</option>
          </select>
          <div id="report"></div>
        </div>
        <!------------- Report ------------>
      </div>
    </div>
  </body>
</html>