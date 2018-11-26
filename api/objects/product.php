<?php
class Product{
 
    // database connection and table name
    private $conn;
    private $table_name = "barcodes";
 
    // object properties
    public $id;
    public $machine;
    public $nc12;
    public $sfc;
    public $dt;
    public $start;
    public $finish;
    public $ct;

     
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }

    // read products
    function read(){
    
        // select all query
        $query = "SELECT
                    Id as id, Maszyna as machine, nc as nc12, Barcode as sfc, CzasSkanu as dt
                FROM
                    " . $this->table_name . "
                ORDER BY
                    dt ASC
                LIMIT 10";
        
        // prepare query statement
        $stmt = $this->conn->prepare($query);
    
        // execute query
        $stmt->execute();
    
        return $stmt;
    }

    function readMultiple(){
    
        // select all query
        $query = "SELECT
                    Id as id, Maszyna as machine, nc as nc12, Barcode as sfc, CzasSkanu as dt
                FROM
                    " . $this->table_name . "
                WHERE (CzasSkanu > ? AND CzasSkanu < ?)
                ORDER BY
                    id ASC;
                ";
        
        // prepare query statement
        $stmt = $this->conn->prepare($query);
    
         // bind id of product to be updated
         $stmt->bindParam(1, $this->start);
         $stmt->bindParam(2, $this->finish);

        // execute query
        $stmt->execute();
    
        return $stmt;
    }

    // used when filling up the update product form
    function readOne(){
 
        // query to read single record
        // select all query
        $query = "SELECT
                Id as id, Maszyna as machine, nc as nc12, Barcode as sfc, CzasSkanu as dt
            FROM
                " . $this->table_name . "
            WHERE
                id = ?
            LIMIT 0,1";
 
            // prepare query statement
            $stmt = $this->conn->prepare( $query );
        
            // bind id of product to be updated
            $stmt->bindParam(1, $this->id);
        
            // execute query
            $stmt->execute();
        
            // get retrieved row
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
            // set values to object properties
            $this->id = $row['id'];
            $this->machine = $row['machine'];
            $this->sfc = $row['sfc'];
            $this->nc12 = $row['nc12'];
            $this->dt = $row['dt'];
        }
}
?>