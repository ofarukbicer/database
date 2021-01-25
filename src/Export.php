<?php

namespace Database;
use \PDO;

class Export{
    public $tables;
    public $create;
    public $detail;
    public $columns;
    public $sql = "/* {{time}} Backup createby: omerfarukbicer0446 */\n";
    private $conn;
    
    /*
    * @param $conn
    */
    public function __construct($conn,$timezone = 'Europe/Istanbul')
    {
        $this->conn = $conn;
        date_default_timezone_set($timezone);
        $this->sql = str_replace("{{time}}",date('d/m/Y H:i:s'),$this->sql);
        $this->getTables();
        return $this;
    }

    private function getTables()
    {
        // SHOW TABLES
        $showTables = $this->conn->query("SHOW TABLES");
        $tables = $showTables->fetchAll(PDO::FETCH_ASSOC);
        $tablesKey = "Tables_in_" . $this->conn->dbName;
        foreach ($tables as $value) {
            $this->tables[] = $value[$tablesKey];
        }

        // SHOW CREATE TABLE *
        foreach ($this->tables as $value) {
            $showCreateTable = $this->conn->query("SHOW CREATE TABLE $value");
            $show = $showCreateTable->fetch(PDO::FETCH_ASSOC);
            $this->create[$value] = $show["Create Table"].';';
        }

        $columns = [];
        foreach ($this->create as $key => $value) {
            $this->sql .= $value . "\n\n";
            
            $showTable = $this->conn->query("SELECT * FROM $key");
            $show = $showTable->fetchAll(PDO::FETCH_ASSOC);
            if ($show != []) {
                $showColumns = $this->conn->query("SHOW COLUMNS FROM $key");
                $columns[$key] = $showColumns->fetchAll(PDO::FETCH_ASSOC);
                
                foreach ($columns[$key] as $a => $value) {
                    $this->columns[$a] = $value['Field'];
                }

                $this->sql .= "INSERT INTO `$key` (";
                for ($b=0; $b < count($this->columns); $b++) { 
                    $this->sql .= "`".$this->columns[$b]."`";
                    if ((count($this->columns) - $b) != 1) {
                        $this->sql .= ", ";
                    }
                }
                $this->sql .= ") VALUES\n";
                $detail = $this->conn->query("SELECT * FROM $key");
                $this->detail[$key] = $detail->fetchAll(PDO::FETCH_ASSOC);
                $i = 0;
                
                foreach ($this->detail[$key] as $value) {
                    ++$i;
                    $this->sql .= "(";
                    $value = array_values($value);
                    for ($c=0; $c < count($value); $c++) { 
                        if (gettype($value[$c]) == "integer") {
                            $this->sql .= $value[$c];
                        }else if(gettype($value[$c]) == "string"){
                            $this->sql .= "'".$value[$c]."'";
                        }
                        
                        if ((count($value) - $c) != 1) {
                            $this->sql .= ", ";
                        }
                    }
                    $this->sql .= ")";
                    if (count($this->detail[$key]) === $i) {
                        $this->sql .= ";";
                    }else {
                        $this->sql .= ",";
                    }
                    $this->sql .= "\n";
                }
                $this->sql .= "\n";
            }
        }
        return $this;
    }

    public function show()
    {
        return $this->sql;
    }

    public function run($folder,$download = false)
    {
        // Create DIR
        if (!file_exists($folder)) {
            mkdir($folder);
        }

        // Create File
        touch($folder.'/'.date('d-m-Y-H-i-').time().'-'.$this->conn->dbName.'.sql');

        // File write
        $fileOpen = fopen($folder.'/'.date('d-m-Y-H-i-').time().'-'.$this->conn->dbName.'.sql', 'w');
        if (fwrite($fileOpen, $this->sql)) {
            if ($download) {
                header("content-type: sql");
                header("content-disposition: attachment; filename=".date('d-m-Y-H-i-').time().'-'.$this->conn->dbName.'.sql');
                echo $this->sql;
            }
            return true;
        }else {
            return false;
        }
        fclose($fileOpen);

        
    }
}