<?php

namespace Anax\User\HTMLForm;

use Anax\HTMLForm\FormModel;
use Psr\Container\ContainerInterface;
use Anax\User\User;

/**
 * Form to create an item.
 */
class LoginUserForm extends FormModel
{

    protected $email = "";

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
                "id" => __CLASS__,
                "legend" => "login",
            ],
            [
                "email" => [
                    "type" => "text",
                    "validation" => ["not_empty"],
                ],
                "password" => [
                    "type" => "password",
                    "validation" => ["not_empty"],
                ],

                "submit" => [
                    "type" => "submit",
                    "value" => "log in",
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

        
        $user->email = $this->form->value("email");
        $user->password = $this->form->value("password");
        if ($user->validateUser($user->email, $user->password) == true) {

            return true;
        }
        $this->form->addOutput("You have either given a wrong password or email");
        return false;
    }



    /**
     * Callback what to do if the form was successfully submitted, this
     * happen when the submit callback method returns true. This method
     * can/should be implemented by the subclass for a different behaviour.
     */
    public function callbackSuccess()
    {
        $this->di->get("response")->redirect("user/crud/view-all")->send();
    }
}
