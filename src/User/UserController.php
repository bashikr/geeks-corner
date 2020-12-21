<?php

namespace Anax\User;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;
use Anax\User\HTMLForm\CreateUserForm;
use Anax\User\HTMLForm\LoginUserForm;
// use Anax\User\HTMLForm\EditUserForm;
use Anax\User\HTMLForm\DeleteUserForm;
use Anax\User\HTMLForm\UpdateUserForm;


/**
 * A sample controller to show how a controller class can be implemented.
 */
class UserController implements ContainerInjectableInterface
{
    use ContainerInjectableTrait;

    public $isLoggedIn = false;

    /**
     * @var $data description
     */
    //private $data;



    /**
     * Show all items.
     *
     * @return object as a response object
     */
    public function indexActionGet() : object
    {
        $page = $this->di->get("page");
        $user = new User();
        $user->setDb($this->di->get("dbqb"));


        $page->add("user/crud/view-all", [
            "items" => $user->findAll(),
        ]);

        return $page->render([
            "title" => "A collection of items",
        ]);
    }



    /**
     * Handler with form to create a new item.
     *
     * @return object as a response object
     */
    public function registerAction() : object
    {
        $page = $this->di->get("page");
        $form = new CreateUserForm($this->di);
        $form->check();

        $page->add("user/crud/register", [
            "form" => $form->getHTML()
        ]);

        return $page->render([
            "title" => "Sign up a new user",
        ]);
    }


    /**
     * Handler with form to create a new item.
     *
     * @return object as a response object
     */
    public function logInAction() : object
    {
        $page = $this->di->get("page");
        $form = new LoginUserForm($this->di);
        $form->check();

        
        $page->add("user/crud/login", [
            "form" => $form->getHTML(),
        ]);

        return $page->render([
            "title" => "A login page",
        ]);
    }


    public function logoutAction() : object
    {
        $page = $this->di->get("page");
        $this->di->session->delete("user");
        $this->di->session->delete("login");
        $form = new LoginUserForm($this->di);
        $form->check();

        $page->add("user/crud/logout", [
            "form" => $form->getHTML(),
            "isLoggedIn" => $this->getIsLoggedIn()
        ]);


        return $page->render([
            "title" => "A create user page",

        ]);
    }

    public function setIsLoggedIn($value)
    {
        $this->isLoggedIn = $value;
    }

    public function getIsLoggedIn()
    {
        return $this->isLoggedIn;
    }

    /**
     * Handler with form to delete an item.
     *
     * @return object as a response object
     */
    public function deleteAction() : object
    {
        $page = $this->di->get("page");
        $form = new DeleteUserForm($this->di);
        $form->check();

        $page->add("user/crud/delete", [
            "form" => $form->getHTML(),
        ]);

        return $page->render([
            "title" => "Delete an item",
        ]);
    }



    /**
     * Handler with form to update an item.
     *
     * @param int $id the id to update.
     *
     * @return object as a response object
     */
    public function updateAction(int $id) : object
    {
        $page = $this->di->get("page");
        $form = new UpdateUserForm($this->di, $id);
        $form->check();

        $page->add("user/crud/update", [
            "form" => $form->getHTML(),
        ]);

        return $page->render([
            "title" => "Update an item",
        ]);
    }
}
