<?php

namespace Anax\Comments;
use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;
use Anax\Comments\HTMLForm\CreateCommentsForm;
use Anax\Comments\HTMLForm\DeleteCommentsForm;
use Anax\Comments\HTMLForm\UpdateCommentsForm;

/**
 * A sample controller to show how a controller class can be implemented.
 */
class CommentsController implements ContainerInjectableInterface
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
        $comment = new Comments();
        $comment->setDb($this->di->get("dbqb"));
        $page->add("comments/crud/view-all-comments", [
            "items" => $comment->findAll(),
        ]);
        return $page->render([
            "title" => "Comments",
        ]);
    }


    /**
     * Handler with form to create a new item.
     *
     * @return object as a response object
     */
    public function createAction(int $questionId, int $answerId) : object
    {
        $page = $this->di->get("page");
        $form = new CreateCommentsForm($this->di, $questionId, $answerId);
        $form->check();

        $page->add("comments/crud/create-comment", [
            "form" => $form->getHTML(),
        ]);
        return $page->render([
            "title" => "Create a comment",
        ]);
    }


    /**
     * Handler with form to delete an item.
     *
     * @return object as a response object
     */
    public function deleteAction() : object
    {
        $page = $this->di->get("page");
        $form = new DeleteCommentsForm($this->di);
        $form->check();
        $page->add("comments/crud/delete", [
            "form" => $form->getHTML(),
        ]);
        return $page->render([
            "title" => "Delete a comment",
        ]);
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
        $form = new UpdateCommentsForm($this->di, $id);
        $form->check();

        $page->add("comments/crud/update", [
            "form" => $form->getHTML(),
        ]);
        return $page->render([
            "title" => "Update a comment",
        ]);
    }
}
