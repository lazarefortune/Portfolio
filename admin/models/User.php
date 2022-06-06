<?php
namespace App\Models;

class User extends BaseModel{
    protected $table = 'users';
    private $name;
    private $email;
    private $password;
    private $createdAt;

    public function __construct( $name = null, $email = null, $password = null ) {
        parent::__construct();
        $this->name = $name;
        $this->email = $email;
        $this->password = md5($password);
    }

    public function save(){
        $this->createdAt = date('Y-m-d H:i:s');
        $data = array(
            'name' => $this->name,
            'email' => $this->email,
            'password' => $this->password,
            'created_at' => $this->createdAt
        );
        try {
            $this->insert($data);
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
        //$this->insert($data);
        return $this->getLastInsertId();
    }

    public function register ($data) {
        $this->insert($data);
    }

    public function getName() {
        return $this->name;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getCreatedAt() {
        return $this->createdAt;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function setPassword($password) {
        $this->password = md5($password);
    }

    public function setCreatedAt($createdAt) {
        $this->createdAt = $createdAt;
    }

    private function getLastInsertId() {
        return $this->db->getDbHandle()->insert_id;
    }
}
