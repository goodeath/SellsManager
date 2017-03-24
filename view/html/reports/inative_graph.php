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
            value: <?php echo $inatives[0][0] ?>,
            color:"#00FF00",
            highlight: "rgb(0,213,0)",
            label: "Inativos no mes"
        },
        {
            value: <?php if(isset($inatives[1][0])){echo $inatives[1][0];}else{echo 0;} ?>,
            color: "#32CD32",
            highlight: "rgb(41,171,41)",
            label: "Ativos a 1 mes"
        },
        {
            value: <?php if(isset($inatives[2][0])){echo $inatives[2][0];}else{echo 0;} ?>,
            color: "#ADFF2F",
            highlight: "rgb(155,255,4)",
            label: "Ativos a 2 meses"
        },
        {
            value: <?php if(isset($inatives[3][0])){echo $inatives[3][0];}else{echo 0;} ?>,
            color: "#FFD700",
            highlight: "rgb(213,181,0)",
            label: "Ativos a 3 meses"
        },
        {
            value: <?php if(isset($inatives[4][0])){echo $inatives[4][0];}else{echo 0;}?>,
            color: "#FFA500",
            highlight: "rgb(213,138,0)",
            label: "Ativos a 4 meses"
        },
        {
            value: <?php if(isset($inatives[5][0])){echo $inatives[5][0];}else{echo 0;} ?>,
            color: "#FF8C00",
            highlight: "rgb(213,117,0)",
            label: "Ativos a 5 meses"
        },
        {
            value: <?php if(isset($inatives[6][0])){echo $inatives[6][0];}else{echo 0;} ?>,
            color: "#FF4500",
            highlight: "rgb(213,58,0)",
            label: "Ativos a 6 meses"
        }

    ]


    window.onload = function(){active(6)
    $('.jquery_tabs').accessibleTabs();
     var ctx = document.getElementById("GraficoLine").getContext("2d");
        var LineChart = new Chart(ctx).Pie(data, options);

        var report = document.getElementById("wrapperReport");
        report = report.getElementsByTagName("select");
report[0].addEventListener("change",function(){turnRelat(report[0].value,"Visão Geral","inative")});

        ajax('/vendas/controller/frontEnd.php?action=inative_details',"report")
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
            <h3>Inatividade</h3>
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
          <a href="excel.php"><img src='excel.png'></img></a>
          <div id="report"></div>
        </div>
    <!------------- Report ------------>
    </div>
  </body>
</html>
