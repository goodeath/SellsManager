<?php



  namespace controller;
  //Query to database, max execution time. 0 = no limit;
  ini_set('max_execution_time', 0);
class field extends bean implements database{

  private $query;
  public $name;
  public $field = "sum(VALOR_TOTAL)";
  # Define table to pdo
  protected $table = "vendas_view";
  private $debug;
  protected $db;
  protected $view;
  protected $route;

  #######################################
  /*
    Construct function separates fields
  get the table column, generates the
  conditions to query at database. With
  all this, other child classes can
  execute your procedures             */
  #######################################

  #######################
  ## ~~ Constructor ~~ ##
  #######################

  public function __construct($campos = null){
    # Initialize DB class
    $this->db = new serviceDB($this);
    if(!is_array($campos)) return false;
    # Group fields by type
    $fields = $this->separate($campos);
    # Get the query based in filters
    $this->checkFields($fields);
    # If exists two type fields, check table
    isset($fields[1]) ? $this->checkTable($fields[1]) : '';
    # Check type of data
    $this->checkType();
  }

  //======================
  //    SET METHODS
  //======================

  /*
   * @Name: setTable.
   * @Desc: Set table name to query.
   * @Args: {String} $table.
   */

  public function setTable($table){ $this->table = $table; }

  //=======================
  //    GET METHODS
  //=======================

  /*
   * @Name: getTable.
   * @Desc: Return table name.
   */

  public function getTable(){ return $this->table; }

  /*
   * @Name: getQuery.
   * @Desc: Return generated query.
   */

  public function getQuery(){ return $this->query; }

  /*
   * @Name: getView.
   * @Desc: Return a file path to the view.
   */

  public function getView() { return $this->view; }

  #########################
  ##    OTHER METHODS    ##
  #########################

  /*
   * @Name: separate
   * @Desc: Return an array with $a[category] = {v1,v2,v3} type.
   * @Args: {Array} $data
   */

  protected function separate(array $data){

    # Initialize an array
    $fields = [];
    # :: Foreach :: #
    foreach($data as $key => $value){
      # Separate category with value
      $campos = explode("-",$value);
      # If key exists in array $fields
      if(array_key_exists($campos[0],$fields))
          $fields[$campos[0]] .= ",'".$campos[1]."'";
      else
        $fields[$campos[0]] = "'".$campos[1]."'";
    }
    # Return array com category and values
    return $fields;
  }

  /*
   * @Name: checkTable
   * @Desc: Get a group of items base in a column name
   * @Args: {array} $value
   */

  protected function checkTable($value)
  {
    switch($value){
      case "Clientes":
        $tableField = "CLIENTE"; $nameFilter = "Cliente(s)";break;
      case "Produtos":
        $tableField = "DESCRICAO"; $nameFilter = "Produto(s)";break;
      case "Grupos":
        $tableField = "GRUPO"; $nameFilter = "Grupo(s)";break;
      case "Linhas":
        $tableField = "LINHA"; $nameFilter = "Linha(s)";break;
      case "Marcas":
        $tableField = "FORNECEDOR"; $nameFilter = "Marca(s)";break;
      case "Unidades":
        $tableField = "UNIDADE"; $nameFilter = "Unidades(s)";break;
      case "Estado":
        $tableField = "ESTADO"; $nameFilter = "Estados(s)";break;
      case "Cidade":
        $tableField = "CIDADE"; $nameFilter = "Cidade(s)";break;
      case "Gerentes":
        $tableField = "LOJISTA"; $nameFilter = "Lojistas(s)";break;
      case "Representantes":
        $tableField = "VENDEDOR"; $nameFilter = "Vendedores(s)";break;
      case "Canais":
        $tableField = "CANAL"; $nameFilter = "Canais(s)";break;
      case "Segmentos":
        $tableField = "SEGMENTO"; $nameFilter = "Canais(s)";break;
    }

    $this->tabla = $tableField;
    $this->name = $nameFilter;
    return [$tableField,$nameFilter];
  }

  public function checkFields(array $fields){
    # Initialize var
    $cond = '';
    # ::Foreach:: #

    foreach($fields as $key=>$values){

      switch($key){
        case 'Clientes':
          $cond .= "CLIENTE in ({$fields['Clientes']}) and ";break;
        case 'Produtos':
          $cond .= "DESCRICAO in ({$fields['Produtos']}) and ";break;
        case 'Grupos':
          $cond .= "GRUPO in ({$fields['Grupos']}) and ";break;
        case 'Linhas':
          $cond .= "LINHA in ({$fields['Linhas']}) and ";break;
        case 'Região':
          $cond .= "REGIAOO in ({$fields['Região']}) and ";break;
        case 'Marcas':
          $cond .= "FORNECEDOR in ({$fields['Marcas']}) and ";break;
        case 'Segmentos':
          $cond .= "SEGMENTO in ({$fields['Segmentos']}) and ";break;
        case 'Canais':
          $cond .= "CANAL in ({$fields['Canais']}) and ";break;
        case 'Representantes':
          $cond .= "VENDEDOR in ({$fields['Representantes']}) and ";break;
        case 'Gerentes':
          $cond .= "LOJISTA in ({$fields['Gerentes']}) and ";break;
        case 'Cidade':
          $cond .= "CIDADE in ({$fields['Cidade']}) and ";break;
        case 'Estado':
          $cond .= "ESTADO in ({$fields['Estado']}) and ";break;
        case 'Unidades':
          $cond .= "UNIDADE in ({$fields['Unidades']}) and ";break;
      }

    }
    $this->query = $cond;
    return $cond;
  }

  protected function checkType(){
    isset($_REQUEST['Qntd']) ? $this->field = "sum(QUANTIDADE)" :
    $this->field = "sum(VALOR_TOTAL)";
  }

  protected function refresh_sells(){
    # Allows unlimited execution time
    ini_set('max_execution_time', 0);
    # Open file
    $myfile = fopen("controller/apps/get/exporta.txt", "r");
    # Initialize counter
    $x = 0;
    # :: While :: #
    while($file = fgets($myfile)){
      $array[$x] = explode(";",$file);
      ++$x;
    }
    $this->setTable("vendas");
    $this->db->delete();
    foreach($array as $key)
    {
      $dia = $key[17].'-'.$key[16].'-'.$key[15]." 00:00:00";
      $data = ["N"=>$key[0],"UNIDADE"=>$key[1],"ESTADO"=>$key[2],
          "CIDADE"=>$key[3],"REGIAO"=>$key[4],"LOJISTA"=>$key[5],
          "VENDEDOR"=>$key[6],"CANAL"=>$key[7],"SEGMENTO"=>$key[8],
          "FORNECEDOR"=>$key[9],"LINHA"=>$key[10],"GRUPO"=>$key[11],
          "DESCRICAO"=>$key[12],"CLIENTE"=>$key[13],"CORINGA"=>$key[14],
          "DIA"=>$key[15],"MES"=>$key[16],"ANO"=>$key[17],"VALOR_TOTAL"=>$key[18],
          "RENTABILIDADE"=>$key[19],"QUANTIDADE"=>$key[20],"CADASTRO"=>$key[21],
          "ENDERECO"=>$key[22],"cep"=>$key[23],"periodo"=>$dia];
      $this->db->insert($data);

    }
  }

  protected function refreshCity()
  {
    # Allows unlimited execution time
    ini_set('max_execution_time', 0);
    # Open file
    $myfile = fopen("controller/apps/get/cidade.txt", "r");
    # Initialize counter
    $x = 0;
    # :: While :: #
    while($file = fgets($myfile)){
      $array[$x] = explode("|",$file);
      ++$x;
    }
    $this->setTable("cidades");
    $this->db->delete();
     $translate = ['NaoClassificada'=>0,'R2'=>1,'R3'=>2, 'R4'=>3,'R5'=>15,'R6'=>4,'R7'=>5,'R8'=>6,'R9'=>7,'R10'=>8,'R11'=>9,'R12'=>10,'R13'=>11,'R14'=>12,'R15'=>13,'R16'=>14,'R17'=>16,'R18'=>17,'R19'=>18,'SSA'=>19,"RSSA"=>20];
    foreach($array as $key)
    {
        $a = preg_replace("/[^a-zA-Z0-9]/", '', $key[1]);
        $id = $translate[$a];
        $name = $key[0];


      $data = ['nome'=>$name,'cid_regiao'=>$id];
      $this->db->insert($data);

    }
  }

  protected function refreshllVen()
  {
    # Allows unlimited execution time
    ini_set('max_execution_time', 0);

    # Open file
    $myfile = fopen("controller/apps/get/mailingGeral.csv", "r");
    # Initialize counter
    $x = 0;
    # :: While :: #
    while($file = fgets($myfile)){
      $array[$x] = explode(",",$file);
      $c = preg_replace("/[\"]/","",$array[$x][0]);
      $cache[$c] = $array[$x][1];
      ++$x;

    }

    $myfile = fopen("controller/apps/get/Reagendar.csv", "r");
    # Initialize counter
    $x = 0;
    # :: While :: #

    while($file = fgets($myfile)){
      $file = preg_replace("/[^0-9]/","", $file);
      $array2[$x] = $file;

      if(isset($cache[$file]))
      {
        $client = $cache[$file];
        echo "\"$file\",$client"."<br />";
      }
      ++$x;
    }

  }

  protected function refreshVen()
  {
    # Allows unlimited execution time
    ini_set('max_execution_time', 0);
    ini_set('memory_limit',-1);
    # Open file
    $myfile = fopen("controller/apps/get/exporta.txt", "r");
    # Initialize counter
    $x = 0;
    # :: While :: #
    while($file = fgets($myfile)){
      $array[$x] = explode(";",$file);
      ++$x;
    }

    $string = '<table class="bordertable" style="font-family:Arial"><thead><th>Vendedor</th><th>Valor da venda</th><th>Data</th><th>Cidade</th></thead><tbody>';
    $tmp =[];
    # Current day
    $currentDay = date("d");
    # Current month
    $currentMonth = date("m");
    # Current year
    $currentYear = date("Y");
    # Day|Month Sum
    $daySumTotal =  $monthSumTotal = 0;

    foreach($array as $key)
    {

      if(isset($_GET['vendedor']) && $_GET['vendedor'] != $key[6]){continue; }

      $dias = $key[17].'-'.$key[16].'-'.$key[15];

      $data = ["N"=>$key[0],"UNIDADE"=>$key[1],"ESTADO"=>$key[2],
          "CIDADE"=>$key[3],"REGIAO"=>$key[4],"LOJISTA"=>$key[5],
          "VENDEDOR"=>$key[6],"CANAL"=>$key[7],"SEGMENTO"=>$key[8],
          "FORNECEDOR"=>$key[9],"LINHA"=>$key[10],"GRUPO"=>$key[11],
          "DESCRICAO"=>$key[12],"CLIENTE"=>$key[13],"CORINGA"=>$key[14],
          "DIA"=>$key[15],"MES"=>$key[16],"ANO"=>$key[17],"VALOR_TOTAL"=>$key[18],
          "RENTABILIDADE"=>$key[19],"QUANTIDADE"=>$key[20],"CADASTRO"=>$key[21],
          "ENDERECO"=>$key[22],"cep"=>$key[23],"periodo"=>$dias];
      $ano = $data['ANO'];
      $mes = $data['MES'];
      $dia = $data['DIA'];
      $nota = $data['N'];
      $valort = $data['VALOR_TOTAL'];
      $vendedor = $data['VENDEDOR'];
      $city = $data['CIDADE'];


      # Sellers
      if($data['ANO'] == date("Y") && $data["MES"] == date("n")){$p[$data['VENDEDOR']] = 0;}


      if($mes == $currentMonth && $ano == $currentYear)
      {
          if(isset($tend[$dia])){
            $tend[$dia] += $valort;
          }else{
            $tend[$dia] = $valort;
          }


          $monthSumTotal += $valort;
          if(isset($monthSegSum[$data['GRUPO']])){
            $monthSegSum[$data['GRUPO']] += $valort;
          }else{
            $monthSegSum[$data['GRUPO']] = $valort;
          }

          if($dia == $currentDay)
          {
              $daySumTotal += $valort;
          }

      }

      if(isset($tmp[$ano][$mes][$dia][$nota]))
      {


            $tmpValue =  $valort + $tmp[$ano][$mes][$dia][$nota]['total'];
            $tmp[$ano][$mes][$dia][$nota]['total'] = $tmpValue;
      }else
      {
        $tmp[$ano][$mes][$dia][$nota]['vendedor'] = $vendedor;
        $tmp[$ano][$mes][$dia][$nota]['total'] = $valort;
        $tmp[$ano][$mes][$dia][$nota]['date'] = $dias;
        $tmp[$ano][$mes][$dia][$nota]['date2'] = date("d/m/Y",strtotime($dias));
        $tmp[$ano][$mes][$dia][$nota]['city'] = $city;
      }


    }

    krsort($tmp);
    $tmp = array_reverse($tmp);
    $tmp = array_reverse($tmp);
    for($x=0;$x<count($tmp);$x++)
    {
      krsort($tmp[$x]);
      for($y=1;$y < 13; $y++)
      {
        if(isset($tmp[$x][$y]))
        {
          krsort($tmp[$x][$y]);
        }
      }

    }


    #krsort($tmp[0]);
    #krsort($tmp[0][9]);

    foreach($tmp as $key=>$value)
    {
      foreach($value as $key2 => $value2)
      {
        foreach($value2 as $key3 =>$value3 )
        {
          foreach($value3 as $key4 =>$value4)
          {
            $today = date("d");
            $i = date("d",strtotime($value4['date']));
            if($today == $i){$cl = "style='background-color:blue;color:silver;'";}
            else{$cl = null;}
            $string .= "<tr $cl><td>{$value4['vendedor']}</td><td>R\$ {$value4['total']}</td><td>{$value4['date2']}</td><td>{$value4['city']}</td></tr>";
          }

        }
      }
    }
    $string .= "</tbody></table>";

    $monthGoal = 450000;

    $dayGoal = $this->dayGoal($monthGoal,$monthSumTotal);

    #echo "<h4>Valor total do mês: R$".$monthSumTotal."</h4>";
   # echo "<h4>Meta total do mês: R$".$monthGoal."</h4>";
   # echo "<h4>Valor total do dia: R$".$daySumTotal."</h4>";
   # echo "<h4>Meta total do dia: R$".$dayGoal."</h4>";

    return [$monthGoal,$monthSumTotal,$string,$monthSegSum,$p,[$dayGoal,$daySumTotal],$tend];

  }

  public function dayGoal($monthGoal,$monthSumTotal)
  {
    $today = date("d");
    $lastDay = date("t");
    $diffDays = $lastDay - $today;
    $diffValues = $monthGoal - $monthSumTotal;
    $dayGoal = round($diffValues/$diffDays,2);

    return $dayGoal;
  }
  ########################################
    ##       Get and separe periods       ##
    ########################################

    public function  getPeriod($date)
    {
      $periodos = period::getPeriod($date);
      $this->periodos = $periodos;
      return $periodos;
    }

}


?>
