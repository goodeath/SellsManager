<?php
  
  ##########################################
  ##                                      ##
  ##  Created by Alex Anderson            ##
  ##  Date: 06/05/2015                    ##
  ##  Contact: alexandersonbm@hotmail.com ##
  ##                                      ##
  ##########################################
  
  namespace controller\trend;

  class mainView extends main
  {
    protected $item;
    protected $item2;
    public $total;
    public $lastDate;
    public $firstDate;
    protected $period;

 
  
  public function viewTrend()
  {
    session_start();
    $fields = [$_POST['campos'],$_POST['campos2']];
    $date = $_POST['date'];

    ###########################################
    ##           Retrieve Data               ##
    ###########################################

    //Initialize
    $this->old_cons($fields,$date);

    //Get data
    $lista = $this->trend();

    //Get items separateds by categories
    $registros = $lista[1];

    //Get a list of items
    $lista = $lista[0];

    $nameFilter = $this->name;

    ###########################################
    ##               Sessions                ##
    ########################################### 
    $_SESSION['campos'] = $fields;
    $_SESSION['datas'] = $date;

  ////////////////////////////////////////////////

  $inativo = count($lista['more']);
  $recuperado = count($lista['equal']);
  $constante = count($lista['less']);
  isset($lista['noHistory']) ? $novos = count($lista['noHistory']) : $novos = '0';
  require_once $this->getView();
  }
}

?>