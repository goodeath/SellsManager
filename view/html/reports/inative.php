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

    <script>active(6)</script>
    
    <!------------------------ Period ------------------------>
    <div id="fields">
      Inatividade com base em:<br/> 
      <input type="date" id="date1"> á <input type="date" id="date2" >
      R$<input type="text" id="limit" style="margin-left:0%;"
       placeholder="Digite um valor minimo para ser considerado ativo">
    </div>
    <!------------------------ Period ------------------------>
        
    <div id="wrapper">
      <?php
        # Include left nav
        require_once NAV2;
        # Include center select
        require_once CENTERNAV; 
      ?>

       <div id="show">
        <form name="dados" method="POST" id="sendData" action="Grafico/">
          <select id='items' class="double" multiple="multiple" name="campos[]"></select>
          <select id='items2' class="double" multiple="multiple" name="campos2"></select>
          <input type='hidden' value='' name='date' />
          <input type='hidden' value='0' name='limit' />
          <input type="submit" class="btn btn-success" id='submit' value="Gerar análises" />  
          <input type="reset" class="btn btn-danger" value="Deletar" id="delete"/>   
        </form>
      </div>
      <?php require_once NAV3;# Include bottom nav?>
    </div>
  </body>
</html>