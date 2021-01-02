<?php

namespace Anax\View;

$filter = new \Anax\TextFilter\TextFilter;
$questions = isset($questions) ? $questions : null;

?>


<h2 style="text-align:center">Top three questions</h2>
        <?php foreach ($topThreeQuestions as $question) : ?>
            <div class="box-questions" style="margin-bottom:20px;height:auto;">
                <a href="<?= url("questions/view/{$question->id}"); ?>">
                    <h2><?= mb_substr(strtoupper($question->question), 0, 25, "UTF-8") ?></h2>
                </a>
                <div style="text-align:left;padding-left:100px;">

                    <p>Question: <?= $filter->doFilter($question->question, ["markdown"]); ?></p>
                    <p>votes: <?= $question->votes ?> </p>
                    <p style="border-top:2px solid black;padding-top:50px;">Answers on this question: <?= count($answers->findAllWhere("questionId = ? AND userId = ?", [$question->id, $question->userId])) ?></p>
                    <p>tags: <?= $question->tags ?> </p>
                    <p>By: <a href="<?= url("user/view-user-info") . "/" . $question->userId . "/user"; ?>"><?= $question->username?></a></p>
                    <p>Posted at: <?= $question->created ?>. </p>
                </div>
            </div>
        <?php endforeach ?>


        <?php foreach ($topThreeActiveUsers as $activeUser) : ?>
            <div class="box-questions" style="margin-bottom:20px;height:auto;">
                <a href="<?= url("questions/view/{$question->id}"); ?>">
                    <h2><?= $activeUser->firstname . " " . $activeUser->lastname ?></h2>
                </a>
                <div style="text-align:left;padding-left:100px;">
                <img src="img/<?= $activeUser->gender . ".png" ?>" >
                    <p>votes: <?= $activeUser->score ?> </p>

                    <p>Joined at: <?= $activeUser->created ?>. </p>
                </div>
            </div>
        <?php endforeach ?>

        <?php foreach ($topThreeTags as $activeTag) : ?>
            <div class="box-questions" style="margin-bottom:20px;height:auto;">

                <div style="text-align:left;padding-left:100px;">
                    <p>tag: <?= $activeTag->tag ?> </p>
                    <p>creation date: <?= $activeTag->created ?>. </p>
                    <p>Counter: <?= $activeTag->counter ?>. </p>
                    <p>Id: <?= $activeTag->id ?>. </p>
                </div>
            </div>
        <?php endforeach ?>



<style>
    img {
        border-style: none;
        box-sizing: border-box;
        width: 100px;
        max-width:100%;
    }
</style>
