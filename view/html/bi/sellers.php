<!DOCTYPE html>
<html lang='pt-br'>
  <head>
    <title>Gerenciador de Vendas</title>
    <meta charset='UTF-8' />
    <link rel="stylesheet" href="/vendas/view/js/chartist/chartist.min.css">
    <script src="/vendas/view/js/chartist/chartist.min.js"></script>
    <!--<meta http-equiv="refresh" content="10" >-->

    <link rel='stylesheet' type='text/css' href='/vendas/view/css/yaml/core/base.css'>
    <link rel='stylesheet' type='text/css' href='/vendas/view/css/yaml/screen/typography.css'>
    <link rel='stylesheet' type="text/css" href="/vendas/view/css/bigeneral.css">
    <script>
      window.onload = function(){
        new Chartist.Pie('#goal', {
          
          series: [<?= $current ?>,<?= $rest ?> ]
        }, {
          donut: true,
          donutWidth: 60,
          startAngle: 270,
          total: <?= $goal*2 ?>,
          showLabel: true
        });
        new Chartist.Pie('#goal3', {
          
          series: [<?= $current ?>,<?= $rest ?> ]
        }, {
          donut: true,
          donutWidth: 60,
          startAngle: 270,
          total: <?= $goal*2 ?>,
          showLabel: true
        });
        new Chartist.Pie('#goal4', {
          
          series: [<?= $current ?>,<?= $rest ?> ]
        }, {
          donut: true,
          donutWidth: 60,
          startAngle: 270,
          total: <?= $goal*2 ?>,
          showLabel: true
        });
        new Chartist.Bar('#goal2', {
          labels: [<?= $seg ?>],
          series: [<?= $serie ?> ]
        }, {
  distributeSeries: true
});
      }
      
    </script>
  </head>
  <body>
    <br />
    <div style="width:100%">
      <div style="width:33%;float:left">
        <h5 style="text-align:center;">Meta de faturamento</h5>
        <div class="ct-chart ct-golden-section ct-negative-labels" id="goal"></div>
      </div>
      <div style="width:33%;float:left">
        <h5 style="text-align:center;">Meta de faturamento</h5>
        <div class="ct-chart ct-golden-section ct-negative-labels" id="goal3"></div>
      </div>
      <div style="width:33%;float:left">
        <h5 style="text-align:center;">Meta de faturamento</h5>
        <div class="ct-chart ct-golden-section ct-negative-labels" id="goal4"></div>
      </div>
      <div style="width:70%;margin: 0 auto;clear:both">
        <h5 style="text-align:center;">Faturamento por segmento</h5>
        <div class="ct-chart ct-golden-section ct-negative-labels" id="goal2"></div>
      </div>
    </div>
  </body>
</html>