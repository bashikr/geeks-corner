<?php

namespace Anax\Tags;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;
use Anax\Answers\Answers;
use Anax\Questions\Questions;

/**
 * A sample controller to show how a controller class can be implemented.
 */
class TagsController implements ContainerInjectableInterface
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
        $tags = new Tags();
        $tags->setDb($this->di->get("dbqb"));

        $page->add("tags/crud/view-all-tags", [
            "items" => $tags->findAll()
        ]);

        return $page->render([
            "title" => "Tags",
        ]);
    }


    public function questionsAction($id) : object
    {
        $page = $this->di->get("page");
        $question = new Questions();
        $question->setDb($this->di->get("dbqb"));
        $answers = new Answers();
        $answers->setDb($this->di->get("dbqb"));

        $page->add("tags/crud/view-questions-by-tag", [
            "questions" => $question->findAllWhere("tags LIKE ?", "%$id%"),
            "answers" => $answers,
        ]);
        return $page->render([
            "title" => "The group of questions that are related to a tag",
        ]);
    }
}
