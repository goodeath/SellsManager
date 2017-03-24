<!DOCTYPE html>
<html lang='pt-br'>
  <head>
    <title>Gerenciador de Vendas</title>
    <meta charset='UTF-8' />
    <link rel="stylesheet" href="/vendas/view/js/chartist/chartist.min.css">
    <script src="/vendas/view/js/chartist/chartist.min.js"></script>
    <!--<meta http-equiv="refresh" content="10" >-->
    <script src="/vendas/view/js/Chart.js"></script>
    <link rel='stylesheet' type='text/css' href='/vendas/view/css/yaml/core/base.css'>
    <link rel='stylesheet' type='text/css' href='/vendas/view/css/yaml/screen/typography.css'>
    <link rel='stylesheet' type="text/css" href="/vendas/view/css/bigeneral.css">
    <script>

    
    var options = {
            responsive:true
        };

        var data = {
            labels: [<?= $ab ?>],
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
                    data: [<?= $lbls2 ?>]
                },
                {
                    label: "Dados secundários",
                    fillColor: "rgba(220,0,0,0.2)",
                    strokeColor: "rgba(120,0,0,0.8)",
                    highlightFill: "rgba(120,0,0,0.8)",
                    highlightStroke: "rgba(120,0,0,1)",
                      pointStrokeColor: "#fff",
                    pointHighlightFill: "#fff",
                    pointHighlightStroke: "rgba(220,220,220,1)",
                    data: [<?= $ac; ?>]
                }
            ]
        };  

        var options2 = {
                responsive:true
            };

            var data2 = {
                labels: [<?php echo $seg; ?>],
                datasets: [
                    {
                        label: "Dados secundários",
                        fillColor: "rgba(220,0,0,0.5)",
                        strokeColor: "rgba(220,0,0,0.8)",
                        highlightFill: "rgba(220,0,0,0.75)",
                        highlightStroke: "rgba(220,0,0,1)",
                        data: [<?php echo $serie; ?>]
                    }
                ]
            };                

             
  
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

       /* new Chartist.Line('#goal3', {
          labels: [<?= $ab ?>],
          series: [
            [<?= $lbls2 ?>],
            [<?= $ac ?>],
            
          ]
        }, {
          fullWidth: true,
          chartPadding: {
            right: 40
          }
        });*/
        var ctx = document.getElementById("goal3").getContext("2d");
        var LineChart = new Chart(ctx).Line(data,options);
    

        new Chartist.Pie('#goal4', {
          
          series: [<?= $dsum ?>,<?= $rest2 ?> ]
        }, {
          donut: true,
          donutWidth: 60,
          startAngle: 270,
          total: <?= $dgoal*2 ?>,
          showLabel: true
        });

        var ctx2 = document.getElementById("goal2").getContext("2d");
        var BarChart = new Chart(ctx2).Bar(data2, options2);  
        /*   var euro = function(x) {
    return 'R$' + x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
};

        new Chartist.Bar('#goal2', {
          labels: [<?= $seg ?>],
          series: [<?= $serie ?> ]
        }, {
  distributeSeries: true,
  
  height:'200px',
  seriesBarDistance: 1,
}).on('draw', function(data) {
  var barHorizontalCenter, barVerticalCenter, label, value;
  if (data.type === "bar") {
    barHorizontalCenter = data.x1 + (data.element.width() * .5);
    barVerticalCenter = data.y1 + (data.element.height() * -1) - 10;
    value = data.element.attr('ct:value');
    if (value !== '0') {
      label = new Chartist.Svg('text');
      label.text(euro(value));
      label.addClass("ct-barlabel");
      label.attr({
        x: barHorizontalCenter,
        y: barVerticalCenter,
        'text-anchor': 'middle'
      });
      return data.group.append(label);
    }
  }
});*/
      }
      
    </script>
  </head>
  <body>
    <br />
    <div style="width:100%">
      <div style="width:33%;float:left">
        <h5 style="text-align:center;">Meta de faturamento Mensal</h5>
        <div class="ct-chart ct-golden-section ct-negative-labels" id="goal"></div>
      </div>
      <div style="width:66%;max-height: 317px;float:left;">
        <h5 style="text-align:center;">Tendencias</h5>
        <div class="box-chart">
       <canvas id="goal3" height="268" width="890" ></canvas>

      </div>
        <!-- <div class="ct-chart ct-golden-section ct-negative-labels" style="height:275px" id="goal3"></div>-->
      </div>
      <div style="width:33%;float:left;clear:left">
        <h5 style="text-align:center;">Meta de faturamento diária</h5>
        <div class="ct-chart ct-golden-section ct-negative-labels" id="goal4"></div>
      </div>
      <div style="width:66%;float:left">
        <h5 style="text-align:center;">Faturamento por segmento</h5>
        <div class="box-chart">
       <canvas id="goal2" height="268" width="890" ></canvas>

      </div>
        <!-- <div class="ct-chart ct-golden-section ct-negative-labels" id="goal2"></div> -->
      </div>
    </div>
  </body>
</html>