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
                "id" => __CLASS__
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
        // Get values from the submitted form
        $email       = $this->form->value("email");
        $password      = $this->form->value("password");
        $user = new User();
        $user->setDb($this->di->get("dbqb"));
        $res = $user->validateUser($email, $password);
        if (!$res) {
            $this->form->rememberValues();
            $this->form->addOutput("User or password did not match.");
            return false;
        }
        $session = $this->di->get("session");
        $session->set("login", true);
        $session->set("user", $email);
        $session->set("userId", $user->id);
        $session->set("firstname", $user->firstname);
        $session->set("lastname", $user->lastname);
        $this->form->addOutput("User " . $user->email . " logged in.");
        return true;
    }



    /**
     * Callback what to do if the form was successfully submitted, this
     * happen when the submit callback method returns true. This method
     * can/should be implemented by the subclass for a different behaviour.
     */
    public function callbackSuccess()
    {
        $this->di->get("response")->redirect("user")->send();
    }

        /**
     * Callback what to do if the form was successfully submitted, this
     * happen when the submit callback method returns true. This method
     * can/should be implemented by the subclass for a different behaviour.
     */
    public function callbackFail()
    {
        $this->di->get("response")->redirect("user/login")->send();
    }
}
