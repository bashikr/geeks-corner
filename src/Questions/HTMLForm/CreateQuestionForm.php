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
    public function __construct(ContainerInterface $di)
    {
        parent::__construct($di);
        $this->form->create(
            [
                "id" => __CLASS__,
                "legend" => "Details of the item",
            ],
            [
                "question" => [
                    "type" => "text",
                    "value" => $user->question ?? null,
                ],
                "tags" => [
                    "type" => "text",
                    "validation" => ["not_empty"],
                    "value" => $user->tags ?? null,
                ],
                "submit" => [
                    "type" => "submit",
                    "value" => "Create Question",
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
        $questions = new Questions();
        $questions->setDb($this->di->get("dbqb"));
        $user = new User();
        $user->setDb($this->di->get("dbqb"));

        $questions->userId ="1";


        // $questions->question = $this->form->value("question");
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
                $tags->save();
            } else {
                $tags->tag = $tagArray;
                $tags->counter = $tags->counter + 1;
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
