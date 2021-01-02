<?php

namespace Anax\User\HTMLForm;

use Anax\HTMLForm\FormModel;
use Psr\Container\ContainerInterface;
use Anax\User\User;

/**
 * Form to create an item.
 */
class CreateUserForm extends FormModel
{

    /**
     * Constructor injects with DI container.
     *
     * @param Psr\Container\ContainerInterface $di a service container
     */
    public function __construct(ContainerInterface $di)
    {
        parent::__construct($di);
        $this->form->create(
            [
                "id" => __CLASS__
            ],
            [
                "firstname" => [
                    "type" => "text",
                    "validation" => ["not_empty"]
                ],

                "lastname" => [
                    "type" => "text",
                    "validation" => ["not_empty"]
                ],
                "gender" => [
                    "type"        => "radio",
                    "label"       => "Gender:",
                    "values"      => [
                        "male",
                        "female",
                        "prefer not to say"
                    ],
                    "checked"     => "prefer not to say",
                ],

                "email" => [
                    "type" => "text",
                    "validation" => ["email"],
                ],
                "password" => [
                    "type" => "password",
                    "validation" => ["not_empty"]

                ],
                "password-again" => [
                    "type"        => "password",
                    "validation" => [
                        "match" => "password"
                    ],
                ],

                "submit" => [
                    "type" => "submit",
                    "value" => "Create User",
                    "callback" => [$this, "callbackSubmit"]
                ],
            ]
        );
    }



    /**
     * Callback for submit-button which should return true if it could
     * carry out its work and false if something failed.
     *
     * @return bool true if okey, false if something went wrong.
     */
    public function callbackSubmit() : bool
    {
        $user = new User();
        $user->setDb($this->di->get("dbqb"));

        $items = $user->findAll();
        $arr = [];
        foreach ($items as $item) {
            array_push($arr, $item->email);
        }

        $email = $this->form->value("email");

        if(in_array($email, $arr) === true) {
            $this->form->addOutput("The user is already registered in the system.");
            $this->form->rememberValues();
            return false;
        } elseif(in_array($email, $arr) === false ) {
            $user->firstname  = $this->form->value("firstname");
            $user->lastname = $this->form->value("lastname");
            $user->email= $this->form->value("email");
            $user->gender= $this->form->value("gender");
            
            $user->setHashPassword($this->form->value("password"));
            $user->password = $user->getHashPassword();
            
            $user->save();
            $this->form->addOutput("You have successfully been registered");
            return true;
        }
    }


    /**
     * Callback what to do if the form was successfully submitted, this
     * happen when the submit callback method returns true. This method
     * can/should be implemented by the subclass for a different behaviour.
     */
    public function callbackSuccess()
    {
        $this->di->get("response")->redirect("user/login")->send();
    }

    /**
     * Callback what to do if the form was successfully submitted, this
     * happen when the submit callback method returns true. This method
     * can/should be implemented by the subclass for a different behaviour.
     */
    public function callbackFail()
    {
        $this->di->get("response")->redirect("user/register")->send();
    }
}
