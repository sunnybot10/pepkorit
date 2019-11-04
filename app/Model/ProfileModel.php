<?php

namespace App\Model;

class ProfileModel extends Model{
 
    //Database connection and table name
    private $conn;

    // constructor with $db as database connection
    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function find($userid)
    {
        try {
            $query = "SELECT id,
                             tUSER_id, 
                             tTYPES_id,
                             value
                             FROM tPROFILE 
                             WHERE id = ?";
            $stmt = $this->conn->prepare($query);
            $stmt->execute(array($userid));
            $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
            return $result;
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }   
    }

    public function findAll($userid, $typeid)
    {
        try {
            $query = "SELECT id,
                             tUSER_id, 
                             tTYPES_id,
                             value  
                        from tPROFILE
                        WHERE tUSER_id=:tUserId AND tTYPES_id=:tUserId";
            $stmt = $this->conn->prepare($query);
            $stmt->execute(array(
                "tUserId"  => $userid,
                "tTypesId" => $typeid
            ));
            $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
            return $result;
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }   
    }

    public function insert($profileArr) : boolean
    {
        $query = "INSERT INTO tPROFILE (tUSER_id, tTYPES_id,value) 
                                VALUES (:tUserId, :tTypesId, :value)";

        $stmt->bindParam(":tUser_id", $profileArr['tUserId']);
        $stmt->bindParam(":tTypes_id", $profileArr['tTypesId']);
        $stmt->bindParam(":value", $profileArr['value']);
        
        if($stmt->execute()){
            return true;
        }
        return false;
    }

    public function update($profileArr) : boolean
    {
        $query = "UPDATE tPROFILE SET value=:value WHERE tUSER_id=:tUserId AND tTYPES_id=:tTypesId ";

        $stmt->bindParam(":tUser_id", $profileArr['tUserId']);
        $stmt->bindParam(":tTypes_id", $profileArr['tTypesId']);
        $stmt->bindParam(":value", $profileArr['value']);
        
        if($stmt->execute()){
            return true;
        }
        return false;
    }

    public function delete() : boolean
    {
        $query = "DELETE FROM tPROFILE WHERE id=:id";

        $stmt->bindParam(":id", $profileArr['id']);
        
        if($stmt->execute()){
            return true;
        }
        return false;
    }

}