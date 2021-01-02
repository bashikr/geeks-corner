<?php

namespace Anax\Comments\HTMLForm;

use Anax\HTMLForm\FormModel;
use Psr\Container\ContainerInterface;
use Anax\Questions\Questions;
use Anax\Comments\Comments;
use Anax\Answers\Answers;

/**
 * Form to create an item.
 */
class CreateCommentsForm extends FormModel
{
    /**
     * Constructor injects with DI container.
     *
     * @param Psr\Container\ContainerInterface $di a service container
     */
    public function __construct(ContainerInterface $di, $questionId, $answerId)
    {
        parent::__construct($di);
        $this->getQuestionId = $questionId;
        $this->getAnswerId = $answerId;
        $this->form->create(
            [
                "id" => __CLASS__
            ],
            [
                "comment" => [
                    "type" => "textarea",
                    "validation" => ["not_empty"],
                ],
                "questionId" => [
                    "type" => "hidden",
                    "validation" => ["not_empty"],
                    "value" => $this->getQuestionId ?? null,
                ],
                "answerId" => [
                    "type" => "hidden",
                    "validation" => ["not_empty"],
                    "value" => $this->getAnswerId ?? null,
                ],
                "username" => [
                    "type" => "hidden",
                    "validation" => ["not_empty"],
                    "value" => $di->session->get("firstname") . " " . $di->session->get("lastname"),
                ],
                "submit" => [
                    "type" => "submit",
                    "value" => "Publish",
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
        $comment = new Comments();
        $comment->setDb($this->di->get("dbqb"));
        $comment->comment  = $this->form->value("comment");
        $comment->username = $this->form->value("username");

        $comment->userId  = $this->di->session->get("userId");

        $comment->questionId = $this->form->value("questionId");
        $comment->created  = date('Y-m-d H:i');

        if($this->form->value("answerId") == -1) {
            $comment->answerId = -1;
        } elseif($this->form->value("answerId") !== -1){
            $comment->answerId = $this->form->value("answerId");
        }

        $comment->save();
        return true;
    }


    /**
     * Callback what to do if the form was successfully submitted, this
     * happen when the submit callback method returns true. This method
     * can/should be implemented by the subclass for a different behaviour.
     */
    public function callbackSuccess()
    {
        // var_dump($this->form->value("answerId"));
        $this->di->get("response")->redirect("questions/view/". $this->getQuestionId)->send();
    }


    /**
     * Callback what to do if the form was unsuccessfully submitted, this
     * happen when the submit callback method returns false or if validation
     * fails. This method can/should be implemented by the subclass for a
     * different behaviour.
     */
    public function callbackFail()
    {
        // var_dump($this->form->value("answerId"));

        $this->di->get("response")->redirectSelf()->send();
        $this->form->addOutput("Failed to add a comment. Please fill in your comment!");
    }
}