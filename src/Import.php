<?php

namespace Database;

class Import{
    public $query;
    public $sql;
    private $conn;

    public function __construct($conn, $path)
    {
        $file = fopen($path, 'r');
        while($sql = fgets($file)){
            $this->sql .= $sql;
        }
        $this->query = array_filter(explode(";", $this->sql));
        for ($i=0; $i < count($this->query); $i++) { 
            if ($this->query[$i] == "\n\n") {
                unset($this->query[$i]);
            }else {
                if (strstr(substr($this->query[$i],0,60),'omerfarukbicer0446')) {
                    $this->query[$i] = substr($this->query[$i],61);
                }
                $this->query[$i] = str_replace("\n\n", "", $this->query[$i]);
                $this->query[$i] = str_replace("\n", "", $this->query[$i]);
            } 
        }
        $this->conn = $conn;
    }

    public function run()
    {
        foreach ($this->query as $value) {
            $query = $this->conn->query($value);
        }
        if ($query) {
            return true;
        }else {
            return false;
        }
    }
} 
