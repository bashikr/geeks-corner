<?php

namespace Anax\Questions;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;
use Anax\Questions\HTMLForm\CreateQuestionForm;
use Anax\Comments\Comments;
use Anax\Answers\Answers;
use Anax\User\User;

/**
 * A sample controller to show how a controller class can be implemented.
 */
class QuestionsController implements ContainerInjectableInterface
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
        $questions = new Questions();
        $answers = new Answers();
        $user = new User();

        $answers->setDb($this->di->get("dbqb"));
        $questions->setDb($this->di->get("dbqb"));
        $user->setDb($this->di->get("dbqb"));
        $allQuestions = $questions->findAllAndOrderBy("created DESC");

        $page->add("questions/crud/view-all-questions", [
            "questions" => $allQuestions,
            "answers" => $answers
        ]);

        return $page->render([
            "title" => "Questions",
        ]);
    }

    /**
     * Show all items.
     *
     * @return object as a response object
     */
    public function userQuestionsAction(int $id) : object
    {
        $page = $this->di->get("page");
        $questions = new Questions();
        $user = new User();
        $answers = new Answers();

        $user->setDb($this->di->get("dbqb"));
        $answers->setDb($this->di->get("dbqb"));
        $questions->setDb($this->di->get("dbqb"));

        $page->add("questions/crud/user-questions", [
            "questions" => $questions->findAllWhere("userId = ?", $id),
            "answers" => $answers,
            "user" => $user->findById("id", $id)
        ]);

        return $page->render([
            "title" => "User questions",
        ]);
    }

    public function viewAction(int $id) : object
    {
        $page = $this->di->get("page");
        $question = new Questions();
        $answers = new Answers();
        $user = new User();
        $comment = new Comments();
        $question->setDb($this->di->get("dbqb"));
        $user->setDb($this->di->get("dbqb"));
        $answers->setDb($this->di->get("dbqb"));
        $comment->setDb($this->di->get("dbqb"));

        $question->find("id", $id);
        $user->find("id", $question->userId);

        $sortingMethod = $this->di->request->getGet("sort-by") ?? "created ASC";

        $ansSortedByQstId = $answers->findAllWhereOrderBy("$sortingMethod", "questionId = ?", $id);
        $cmtSrtByQstId = $comment->findAllWhereOrderBy("votes DESC", "questionId = ?", $id);

        $page->add("questions/crud/view", [
            "question" => $question,
            "answers" => $ansSortedByQstId,
            "user" => $user,
            "questionComment" => $cmtSrtByQstId,
            "comment" => $comment,
        ]);
        return $page->render([
            "title" => "Show specific question",
        ]);
    }

    /**
     * Handler with form to create a new item.
     *
     * @return object as a response object
     */
    public function createQuestionAction(int $id) : object
    {
        $page = $this->di->get("page");
        $form = new CreateQuestionForm($this->di, $id);
        $form->check();

        $page->add("questions/crud/create-question", [
            "form" => $form->getHTML(),
        ]);

        return $page->render([
            "title" => "Create a question",
        ]);
    }
}
