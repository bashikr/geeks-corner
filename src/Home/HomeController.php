<?php

namespace Anax\Home;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;

use Anax\User\User;
use Anax\Questions\Questions;
use Anax\Tags\Tags;
use Anax\Answers\Answers;
use Anax\Comments\Comments;

/**
 * A sample controller to show how a controller class can be implemented.
 */
class HomeController implements ContainerInjectableInterface
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

        $questions = new Questions();
        $users = new User();
        $tags = new Tags();
        $answers = new Answers();
        $comments = new Comments();

        $users->setDb($this->di->get("dbqb"));
        $questions->setDb($this->di->get("dbqb"));
        $tags->setDb($this->di->get("dbqb"));
        $answers->setDb($this->di->get("dbqb"));
        $comments->setDb($this->di->get("dbqb"));


        $topThreeQuestions = $questions->findAllAndOrderBy("votes DESC", 3);
        $topThreeActiveUsers = $users->findAllAndOrderBy("score DESC",  3);
        $topThreeTags = $tags->findAllThenOrderByAndGroupBy("counter DESC", "tag", "*", 3);



        $page->add("home/index", [
            "topThreeQuestions" => $topThreeQuestions,
            "topThreeActiveUsers" => $topThreeActiveUsers,
            "topThreeTags" => $topThreeTags,
            "answers" => $answers,
            "comments" => $comments,
            "questions" => $questions,
        ]);

        return $page->render([
            "title" => "Home",
        ]);
    }
}
