<?php
require_once __DIR__ . "/Db_conn.php";

class PdoMethods extends Db_conn {

    private $sth;
    private $conn;
    private $db;
    private $error;

    public function selectBinded($sql, $bindings){
        $this->error = false;

        try{
            $this->db_connection();
            $this->sth = $this->conn->prepare($sql);
            $this->createBinding($bindings);
            $this->sth->execute();
            $result = $this->sth->fetchAll(PDO::FETCH_ASSOC);
        }
        catch(PDOException $e){
            echo $e->getMessage();
            $result = 'error';
        }

        $this->conn = null;

        return $result;
    }

    public function selectNotBinded($sql){
        $this->error = false;

        try{
            $this->db_connection();
            $this->sth = $this->conn->prepare($sql);
            $this->sth->execute();
            $result = $this->sth->fetchAll(PDO::FETCH_ASSOC);
        }
        catch (PDOException $e){
            echo $e->getMessage();
            $result = 'error';
        }

        $this->conn = null;

        return $result;
    }

    public function otherBinded($sql, $bindings){
        $this->error = false;

        try{
            $this->db_connection();
            $this->sth = $this->conn->prepare($sql);
            $this->createBinding($bindings);
            $this->sth->execute();
            $result = 'noerror';
        }
        catch(PDOException $e) {
            echo $e->getMessage();
            $result = 'error';
        }

        $this->conn = null;

        return $result;
    }

    public function otherNotBinded($sql){
        $this->error = false;

        try{
            $this->db_connection();
            $this->sth = $this->conn->prepare($sql);
            $this->sth->execute();
            $result = 'noerror';
        }
        catch (PDOException $e){
            echo $e->getMessage();
            $result = 'error';
        }

        $this->conn = null;

        return $result;
    }

    private function db_connection(){
        $this->db = new Db_conn();
        $this->conn = $this->db->dbOpen();
    }

    private function createBinding($bindings){
        if (!is_array($bindings)) { return; }

        foreach($bindings as $value){
            $placeholder = $value[0] ?? null;
            $val         = $value[1] ?? null;
            $typeSpec    = $value[2] ?? 'str';

            if (is_int($typeSpec)) {
                $pdoType = $typeSpec; 
            } else {
                switch (strtolower((string)$typeSpec)) {
                    case 'int':
                    case 'integer': $pdoType = PDO::PARAM_INT; break;
                    case 'bool':
                    case 'boolean': $pdoType = PDO::PARAM_BOOL; break;
                    case 'null':    $pdoType = PDO::PARAM_NULL; break;
                    default:        $pdoType = PDO::PARAM_STR;  break; 
                }
            }

            // Use bindValue so callers can pass plain values (no references needed)
            $this->sth->bindValue($placeholder, $val, $pdoType);
        }
    }
      /* Compatibility wrapper so Date_time.php can call ->select($sql, $params)
     Accepts params like: [ [':name', $value, PDO::PARAM_*], ... ] or 'str'/'int' */
  public function select($sql, $params = []) {
    $this->error = false;
    try {
      $this->db_connection();
      $this->sth = $this->conn->prepare($sql);
      $this->createBinding($params);
      $this->sth->execute();
      $result = $this->sth->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
      echo $e->getMessage();
      $result = 'error';
    }
    $this->conn = null;
    return $result;
  }

}
?>
