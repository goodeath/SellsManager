<?php

  # Initialize controller
  $route = new \controller\routes();
  # add routes
  $route->addRoute("",VIEW."html/index.php")
        ->addRoute("Evolucao",VIEW."html/reports/evolution.php","evolution\\main","Evolution")
        ->addRoute("Evolucao/Detalhes",VIEW."html/reports/evolution/values.php")
        ->addRoute("Comparacao",VIEW."html/reports/comparison.php")
        ->addRoute("Comparacao/Grafico",VIEW."html/reports/comparison_graph.php","comparison\\main","Comparison")
        ->addRoute("Fotografe",VIEW."html/reports/fotografe.php")
        ->addRoute("Fotografe/Grafico",VIEW."html/reports/fotografe_graph.php","fotografe\\main","fotografe")
        ->addRoute("Participacao",HTML."reports/participation.php")
        ->addRoute("Participacao/Grafico",VIEW."html/reports/participation_graph.php","participation\\main","Participation")
        ->addRoute("Movimentos",VIEW."html/reports/moves.php")
        ->addRoute("Movimentos/Grafico",VIEW."html/reports/moves_graph.php","moves\\main","moves")
        ->addRoute("Tendencias",VIEW."html/reports/trend.php")
        ->addRoute("Tendencias/Grafico",VIEW."html/reports/trend_graph.php","trend\\main","trend")
        ->addRoute("Ranking",VIEW."html/reports/ranking.php")
        ->addRoute("Ranking/Grafico",VIEW."html/reports/ranking_graph.php","ranking\\main","ranking")
        ->addRoute("Inativo",VIEW."html/reports/inative.php")
        ->addRoute("Inativo/Grafico",VIEW."html/reports/inative_graph.php","inative\\main","inative")
        ->addRoute("Atualizar",VIEW."html/index.php","field","refresh")
        ->addRoute("VendasDia",VIEW."html/bi/index.php","field","VendasDia")
        ->addRoute("bi/lista",VIEW."html/bi/list.php","field","vendasdia")
        ->addRoute("bi/geral",VIEW."html/bi/general.php","field","vendasdia")
         ;



  # Get route
  $data = $route->getRoute($uri);
  if(isset($data[2])){

    $class = $data[2];
    # Controller
    $controller = new $class();
    #set route;
    $controller->setRoute($route);
    # Action
    $controller->{$data[3]}();


  }else{

    require_once $data[0];
  }



?>
