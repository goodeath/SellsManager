<!DOCTYPE html>
<html lang='pt-br'>
  <head>
    <title>Gerenciador de Vendas</title>
    <meta charset='UTF-8' />
    <link rel='stylesheet' type='text/css' href='/vendas/view/css/yaml/add-ons/accessible-tabs/tabs.css'>
    <link rel='stylesheet' type='text/css' href='/vendas/view/css/yaml/core/base.css'>
    <link rel='stylesheet' type='text/css' href='/vendas/view/css/yaml/screen/typography.css'>
    <link rel='stylesheet' type='text/css' href='/vendas/view/css/bi.css'>
    <script src="/vendas/view/js/jquery-2.1.4.min.js"></script>
    <script src="/vendas/view/css/yaml/add-ons/accessible-tabs/jquery.tabs.js"></script>
    <script>
        $(document).ready(function(){
            $('.jquery_tabs').accessibleTabs();
        });
    </script>
  </head>
  <body>
      <div class="jquery_tabs">
        <h4>Geral</h4>
        <div class="tabbody">
          <object data="/vendas/bi/geral/"></object>
        </div>
        <?= $menus ?>
        <h4>Listagem</h4>
        <div class="tabbody">
          <object data="/vendas/bi/lista/"></object>
        </div>
      </div>
  </body>
</html>