<?php

namespace Anax\Answers;
use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;
use Anax\Answers\HTMLForm\CreateAnswersForm;
use Anax\Answers\HTMLForm\DeleteAnswersForm;
use Anax\Answers\HTMLForm\UpdateAnswersForm;
use Anax\User\User;
use Anax\Questions\Questions;
use Anax\Answers\Answers;
use Anax\Comments\Comments;
use Anax\Votes\Votes;

/**
 * A sample controller to show how a controller class can be implemented.
 */
class AnswersController implements ContainerInjectableInterface
{
    use ContainerInjectableTrait;

    /**
     * Show all items.
     *
     * @return object as a response object
     */
    public function indexActionGet() : object
    {
        $page = $this->di->get("page");
        $answer = new Answers();
        $answer->setDb($this->di->get("dbqb"));

        $page->add("answers/crud/view-all-answers", [
            "items" => $answer->findAll(),
        ]);
        return $page->render([
            "title" => "Answers",
        ]);
    }

    /**
     * Handler with form to create a new item.
     *
     * @return object as a response object
     */
    public function createAction(int $id) : object
    {
        $page = $this->di->get("page");
        $form = new CreateAnswersForm($this->di, $id);
        $form->check();
        $question = new Questions();

        $question->setDb($this->di->get("dbqb"));
        $question->find("id", $id);

        $page->add("answers/crud/create-answer", [
            "form" => $form->getHTML(),
            "question" => $question
        ]);
        return $page->render([
            "title" => "Create an answer",
        ]);
    }

    /**
     * Handler with form to update an item.
     *
     * @param int $id the id to update.
     *
     * @return object as a response object
     */
    public function answerVoteActionGet() : object
    {
        $userId      = $this->di->session->get('userId');

        $voteId   = $this->di->request->getGet("voteId");
        $voteType = $this->di->request->getGet("voteType");
        $questionId   = $this->di->request->getGet("questionId") ?? $voteId;
        $voteDirection = $this->di->request->getGet("voteDirection");

        $votes = new Votes();
        $votes->setDb($this->di->get("dbqb"));
        $votes->checkIfUserHasVoted($userId, $voteId, $voteType);
        $hasVoted = $votes->checkIfUserHasVoted($userId, $voteId, $voteType);

        if ($voteType == "question") {
            $newVote = new Questions();
        } else if ($voteType == "answer") {
            $newVote = new Answers();
        } else if ($voteType == "comment") {
            $newVote = new Comments();
        }
        $newVote->setDb($this->di->get("dbqb"));

        $nVote = $newVote->findWhere("id = ?", $voteId);

        $user = new User();
        $user->setDb($this->di->get("dbqb"));
        $currUser = $user->findWhere("id = ?", $nVote->userId);

        if ($voteDirection == "up" && $hasVoted == "up") {
            $nVote->votes = $nVote->votes - 1;
            $currUser->score = $currUser->score - 1;
            $votes->deleteUserVote($userId, $voteId, $voteType);
        } else if ($voteDirection == "down" && $hasVoted == "down") {
            $nVote->votes = $nVote->votes + 1;
            $currUser->score = $currUser->score + 1;
            $votes->deleteUserVote($userId, $voteId, $voteType);
        } else if ($voteDirection == "up" && $hasVoted == "down") {
            $nVote->votes = $nVote->votes + 2;
            $currUser->score = $currUser->score + 2;
            $votes->deleteUserVote($userId, $voteId, $voteType);
            $nVote->saveVote($userId, $voteId, $voteType, $voteDirection, $this->di);
        } else if ($voteDirection == "down" && $hasVoted == "up") {
            $nVote->votes = $nVote->votes -2;
            $currUser->score = $currUser->score - 2;
            $votes->deleteUserVote($userId, $voteId, $voteType);
            $nVote->saveVote($userId, $voteId, $voteType, $voteDirection, $this->di);
        } else if ($voteDirection == "up") {
            $nVote->votes = $nVote->votes + 1;
            $currUser->score = $currUser->score + 1;
            $nVote->saveVote($userId, $voteId, $voteType, $voteDirection, $this->di);
        } else if ($voteDirection == "down") {
            $nVote->votes = $nVote->votes - 1;
            $currUser->score = $currUser->score - 1;
            $nVote->saveVote($userId, $voteId, $voteType, $voteDirection, $this->di);
        }
        $currUser->save();
        $nVote->save();

        $this->di->response->redirect("questions/view/{$questionId}");
    }
}
