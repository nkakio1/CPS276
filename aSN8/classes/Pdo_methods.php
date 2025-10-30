<?php
/* This class extends the database connection class and builds on it with PDO commands */
/* The database connection class can be stored outside of the example files so you cannot see the connection information. Also it is more secure */
require_once __DIR__ . "/Db_conn.php";

class PdoMethods extends Db_conn {

    private $sth;
    private $conn;
    private $db;
    private $error;

    /* This method is for all SELECT statements that need to have a binding to protect the data. 
       It will run the query and return the result as an associative array or an error string. */
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
            // Output the error message for classroom debugging. Remove if in production.
            echo $e->getMessage();
            $result = 'error';
        }

        // Close the database connection
        $this->conn = null;

        // Return record set (or 'error')
        return $result;
    }

    /* This function does the same as the above but does not need any binded parameters as no parameters are passed */
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

    /* Because only SELECT queries return a value, this method does all the rest: CREATE, UPDATE, DELETE */
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

    /* Creates a connection to the database */
    private function db_connection(){
        $this->db = new Db_conn();
        $this->conn = $this->db->dbOpen();
    }

    /* Creates the bindings */
    private function createBinding($bindings){
        if (!is_array($bindings)) { return; }

        foreach($bindings as $value){
            // Expected: [ placeholder, value, type ]
            $placeholder = $value[0] ?? null;
            $val         = $value[1] ?? null;
            $typeSpec    = $value[2] ?? 'str';

            // Map 'str'/'int'/etc OR accept PDO::PARAM_* directly
            if (is_int($typeSpec)) {
                $pdoType = $typeSpec; // already a PDO::PARAM_* constant
            } else {
                switch (strtolower((string)$typeSpec)) {
                    case 'int':
                    case 'integer': $pdoType = PDO::PARAM_INT; break;
                    case 'bool':
                    case 'boolean': $pdoType = PDO::PARAM_BOOL; break;
                    case 'null':    $pdoType = PDO::PARAM_NULL; break;
                    default:        $pdoType = PDO::PARAM_STR;  break; // 'str' and anything else
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
      // Reuse your existing binder (it already supports 'str'/'int' or PDO::PARAM_*)
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
