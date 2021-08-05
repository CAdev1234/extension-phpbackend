<?php

class DBConnection{
    public $db_server           = 'localhost';
    public $db_username         = 'root';
    public $db_password         = '';
    public $db_name             = 'chrome_dash';
    public $connec;

    public function __construct()
    {
        $this->connec = mysqli_connect($this->db_server, $this->db_username, $this->db_password, $this->db_name);
        if ($this->connec === false) {
            die("Error: Could not connect. " . mysqli_connect_error());
        }
    }

    public function createTable($tb_name, $table_field) {
        $sql            = 'CREATE TABLE $tb_name (id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,';
        for ($index = 0; $index < count($table_field); $index++) { 
            $sql        = $sql . $table_field[$index] . " VARCHAR(255) NOT NULL,";
        }
        mysqli_query($this->connec, $sql);
    } 

    public function insertQuery($tb_name, $field_array) {
        $sql            = "INSERT INTO $tb_name ";
        $index          = 0;
        $key_str        = '(';
        for ($index = 0; $index < count(array_keys($field_array)); $index++) { 
            if ($index === count(array_keys($field_array)) - 1) {
                $key_str = $key_str . array_keys($field_array)[$index] . ')'; 
            }else {
                $key_str = $key_str . array_keys($field_array)[$index] . ',';
            }
        }
        $val_str        = '(';
        for ($index = 0; $index < count(array_values($field_array)); $index++) { 
            if ($index === count(array_values($field_array)) - 1) {
                $val_str = $val_str . "'" . array_values($field_array)[$index] . "'" . ')'; 
            }else {
                $val_str = $val_str . "'" . array_values($field_array)[$index] . "'" . ',';
            }
        }
        $sql            = $sql . $key_str . ' VALUES ' . $val_str;
        $result = mysqli_query($this->connec, $sql);
        return mysqli_insert_id($this->connec);
    }

    public function updateQuery($tb_name, $field_array, $where_array) {
        $sql = "UPDATE $tb_name SET ";
        for($index = 0; $index < count(array_keys($field_array)); $index++) {
            if ($index === count(array_keys($field_array)) - 1) {
                $sql = $sql . array_keys($field_array)[$index] . "=" . "'" . array_values($field_array)[$index] . "'" . " WHERE ";
                for($indexi = 0; $indexi < count(array_keys($where_array)); $indexi++) {
                    if ($indexi === count(array_keys($where_array)) - 1) {
                        $sql = $sql . array_keys($where_array)[$indexi] . "=" . "'" . array_values($where_array)[$indexi] . "'";
                    }else {
                        $sql = $sql . array_keys($where_array)[$indexi] . "=" . "'" . array_values($where_array)[$indexi] . "'" . ",";
                    }
                }
            }else {
                $sql = $sql . array_keys($field_array)[$index] . "=" . "'" . array_values($field_array)[$index] . "'" . ",";
            }
        }
        mysqli_query($this->connec, $sql);
    }

    public function getAllQuery($tb_name) {
        $sql            = "SELECT * FROM $tb_name";
        $query        = mysqli_query($this->connec, $sql);
        return mysqli_fetch_all($query, MYSQLI_ASSOC);
    }

    public function getQueryByFieldAndValue($tb_name, $field, $val) {
        $sql            = "SELECT * FROM $tb_name WHERE $field = '$val'";
        $query          = mysqli_query($this->connec, $sql);
        return mysqli_fetch_all($query, MYSQLI_ASSOC);
    }

    public function getQueryByWhere($tb_name, $where_array) {
        $sql = "SELECT * FROM $tb_name WHERE ";
        for ($index = 0; $index < count(array_keys($where_array)); $index++) { 
            if ($index === count($where_array) - 1) {
                $sql = $sql . array_keys($where_array)[$index] . "=" . "'" . array_values($where_array)[$index] . "'";
            }else {
                $sql = $sql . array_keys($where_array)[$index] . "=" . "'" . array_values($where_array)[$index] . "',";
            }
        }
        $query = mysqli_query($this->connec, $sql);
        return mysqli_fetch_all($query, MYSQLI_ASSOC);
    }

    public function getQueryBySql($sql) {
        $query = mysqli_query($this->connec, $sql);
        return mysqli_fetch_all($query, MYSQLI_ASSOC);
    }

    public function getQueryFieldByGroup($tb_name, $field_name, $group_field) {
        $sql = "SELECT $field_name FROM $tb_name GROUP BY $group_field";
        $query = mysqli_query($this->connec, $sql);
        return mysqli_fetch_all($query, MYSQLI_NUM);
    }
    
    public function delQueryAll($tb_name) {
        $sql = "DELETE FROM $tb_name;";
        mysqli_query($this->connec, $sql);
    }
}
$db_connec = new DBConnection();
?>