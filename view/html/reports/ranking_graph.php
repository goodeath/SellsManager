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
            value: <?php echo $item[0][0] ?>,
            color:"#00FF00",
            highlight: "#00FF00",
            label: "<?php echo $item[0][1]."(".$item[0][2]."%)"; ?>"
        },
        {
            value: <?php echo $item[1][0] ?>,
            color: "#32CD32",
            highlight: "#32CD32",
            label: "<?php echo $item[1][1]."(".$item[1][2]."%)" ?>"
        },
        {
            value: <?php echo $item[2][0] ?>,
            color: "#ADFF2F",
            highlight: "#ADFF2F",
            label: "<?php echo $item[2][1]."(".$item[2][2]."%)" ?>"
        },
        {
            value: <?php echo $item[3][0] ?>,
            color: "#FFD700",
            highlight: "#FFD700",
            label: "<?php echo $item[3][1]."(".$item[3][2]."%)" ?>"
        },
        {
            value: <?php echo $item[4][0] ?>,
            color: "#FFA500",
            highlight: "#FFA500",
            label: "<?php echo $item[4][1]."(".$item[4][2]."%)" ?>"
        },
        {
            value: <?php echo $outros ?>,
            color: "#FF8C00",
            highlight: "#FF8C00",
            label:" Outros(<?php echo $outrosCent ;?>%)"
        }

    ]


    window.onload = function(){$('.jquery_tabs').accessibleTabs();active(5)
     var ctx = document.getElementById("GraficoLine").getContext("2d");
        var LineChart = new Chart(ctx).Pie(data, options);
        
        var report = document.getElementById("wrapperReport");
        report = report.getElementsByTagName("select");
        report[0].addEventListener("change",function(){turnRelat(report[0].value,"Visão Geral","ranking")});

        ajax('/vendas/controller/frontEnd.php?action=ranking_details',"report")
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
          <div id="legenda"><h3>Ranking de <?php echo $nameFilter; ?></h3></div>
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
  </body>
</html>