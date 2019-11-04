<?php

namespace App\Model;

class UserModel extends Model{
 
    private $db = null;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function find($id)
    {
        try {   
            $query = "SELECT tUSER.id,
                             tUSER.id_number, 
                             tUSER.first_names, 
                             tUSER.last_name, 
                             tTYPES.type, 
                             tPROFILE.value, 
                             tTYPES.deleted  
                        from tUSER
                        LEFT JOIN tPROFILE on tPROFILE.tUSER_id = tUSER.id
                        LEFT JOIN tTYPES on tPROFILE.tTYPES_id = tTYPES.id
                        WHERE tUSER.id = ?";

            $stmt = $this->conn->prepare($query);
            $stmt->execute(array($id));
            $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
            return $result;

        }catch (\PDOException $e){

            exit($e->getMessage());
        }
    }

    public function findAll()
    {
        try { 

            $query = "SELECT tUSER.id,
                             tUSER.id_number, 
                             tUSER.first_names, 
                             tUSER.last_name, 
                             tTYPES.type, 
                             tPROFILE.value, 
                             tTYPES.deleted  
                        from tPROFILE
                        INNER JOIN tUSER on tPROFILE.tUSER_id = tUSER.id
                        INNER JOIN tTYPES on tPROFILE.tTYPES_id = tTYPES.id";
            $stmt = $this->conn->query($query);
            $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
            return $result;

        }catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function insert(Array $input)
    {
        try {   
            $query = "INSERT INTO tUSER 
                        (id, id_number, first_names, last_name) 
                      VALUES 
                        (:id, :idNumber, :firstName, :lastName)";
            $stmt = $this->conn->prepare($query);
            $insert = [
                ":id"           => $input['id'],
                ":idNumber"     => $input['id_number'],
                ":firstName"    => $input['first_name'] ?? null,
                ":lastName"     => $input['last_name'] ?? null,
            ];
            if($stmt->execute($insert)){
                return true;
            }
            return false;
        }catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function update($id, Array $input)
    {
        try {  
            $query = "UPDATE tUSER SET  id_number   =:idNumber, 
                                        first_names =:firstName,
                                        last_name   =:lastName 
                                    WHERE id=:id";
            $stmt = $this->conn->prepare($query);

            $update = [
                ":id"           => $id,
                ":idNumber"     => $input['id_number'],
                ":firstName"    => $input['first_name'] ?? null,
                ":lastName"     => $input['last_name'] ?? null,
            ];

            if($stmt->execute($update)){
                return $stmt->rowCount();
            }
            return false;

        }catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function delete($id)
    {
        try{

            $query = "DELETE FROM tUSER WHERE id=:id";
            $stmt = $this->conn->prepare($query);

            $delete = ['id' => $id];

            if($stmt->execute($delete)){
                return $stmt->rowCount();
            }
            return false;

        }catch (\PDOException $e){
            exit($e->getMessage());
        }
    }

}