<?php

namespace Anax\User;

use Anax\DatabaseActiveRecord\ActiveRecordModel;

/**
 * A database driven model using the Active Record design pattern.
 */
class User extends ActiveRecordModel
{
    /**
     * @var string $tableName name of the database table.
     */
    protected $tableName = "Users";



    /**
     * Columns in the table.
     *
     * @var integer $id primary key auto incremented.
     */
    public $id;
    public $firstname;
    public $lastname;
    public $email;
    public $image;
    public $password;
    public $gender;


    public function setHashPassword($password)
    {
        $this->password = password_hash($password, PASSWORD_DEFAULT);
    }
    
    public function getHashPassword()
    {
        return $this->password;
    }

    public function validateUser($email, $password)
    {
        $this->find("email", $email);

        if (password_verify($password, $this->password) == true) {
            return true;
        } elseif((password_verify($password, $this->password) == false)) {
            return false;
        }
    }
}
