<?php
  
  ##########################################
  ##                                      ##
  ##  Created by Alex Anderson            ##
  ##  Date: 06/05/2015                    ##
  ##  Contact: alexandersonbm@hotmail.com ##
  ##                                      ##
  ##########################################
  namespace controller\participation;

  class mainView extends main
  {
    public function viewParticipation()
    {
      session_start();
      //Array of fields
      $fields = [$_POST['campos'],$_POST['campos2']];
      $date = $_POST['date'];
      
      $this->setFielda($fields);
      $data = $this->participation($date);
      
      $string = $data[0];
      $valores = $data[1];
      $valores2 = $data[2];

      $_SESSION['fields'] =  $fields;
      $_SESSION['date'] = $date;
      require_once $this->getView();
    }
  }

?>