<?php 
  namespace controller;
    interface database{
    

    public function setTable($table);
    public function getTable();
  }

  class serviceDB{

    private $db; # PDO Object
    private $obj; # An any object 
    private $field = "*"; # Field to search

    #######################
    ## ~~ Constructor ~~ ##
    #######################
    
    public function __construct(database $obj,\PDO $db = null){
      if(!$db){
       // $db = new PDO("mysql:host=localhost;dbname=cegdi764_ceg","cegdi764_ti",'alex623589',[ PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    //PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"]);
        $db = new \PDO("mysql:host=localhost;dbname=cegdi764_banco1","root",'',[ \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
      \PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"]);
      }
      $this->db = $db;
      $this->obj = $obj;
    }

    #######################
    ##    SET METHODS    ##
    #######################
    
    public function setField($field){
      $this->field = $field;
    }
    
    #########################
    ##    OTHER METHODS    ##
    #########################
    
     /* @Function: read
     *  @Parameters: first   -> Query condition.
     *             all next -> Bind values.
     *  @Description: Read a table on database and
     *  return all matches.
    */
    
    public function read(){
      # Get all argument.
      $args = func_get_args();
      # If has a condition.
      if(isset($args[0])){
        # Add clause where.
        $cond = "WHERE {$args[0]}";
        # Get first position of bind value.
        $index = strpos($args[0],":");
      }
      else{
        # If hasn't condition, $cond = null.
        $cond = null;
      }
      # Query
      $q = "SELECT {$this->field} FROM {$this->obj->getTable()} {$cond}";
      
      # PDO Statement
      $stmt = $this->db->prepare($q);

      if(isset($args[0])){
        foreach($args as $key => $value){
          if($value === $args[0]) continue;

          $end = strpos($args[0]," ",$index);
          $end = $end-$index;

          if($end > 0){
            $bindKey = substr($args[0],$index,$end);
          }else{
            $bindKey = substr($args[0],$index);
          }

          $stmt->bindValue($bindKey,$value);

          $index = $index+1;

          $index = strpos($args[0],":",$index);
        }
      }
      # Execute query
      $stmt->execute();
      # Return all rows
      return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function delete($cond = null){
      # If has a condition.
      if($cond){
        # Add clause where.
        $cond = "WHERE {$cond}";

      }
      else{
        # If hasn't condition, $cond = null.
        $cond = null;
      }
      # Query
      $q = "DELETE FROM {$this->obj->getTable()} {$cond}";
      # PDO Statement
      $stmt = $this->db->prepare($q);
      # Execute query
      $stmt->execute();

    }
    
    public function update($data,$cond){
      try{
        
      foreach($data as $key=>$value){
        if(empty($value)) unset($data[$key]);
      }
      $str = '';
      $y = count($data);$x = 0;

      foreach($data as $key=>$value){
        
        ++$x;
        if($value != "null"){
          $str .= "$key = '$value'";
        }else{
          $str .= "$key = $value";
        }
        
        if($x == $y)continue;
        $str .= ",";
        
      }
      # Query
      $q = "UPDATE {$this->obj->getTable()} SET {$str} WHERE {$cond} ";
      echo $q;
      # PDO Statement
      $stmt = $this->db->prepare($q);
      if($stmt->execute()){
        return true;
      }else{
        return false;
      }
      } catch (\PDOException $ex) {
        # Exhibe an expection
        $msg = $ex->getMessage();
        echo $msg;
      }
    } 
    
    /* Function: insert
     * Parameters: $data   -> Data to insert.
     * Description: Insert data in a table on database.
    */
    
    public function insert(array $data){
      try{ 
        # Get keys format ( COLUMNS )
        $keys = $this->separateKeys($data);
        # Get values format ( VALUES )
        $values = $this->separateValues($data);
        # Get query
        $q = "INSERT INTO {$this->obj->getTable()} ({$keys}) VALUES ({$values})";
        
        # Prepare query
        $stmt = $this->db->prepare($q);
        # Bind all values
        foreach ($data as $key => $value) {
          # Bind value
          $stmt->bindValue(":".$key,$value);  
        }
        # Run query
        if($stmt->execute()){
          return true;
        }
      }catch(\PDOException $e){
        # Exhibe an expection
        $msg = $e->getMessage();
        $code = $e->errorInfo[1];
        $file = explode("\\",$e->getFile());
        $file = $file[count($file)-1];
        $line = $e->getLine();
        switch($code){
          case 1062:
            preg_match_all("/(\'[a-zA-Z0-9\.\@]+\')/",$msg,$ar);
            echo "O valor {$ar[0][0]} é uma entrada duplicada para o campo {$ar[0][1]}";
            break;
          case 1048:
            preg_match_all("/(\'[a-zA-Z0-9\.\@]+\')/",$msg,$ar);
            echo "A coluna {$ar[0][0]} não pode ser nula";
            break;
          default:
            echo "Erro desconhecido: {$msg} ";
        }
        echo "<br /> Arquivo: {$file} <br /> Linha: {$line} <br /><br />";
        
        #echo "<pre>";
        
        #print_r($e);
        #echo "</pre>";exit();
      }
      
      
    } 

    public function storedProcedure($call){
      try{ 
        # Get query
        $q = "$call";
        # prepare query
        $stmt = $this->db->prepare($q);
        # Run query
        if($stmt->execute()){
          return true;
        }
      }catch(\PDOException $e){
        echo $e;  
      }
      
      
    } 


     public function separateKeys($data){
      # 
      $gotKeys = array_keys($data);
      #
      $keys = implode(',',$gotKeys);
      #
      return $keys;
    }

    public function separateValues($data){
      # 
      $gotValues = array_keys($data);
      #
      $val = ":".implode(", :", $gotValues);
      #
      return $val;
    }


  }
//  define('USER', "cegdi764_ti");;;
//define('SERVER', "localhost");
//define('PASSWORD', "alex623589");
//define('DB',"cegdi764_ceg");
//// define('USER', "root");
//// define('SERVER', "127.0.0.1");
//// define('PASSWORD', "");
//// define('DB',"cegdistribuidora");
//define('USER2', "cegdi764_phpl1");
//define('SERVER2', "localhost");
//define('PASSWORD2', "vGKviJDmBm7Dfx");
//define('DB2',"cegdi764_phpl1");
 ?>
