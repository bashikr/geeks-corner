<?php

namespace Anax\User;

use Anax\Extra\ExtraActiveRecordModel;

/**
 * A database driven model using the Active Record design pattern.
 */
class User extends ExtraActiveRecordModel
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
        return password_verify($password, $this->password);
    }
}
