<?php

namespace Anax\User\HTMLForm;

use Anax\HTMLForm\FormModel;
use Psr\Container\ContainerInterface;
use Anax\User\User;
use Anax\Questions\Questions;
use Anax\Comments\Comments;
use Anax\Answers\Answers;

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
        $user = $this->getUserDetails($id);
        $this->form->create(
            [
                "id" => __CLASS__,
            ],
            [
                "id" => [
                    "type" => "hidden",
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
                "gender" => [
                    "type"        => "radio",
                    "label"       => "Gender:",
                    "values"      => [
                        "male",
                        "female",
                        "prefer not to say"
                    ],
                    "checked"     => $user->gender ?? null
                ],
                "email" => [
                    "type" => "text",
                    "readonly" => true,
                    "validation" => ["not_empty"],
                    "value" => $user->email ?? null,
                ],
                "change-password" => [
                    "type" => "password",
                    "placeholder" => "Optional",
                ],
                "submit" => [
                    "type" => "submit",
                    "value" => "Save",
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
    public function callbackSubmit($id) : bool
    {
        $changePassword = $this->form->value("change-password");
        
        $user = new User();
        $user->setDb($this->di->get("dbqb"));
        $user->find("id", $this->form->value("id"));
        $question = new Questions();
        $answer = new Answers();
        $comment = new Comments();
        $question->setDb($this->di->get("dbqb"));
        $answer->setDb($this->di->get("dbqb"));
        $comment->setDb($this->di->get("dbqb"));

        $user->firstname  = $this->form->value("firstname");
        $user->lastname  = $this->form->value("lastname");

        $session = $this->di->get("session");
        $session->set("firstname", $user->firstname);
        $session->set("lastname", $user->lastname);

        $questionArray = $question->findAllWhere("userId = ?", $this->di->session->get("userId"));
        if($question != null) {
            foreach($questionArray as $singleQuestion) {
                $question->id = $singleQuestion->id;
                $question->userId = $singleQuestion->userId;
                $question->username = $user->firstname . " " . $user->lastname;
                $question->created = $singleQuestion->created;
                $question->tags = $singleQuestion->tags;
                $question->question = $singleQuestion->question;
                $question->save();
            }
        }

        $answers = $answer->findAllWhere("userId = ?", $this->di->session->get("userId"));
        if($answer != null) {
            foreach($answers as $answerTableCheck) {
                $answer->id = $answerTableCheck->id;
                $answer->username = $user->firstname . " " . $user->lastname;
                $answer->questionId = $answerTableCheck->questionId;
                $answer->userId = $answerTableCheck->userId;
                $answer->votes = $answerTableCheck->votes;
                $answer->answer = $answerTableCheck->answer;
                $answer->created = $answerTableCheck->created;
                $answer->save();
            }
        }

        $comments = $comment->findAllWhere("userId = ?", $this->di->session->get("userId"));
        if($comment != null) {
            foreach($comments as $commentTableCheck) {
                $comment->id = $commentTableCheck->id;
                $comment->username = $user->firstname . " " . $user->lastname;
                $comment->questionId = $commentTableCheck->questionId;
                $comment->userId = $commentTableCheck->userId;
                $comment->answerId = $commentTableCheck->answerId;
                $comment->created = $commentTableCheck->created;
                $comment->comment = $commentTableCheck->comment;
                $comment->save();
            }
        }

        $user->email = $this->form->value("email");
        $user->gender = $this->form->value("gender");
        if($changePassword == null) {
            $user->password = $user->find("id", $id)->password;
            $this->form->addOutput("Your information have been updated!");
        }
        $user->setHashPassword($changePassword);
        $user->password = $user->getHashPassword();
        
        $user->save();
        $this->form->addOutput("Your information have been updated!");
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
       $this->di->get("response")->redirect("user")->send();
   }
}
