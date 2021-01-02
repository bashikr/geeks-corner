<?php

namespace Anax\Answers\HTMLForm;

use Anax\HTMLForm\FormModel;
use Psr\Container\ContainerInterface;
use Anax\Questions\Questions;
use Anax\Answers\Answers;

/**
 * Form to create an item.
 */
class CreateAnswersForm extends FormModel
{
    /**
     * Constructor injects with DI container.
     *
     * @param Psr\Container\ContainerInterface $di a service container
     */
    public function __construct(ContainerInterface $di, $id)
    {
        parent::__construct($di);
        $this->info = $this->getQuestionDetails($id);
        $this->form->create(
            [
                "id" => __CLASS__
            ],
            [
                "answer" => [
                    "type" => "textarea",
                    "validation" => ["not_empty"],
                ],
                "questionId" => [
                    "type" => "hidden",
                    "value" => $this->info->id,
                ],
                "userId" => [
                    "type" => "hidden",
                    "validation" => ["not_empty"],
                    "value" => $di->session->get("userId"),
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


    public function getQuestionDetails($id) : object
    {
        $question = new Questions();
        $question->setDb($this->di->get("dbqb"));
        $question->find("id", $id);

        return $question;
    }


    /**
     * Callback for submit-button which should return true if it could
     * carry out its work and false if something failed.
     *
     * @return bool true if okey, false if something went wrong.
     */
    public function callbackSubmit() : bool
    {
        $answer = new Answers();
        $answer->setDb($this->di->get("dbqb"));

        $answer->answer  = $this->form->value("answer");
        $answer->votes  = 0;
        $answer->userId = $this->form->value("userId");
        $answer->username = $this->form->value("username");
        $answer->questionId = $this->form->value("questionId");
        $answer->created = date('Y-m-d H:i');

        $answer->save();
        return true;
    }


    /**
     * Callback what to do if the form was successfully submitted, this
     * happen when the submit callback method returns true. This method
     * can/should be implemented by the subclass for a different behaviour.
     */
    public function callbackSuccess()
    {
        $this->di->get("response")->redirect("questions/view/". $this->info->id)->send();
    }
}
