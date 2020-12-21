<?php

namespace Anax\User\HTMLForm;

use Anax\HTMLForm\FormModel;
use Psr\Container\ContainerInterface;
use Anax\User\User;

/**
 * Form to update an item.
 */
class UpdateUserForm extends FormModel
{
    /**
     * Constructor injects with DI container and the id to update.
     *
     * @param Psr\Container\ContainerInterface $di a service container
     * @param integer             $id to update
     */
    public function __construct(ContainerInterface $di, $id)
    {
        parent::__construct($di);
        $user = $this->getItemDetails($id);
        $this->form->create(
            [
                "id" => __CLASS__,
                "legend" => "Update details of the item",
            ],
            [
                "id" => [
                    "type" => "text",
                    "validation" => ["not_empty"],
                    "readonly" => true,
                    "value" => $user->id,
                ],
                "firstname" => [
                    "type" => "text",
                    "validation" => ["not_empty"],
                    "value" => $user->firstname ?? null,
                ],

                "lastname" => [
                    "type" => "text",
                    "validation" => ["not_empty"],
                    "value" => $user->lastname ?? null,
                ],
                "image" => [
                    "type" => "text",
                    "validation" => ["not_empty"],
                    "value" => $user->image ?? null,
                ],
                "email" => [
                    "type" => "text",
                    "validation" => ["not_empty"],
                    "value" => $user->email ?? null,
                ],
                "password" => [
                    "type" => "password",
                    "validation" => ["not_empty"],
                    "value" => $user->password ?? null,
                ],

                "submit" => [
                    "type" => "submit",
                    "value" => "Save",
                    "callback" => [$this, "callbackSubmit"]
                ],

                "reset" => [
                    "type"      => "reset",
                ],
            ]
        );
    }



    /**
     * Get details on item to load form with.
     *
     * @param integer $id get details on item with id.
     * 
     * @return User
     */
    public function getItemDetails($id) : object
    {
        $user = new User();
        $user->setDb($this->di->get("dbqb"));
        $user->find("id", $id);
        return $user;
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
        $user->find("id", $this->form->value("id"));
        $user->firstname  = $this->form->value("firstname");
        $user->lastname  = $this->form->value("lastname");
        $user->image = $this->form->value("image");
        $user->email = $this->form->value("email");
        $user->password = $this->form->value("password");
        $user->save();
        return true;
    }
}
