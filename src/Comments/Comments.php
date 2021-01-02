<?php

namespace Anax\Comments;

use Anax\Extra\ExtraActiveRecordModel;
use Anax\Votes\Votes;

/**
 * A database driven model using the Active Record design pattern.
 */
class Comments extends ExtraActiveRecordModel
{
    /**
     * @var string $tableName name of the database table.
     */
    protected $tableName = "Comments";
    /**
     * Columns in the table.
     *
     * @var integer $id primary key auto incremented.
     */
    public $id;
    public $username;
    public $questionId;
    public $userId;
    public $answerId;
    public $comment;
    public $created;

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
