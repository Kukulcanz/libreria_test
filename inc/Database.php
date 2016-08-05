<?php

   $host="localhost";
   $database="libreria";
   $user="root";
   $pass="";
   
   
    define("DB_HOST", $host);
    define("DB_USER", $user);
    define("DB_PASS", $pass);
    define("DB_NAME", $database ); 

class Database{
 
    private $host      = DB_HOST;
    private $user      = DB_USER;
    private $pass      = DB_PASS;
    private $dbname    = DB_NAME;
 
    private $dbh;
    public $error;
 
    private $stmt;
    
    
    public function __construct(){
        // Set DSN
        $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->dbname;
        // Set options
        $options = array(
            PDO::ATTR_PERSISTENT    => true,
            PDO::ATTR_ERRMODE       => PDO::ERRMODE_EXCEPTION
        );
        
        // Create a new PDO instanace
        try{
            $this->dbh = new PDO($dsn, $this->user, $this->pass, $options);
        }
        // Catch any errors
        catch(PDOException $e){
            $this->error = $e->getMessage();
        }
        
    }

    public function close(){
        $this->dbh=null;
        return true;
    }
    
    
    public function query($query){
        $this->stmt = $this->dbh->prepare($query);
    }
    
    public function bind($param, $value, $type = null){
        if (is_null($type)) {
            switch (true) {
                case is_int($value):
                    $type = PDO::PARAM_INT;
                    break;
                case is_bool($value):
                    $type = PDO::PARAM_BOOL;
                    break;
                case is_null($value):
                    $type = PDO::PARAM_NULL;
                    break;
                default:
                    $type = PDO::PARAM_STR;
            }
        }
        $this->stmt->bindValue($param, $value, $type);
    }
    
    public function execute(){
        return $this->stmt->execute();
    }    

    public function resultset(){
        $this->execute();
        return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
    }    

    public function single(){
        $this->execute();
        return $this->stmt->fetch(PDO::FETCH_ASSOC);
    }    

    public function rowCount(){
        return $this->stmt->rowCount();
    }    

    public function lastInsertId(){
        return $this->dbh->lastInsertId();
    }    
    
    public function beginTransaction(){
        return $this->dbh->beginTransaction();
    }    
    
    public function endTransaction(){
        return $this->dbh->commit();
    }    
    
    public function debugDumpParams(){
        
        return $this->stmt->debugDumpParams();
    }    
    
    /*
        // esempi d'uso
		
        // INSERT
        $database = new Database();
        $database->query('INSERT INTO mytable (FName, LName, Age, Gender) VALUES (:fname, :lname, :age, :gender)');
        $database->bind(':fname', 'John');
        $database->bind(':lname', 'Smith');
        $database->bind(':age', '24');
        $database->bind(':gender', 'male');
        $database->execute();
        echo $database->lastInsertId();
     
        // insert con transazione
        $database->beginTransaction();
        $database->query('INSERT INTO mytable (FName, LName, Age, Gender) VALUES (:fname, :lname, :age, :gender)');
        $database->bind(':fname', 'Jenny');
        $database->bind(':lname', 'Smith');
        $database->bind(':age', '23');
        $database->bind(':gender', 'female');
        $database->execute();
        $database->bind(':fname', 'Jilly');
        $database->bind(':lname', 'Smith');
        $database->bind(':age', '25');
        $database->bind(':gender', 'female');
        $database->execute();
        echo $database->lastInsertId();
        $database->endTransaction();
     
        // select riga singola
        $database->query('SELECT FName, LName, Age, Gender FROM mytable WHERE FName = :fname');
        $database->bind(':fname', 'Jenny');
        $row = $database->single();
        echo "<pre>";
        print_r($row);
        echo "</pre>";

        // select a riga multipla
        $database->query('SELECT FName, LName, Age, Gender FROM mytable WHERE LName = :lname');
        $database->bind(':lname', 'Smith');
        $rows = $database->resultset();
        echo "<pre>";
        print_r($rows);
        echo "</pre>";
        echo $database->rowCount();
     
    */
}

?>
