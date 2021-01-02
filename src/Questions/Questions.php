<?php

namespace Anax\Questions;

use Anax\Extra\ExtraActiveRecordModel;
use Anax\Votes\Votes;

/**
 * A database driven model using the Active Record design pattern.
 */
class Questions extends ExtraActiveRecordModel
{
    /**
     * @var string $tableName name of the database table.
     */
    protected $tableName = "Questions";
    /**
     * Columns in the table.
     *
     * @var integer $id primary key auto incremented.
     */
    public $id;
    public $userId;
    public $tags;
    public $question;
    public $created;
    public $username;

    public function saveVote($userId, $voteId, $voteType, $voteDirection, $di)
    {
        $votes = new Votes();
        $votes->setDb($di->get("dbqb"));
        $votes->userId = $userId;
        $votes->voteId = $voteId;
        $votes->voteType = $voteType;
        $votes->voteDirection = $voteDirection;
        $votes->save();
    }
}
