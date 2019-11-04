<?php

namespace App\Controller;

use App\Model\UserModel;
use App\Model\TypeModel;
use App\Model\ProfileModel;

class UserController extends Controller{
 
 	private $userModel;
 	private $typeModel;
 	private $profileModel;

    private $db;
    private $requestMethod;
    private $userId;

    public function __construct($db, $requestMethod, $userId)
    {
        $this->db = $db;
        $this->requestMethod = $requestMethod;
        $this->userId = $userId;

    	$this->userModel = new UserModel($db);
    	$this->typeModel = new TypeModel($db);
    	$this->profileModel = new ProfileModel($db);
    }


    private function getUser($id)
    {
        $result = $this->userModel->find($id);
        if(!$result) {
            return $this->notFoundResponse();
        }
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_encode($result);
        return $response;
    }

    private function getAllUsers()
    {
        $result = $this->userModel->findAll();
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_encode($result);
        return $response;
    }

    private function createUser()
    {
        $input = (array)json_decode(file_get_contents('php://input'), TRUE);
        if (!$this->validateUser($input)) 
        {
            return $this->unprocessableEntityResponse();
        }

        $this->userModel->insert($input);

        $response['status_code_header'] = 'HTTP/1.1 201 Created';
        $response['body'] = null;
        return $response;
    }

    private function updateUser($id)
    {
        $result = $this->userModel->find($id);
        if (!$result) {
            return $this->notFoundResponse();
        }
        $input = (array) json_decode(file_get_contents('php://input'), TRUE);
        if (! $this->validateUser($input)) {
            return $this->unprocessableEntityResponse();
        }
        $this->userModel->update($id, $input);
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = null;
        return $response;
    }

    private function deleteUser($id)
    {
        $result = $this->userModel->find($id);
        if (! $result) {
            return $this->notFoundResponse();
        }
        $this->userModel->delete($id);
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = null;
        return $response;
    }

    private function validateUser($input)
    {
        if(!isset($input['first_name'])) 
        {
            return false;
        }

        if(!isset($input['last_name'])) 
        {
            return false;
        }

        return true;
    }

    private function unprocessableEntityResponse()
    {
        $response['status_code_header'] = 'HTTP/1.1 422 Unprocessable Entity';
        $response['body'] = json_encode([
            'error' => 'Invalid input'
        ]);
        return $response;
    }

    private function notFoundResponse()
    {
        $response['status_code_header'] = 'HTTP/1.1 404 Not Found';
        $response['body'] = null;
        return $response;
    }

    public function processRequest()
    {
        switch ($this->requestMethod) {
            case 'GET':
                if ($this->userId) {
                    $response = $this->getUser($this->userId);
                } else {
                    $response = $this->getAllUsers();
                };
                break;
            case 'POST':
                $response = $this->createUser();
                break;
            case 'PUT':
                $response = $this->updateUser($this->userId);
                break;
            case 'DELETE':
                $response = $this->deleteUser($this->userId);
                break;
            default:
                $response = $this->notFoundResponse();
                break;
        }
        header($response['status_code_header']);
        if ($response['body']) {
            echo $response['body'];
        }
    }
    
}