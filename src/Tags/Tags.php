<?php

namespace Anax\Tags;

use Anax\Extra\ExtraActiveRecordModel;

/**
 * A database driven model using the Active Record design pattern.
 */
class Tags extends ExtraActiveRecordModel
{
    /**
     * @var string $tableName name of the database table.
     */
    protected $tableName = "Tags";
    /**
     * Columns in the table.
     *
     * @var integer $id primary key auto incremented.
     */
    public $id;
    public $tag;
    public $created;
    public $counter;
}
