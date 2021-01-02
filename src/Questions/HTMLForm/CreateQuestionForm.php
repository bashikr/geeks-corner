<?php

namespace Anax\Questions\HTMLForm;

use Anax\HTMLForm\FormModel;
use Psr\Container\ContainerInterface;
use Anax\Questions\Questions;
use Anax\User\User;
use Anax\Tags\Tags;

/**
 * Form to create an item.
 */
class CreateQuestionForm extends FormModel
{
    /**
     * Constructor injects with DI container.
     *
     * @param Psr\Container\ContainerInterface $di a service container
     */
    public function __construct(ContainerInterface $di, $id)
    {
        parent::__construct($di);
        $userInfo = $this->getUserDetails($id);
        $this->form->create(
            [
                "id" => __CLASS__
            ],
            [
                "question" => [
                    "type" => "textarea",
                    "validation" => ["not_empty"],
                ],
                "tags" => [
                    "type" => "text",
                    "validation" => ["not_empty"],
                ],
                "username" => [
                    "type" => "hidden",
                    "validation" => ["not_empty"],
                    "value" => $userInfo->firstname . " " . $userInfo->lastname,
                ],
                "submit" => [
                    "type" => "submit",
                    "value" => "Publish",
                    "callback" => [$this, "callbackSubmit"]
                ],
            ]
        );
    }


    public function getUserDetails($id) : object
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
        $questions = new Questions();
        $questions->setDb($this->di->get("dbqb"));
        $user = new User();
        $user->setDb($this->di->get("dbqb"));

        $questions->username = $this->form->value("username");
        $questions->userId  = $this->di->session->get("userId");
        $questions->question = $this->form->value("question");
        $questions->tags = $this->form->value("tags");
        $questions->created = date('Y-m-d H:i');
        $tagArray = explode(" ", $this->form->value("tags"));
        $tagArray = array_filter($tagArray);
        $questions->tags = implode(" ", $tagArray);

        foreach ($tagArray as $tagArray) {
            $tags = new Tags();
            $tags->setDb($this->di->get("dbqb"));
            $tags->find("tag", $tagArray);
            if (!$tags->tag == $tagArray) {
                $tags->tag = $tagArray;
                $tags->counter = 1;
                $tags->created = date('Y-m-d H:i');
                $tags->save();
            } else {
                $tags->tag = $tagArray;
                $tags->counter = $tags->counter + 1;
                $tags->created = date('Y-m-d H:i');
                $tags->save();
            }
        }
        $user->findById($questions->userId);

        $questions->save();
        $user->save();
        return true;
    }


    /**
     * Callback what to do if the form was successfully submitted, this
     * happen when the submit callback method returns true. This method
     * can/should be implemented by the subclass for a different behaviour.
     */
    public function callbackSuccess()
    {
        $this->di->get("response")->redirect("questions")->send();
    }
}
