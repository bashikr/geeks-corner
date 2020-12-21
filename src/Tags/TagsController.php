<?php

namespace Anax\Tags;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;


/**
 * A sample controller to show how a controller class can be implemented.
 */
class TagsController implements ContainerInjectableInterface
{
    use ContainerInjectableTrait;

    /**
     * @var $data description
     */
    //private $data;



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
            "title" => "A collection tags",
        ]);
    }
}
