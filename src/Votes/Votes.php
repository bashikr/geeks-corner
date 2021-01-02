<?php

namespace Anax\Votes;

use Anax\Extra\ExtraActiveRecordModel;
use Anax\Questions\Questions;
use Anax\Answers\Answers;
use Anax\Comments\Comments;

/**
 * A database driven model.
 */
class Votes extends ExtraActiveRecordModel
{
    /**
     * @var string $tableName name of the database table.
     */
    protected $tableName = "Votes";

    /**
     * Columns in the table.
     *
     * @var integer $id primary key auto incremented.
     */
    public $id;
    public $userId;
    public $voteId;
    public $voteType;
    public $voteDirection;

    public function checkIfUserHasVoted($userId, $voteId, $voteType)
    {
        $res = $this->findWhere("userId = ? AND voteId = ? AND voteType = ?", [$userId, $voteId, $voteType]);

        return $res->voteDirection;
    }

    public function deleteUserVote($userId, $voteId, $voteType)
    {
        $this->deleteWhere("userId = ? AND voteId = ? AND voteType = ?", [$userId, $voteId, $voteType]);
    }
}
