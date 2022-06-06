<?php

namespace App\Models;

class BaseModel
{
    protected $db;
    protected $table;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function getAll()
    {
        $sql = "SELECT * FROM $this->table";
        $result = mysqli_query($this->db->getDbHandle(), $sql);
        $rows = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $rows[] = $row;
        }
        return $rows;
    }

    public function getById($id)
    {
        $sql = "SELECT * FROM $this->table WHERE id = $id";
        $result = mysqli_query($this->db->getDbHandle(), $sql);
        $row = mysqli_fetch_assoc($result);
        return $row;
    }

    public function insert($data)
    {
        $keys = array_keys($data);
        $values = array_values($data);
        $sql = "INSERT INTO $this->table (" . implode(',', $keys) . ") VALUES ('" . implode("','", $values) . "')";
        $result = mysqli_query($this->db->getDbHandle(), $sql);
        return $result;
    }

    public function update($data, $id)
    {
        $keys = array_keys($data);
        $values = array_values($data);
        $sql = "UPDATE $this->table SET ";
        for ($i = 0; $i < count($keys); $i++) {
            $sql .= $keys[$i] . " = '" . $values[$i] . "'";
            if ($i < count($keys) - 1) {
                $sql .= ", ";
            }
        }
        $sql .= " WHERE id = $id";
        $result = mysqli_query($this->db->getDbHandle(), $sql);
        return $result;
    }

    public function delete($id)
    {
        $sql = "DELETE FROM $this->table WHERE id = $id";
        $result = mysqli_query($this->db->getDbHandle(), $sql);
        return $result;
    }

    public function getTable()
    {
        return $this->table;
    }

    public function setTable($table)
    {
        $this->table = $table;
    }

    public function getDb()
    {
        return $this->db;
    }

    public function setDb($db)
    {
        $this->db = $db;
    }

    public function getAllBy($column, $value)
    {
        $sql = "SELECT * FROM $this->table WHERE $column = '$value'";
        $result = mysqli_query($this->db->getDbHandle(), $sql);
        $rows = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $rows[] = $row;
        }
        return $rows;
    }

    public function getBy($column, $value)
    {
        $sql = "SELECT * FROM $this->table WHERE $column = '$value'";
        $result = mysqli_query($this->db->getDbHandle(), $sql);
        $row = mysqli_fetch_assoc($result);
        return $row;
    }

    public function getByColumns($columns)
    {
        $sql = "SELECT * FROM $this->table WHERE ";
        for ($i = 0; $i < count($columns); $i++) {
            $sql .= $columns[$i]['column'] . " = '" . $columns[$i]['value'] . "'";
            if ($i < count($columns) - 1) {
                $sql .= " AND ";
            }
        }
        $result = mysqli_query($this->db->getDbHandle(), $sql);
        $row = mysqli_fetch_assoc($result);
        return $row;
    }

    public function getAllByColumns($columns)
    {
        $sql = "SELECT * FROM $this->table WHERE ";
        for ($i = 0; $i < count($columns); $i++) {
            $sql .= $columns[$i]['column'] . " = '" . $columns[$i]['value'] . "'";
            if ($i < count($columns) - 1) {
                $sql .= " AND ";
            }
        }
        $result = mysqli_query($this->db->getDbHandle(), $sql);
        $rows = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $rows[] = $row;
        }
        return $rows;
    }

    public function getAllByColumnsOrderBy($columns, $orderBy)
    {
        $sql = "SELECT * FROM $this->table WHERE ";
        for ($i = 0; $i < count($columns); $i++) {
            $sql .= $columns[$i]['column'] . " = '" . $columns[$i]['value'] . "'";
            if ($i < count($columns) - 1) {
                $sql .= " AND ";
            }
        }
        $sql .= " ORDER BY $orderBy";
        $result = mysqli_query($this->db->getDbHandle(), $sql);
        $rows = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $rows[] = $row;
        }
        return $rows;
    }

    public function getAllByColumnsOrderByLimit($columns, $orderBy, $limit)
    {
        $sql = "SELECT * FROM $this->table WHERE ";
        for ($i = 0; $i < count($columns); $i++) {
            $sql .= $columns[$i]['column'] . " = '" . $columns[$i]['value'] . "'";
            if ($i < count($columns) - 1) {
                $sql .= " AND ";
            }
        }
        $sql .= " ORDER BY $orderBy LIMIT $limit";
        $result = mysqli_query($this->db->getDbHandle(), $sql);
        $rows = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $rows[] = $row;
        }
        return $rows;
    }

    public function getAllByColumnsOrderByLimitOffset($columns, $orderBy, $limit, $offset)
    {
        $sql = "SELECT * FROM $this->table WHERE ";
        for ($i = 0; $i < count($columns); $i++) {
            $sql .= $columns[$i]['column'] . " = '" . $columns[$i]['value'] . "'";
            if ($i < count($columns) - 1) {
                $sql .= " AND ";
            }
        }
        $sql .= " ORDER BY $orderBy LIMIT $limit OFFSET $offset";
        $result = mysqli_query($this->db->getDbHandle(), $sql);
        $rows = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $rows[] = $row;
        }
        return $rows;
    }
}