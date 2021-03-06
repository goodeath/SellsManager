<!DOCTYPE html>
<html lang='pt-br'>
  <head>
    <title>Gerenciador de Vendas</title>
    <meta charset='UTF-8' />
    <link rel="stylesheet" type="text/css" href="/vendas/view/css/main.css" />
    <link rel="stylesheet" type="text/css" href="/vendas/view/css/bootstrap3.3.6/css/normalize.css" />
    <link rel="stylesheet" type="text/css" href="/vendas/view/css/bootstrap3.3.6/css/bootstrap.min.css" />
    <script src="/vendas/view/js/general.js"></script>
    <script src="/vendas/view/js/ajax.js"></script>
    <script src="/vendas/view/js/navButtons.js"></script>
  </head>
  <body>
    <!------------------------ Inclui o header da página ------------------------>
    <?php require_once HEADER; ?>
    
    <!------------------------ Identifica visualmente o gráfico escolhido ------------------------>
    <script>active(7)</script>
    
    <!------------------------ Period ----------------------->
    <div id="fields">
      <!------------------------ Period A ------------------------>
      Período A: <input type='date' min="2000-01-01" /> à <input type='date' min="2000-01-01" /> 
      <!------------------------ Period B ------------------------>
      Período B: <input type='date' min="2000-01-01" /> à <input type='date' min="2000-01-01" />
    </div>
    <!------------------------ Periods ----------------------->
    
    <div id="wrapper">
      <?php
        # Include left nav
        require_once NAV2;
        # Include center select
        require_once CENTERNAV; 
      ?>
      <!----------------------- Right nav ----------------------->
      <div id="show">
       <form name="dados" method="POST" id="sendData" action="Grafico/">
          <select id='items' class="double" multiple="multiple" name="campos[]"></select>
          <select id='items2' class="double" multiple="multiple" name="campos2"></select>
          <input type='hidden' value='' name='date' />
          <input type='hidden' value='' name='date2' />
          <input type="submit" class="btn btn-success" id='submit' value="Gerar análises" />  
          <input type="reset" class="btn btn-danger" value="Deletar" id="delete"/>   
        </form>
      </div>
      <?php require_once NAV3;# Include bottom nav?>
    </div>
  </body>
</html>