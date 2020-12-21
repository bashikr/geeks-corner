<?php

namespace Anax\Questions;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;
use Anax\Questions\HTMLForm\CreateQuestionForm;


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
    public function indexActionGet() : object
    {
        $page = $this->di->get("page");
        $questions = new Questions();
        $questions->setDb($this->di->get("dbqb"));

        $page->add("questions/crud/view-all-questions", [
            "items" => $questions->findAll()
        ]);

        return $page->render([
            "title" => "A collection of items",
        ]);
    }

    /**
     * Handler with form to create a new item.
     *
     * @return object as a response object
     */
    public function createQuestionAction() : object
    {
        $page = $this->di->get("page");
        $form = new CreateQuestionForm($this->di);
        $form->check();

        $page->add("questions/crud/create-question", [
            "form" => $form->getHTML(),
        ]);

        return $page->render([
            "title" => "Sign up a new user",
        ]);
    }
}
