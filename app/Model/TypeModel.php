<?php

namespace App\Model;

class TypeModel extends Model{
 
    //constructor with $db as database connection
    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function find($type)
    {
        $query = "SELECT id,
                         type, 
                         description,
                         deleted
                         FROM tTYPES 
                         WHERE id=?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute(array($type));
        $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        return $result;
    }

    public function findAll() : object
    {

    }

    public function insert($typesArr) : boolean
    {
        $query = "INSERT INTO tTYPES (type, description, deleted) 
                            VALUES (:type, :description, :deleted)";
        $insert = [
            ":type"         => $input['type'],
            ":description"  => $input['description'],
            ":deleted"      => $input['deleted'] ?? null,
        ];

        if($stmt->execute($insert)){
            return true;
        }
        return false;
    }

    public function update($typesArr) : boolean
    {

    }

    public function delete() : boolean
    {

    }
}