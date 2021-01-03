<?php

namespace Anax\View;

$filter = new \Anax\TextFilter\TextFilter;
$questions = isset($questions) ? $questions : null;

?>

<h2 style="text-align:center;">THE MOST ACTIVE USERS</h2>
<div style="margin:20px;text-align:center;">
    <?php foreach ($topThreeActiveUsers as $activeUser) : ?>
            <div class="box-user-home">
                <a href="<?= url("user/view-user-info/" . $activeUser->id . "/user"); ?>">
                    <h2><?= $activeUser->firstname . " " . $activeUser->lastname ?></h2>
                </a>
                <img src="img/<?= $activeUser->gender . ".png" ?>" >
                <div style="text-align:left;padding-left:10px;">
                    <p>Score: <?= $activeUser->score +
                    count($answers->findAllWhere("userId = ?", [$activeUser->id])) +
                    count($questions->findAllWhere("userId = ?", [$activeUser->id])) +
                    count($comments->findAllWhere("userId = ?", [$activeUser->id])) ?>.
                    </p>

                    Joined at: <p style="font-size:0.85rem;"><?= $activeUser->created ?>. </p>
                </div>
            </div>
    <?php endforeach ?>
</div>

<h2 style="text-align:center">TOP THREE QUESTIONS</h2>
<?php foreach ($topThreeQuestions as $question) : ?>
    <div class="box-questions" style="margin-bottom:20px;height:auto;">
        <a href="<?= url("questions/view/{$question->id}"); ?>">
            <h2><?= mb_substr(strtoupper($question->question), 0, 25, "UTF-8") ?></h2>
        </a>
        <div class="boxInsideBox">
            <h3>Question:</h3> <p><?= $filter->doFilter($question->question, ["markdown"]); ?></p>

            <p style="border-top:2px solid black;padding-top:25px;">Answers on this question: <?= 
            count($answers->findAllWhere("questionId = ? AND userId = ?", [$question->id, $question->userId])) ?></p>
            <p>Question rank: <?= $question->votes ?> </p>
            <p>Tags: <?= $question->tags ?>.</p>
            <p>Written by: <a class="tagsA" href="<?= url("user/view-user-info") . "/" . $question->userId . "/user"; ?>">
            <?= $question->username?></a></p>
            <p>Posted at: <?= $question->created ?>. </p>
        </div>
    </div>
<?php endforeach ?>



<h2 style="text-align:center;">THE MOST POPULAR TAGS</h2>
<div style="margin:20px;text-align:center;">
<?php foreach ($topThreeTags as $activeTag) : ?>
    <div class="box-user-home">

        <div style="text-align:left;padding-left:10px;">
            <h3 style="text-align:center;"><?= $activeTag->tag ?> </h3>
            <p>Rank: <?= $activeTag->counter ?>. </p>
            Creation date: <p style="font-size:0.85rem;"><?= $activeTag->created ?>. </p>
        </div>
    </div>
<?php endforeach ?>
</div>

<style>
    img {
        border-style: none;
        box-sizing: border-box;
        width: 100px;
        max-width:100%;
    }
</style>
