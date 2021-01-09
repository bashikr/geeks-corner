<?php

namespace Anax\User;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;
use Anax\User\HTMLForm\CreateUserForm;
use Anax\User\HTMLForm\LoginUserForm;
use Anax\User\HTMLForm\DeleteUserForm;
use Anax\User\HTMLForm\UpdateUserForm;


use Anax\Answers\Answers;
use Anax\Questions\Questions;
use Anax\Comments\Comments;
use Anax\Votes\Votes;

/**
 * A sample controller to show how a controller class can be implemented.
 */
class UserController implements ContainerInjectableInterface
{
    use ContainerInjectableTrait;

    /**
     * Show all items.
     *
     * @return object as a response object
     */
    public function indexAction() : object
    {
        $page = $this->di->get("page");
        $user = new User();
        $user->setDb($this->di->get("dbqb"));


        $user->find("email", $this->di->get("session")->get("user"));
        $questions = new Questions;
        $questions->setDb($this->di->get("dbqb"));
        $answers = new Answers;
        $answers->setDb($this->di->get("dbqb"));
        $comments = new Comments;
        $comments->setDb($this->di->get("dbqb"));


        $page->add("user/crud/view-all", [
            "user" => $user,
            "questions" => $questions,
            "comments" => $comments,
            "answers" => $answers,
        ]);
        return $page->render([
            "title" => "User profile",
        ]);
    }

    /**
     * Show all items.
     *
     * @return object as a response object
     */
    public function viewUserInfoAction(int $userId, string $userInfoURL) : object
    {
        $page = $this->di->get("page");
        $user = new User($this->di, $userId);
        $questions = new Questions();
        $answers = new Answers();
        $comments = new Comments();
        $votes = new Votes();

        $user->setDb($this->di->get("dbqb"));
        $answers->setDb($this->di->get("dbqb"));
        $questions->setDb($this->di->get("dbqb"));
        $comments->setDb($this->di->get("dbqb"));
        $votes->setDb($this->di->get("dbqb"));

        $questionVotesUsr = $votes->findAllWhere("userId = ? AND voteType = ?", [$userId, "question"]);
        $answerVotesUsr = $votes->findAllWhere("userId = ? AND voteType = ?", [$userId, "answer"]);
        $commentVotesUsr = $votes->findAllWhere("userId = ? AND voteType = ?", [$userId, "comment"]);

        $page->add("user/crud/view-user-info", [
            "questions" => $questions->findAllWhere("userId = ?", $userId),
            "answers" => $answers->findAllWhere("userId = ?", $userId),
            "comments" => $comments->findAllWhere("userId = ?", $userId),
            "commentVotesUsr" => $commentVotesUsr,
            "questionVotesUsr" => $questionVotesUsr,
            "answerVotesUsr" => $answerVotesUsr,
            "user" => $user->find("id", $userId),
        ]);
        return $page->render([
            "title" => "User profile",
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
            "title" => "User login",
        ]);
    }


    public function logoutAction() : object
    {
        $session = $this->di->get("session");

        $session->destroy();

        return $this->di->response->redirect("home");
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

        if ($this->di->session->get("userId") == $id) {
            $page->add("user/crud/update", [
                "form" => $form->getHTML(),
            ]);
        } elseif ($this->di->session->get("userId") != $id) {
            $page->add("user/crud/update", [
                "form" => "You are not authorized",
            ]);
        }

        return $page->render([
            "title" => "Update a user",
        ]);
    }
}
