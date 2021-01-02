<?php
namespace Anax\View;

$filter = new \Anax\ExtraFilter\ExtraFilter;
$answers = isset($answers) ? $answers : null;
$urlToAnswer = url("answers/create");
$urlToLogin = url("user/login");
$urlToRegister = url("user/create");
$urlToComment = url("comments/create")
?>
 <meta charset="utf-8">

<div style="height:auto;max-height:10000px">
    <div class="question-box-view">
        <h1><?= mb_substr($question->question, 0, 86, "UTF-8") ?></h1>
        <?php if ($di->session->get("user")) : ?>
            <div class="voting">
                <div>
                    <form action=<?=url("answers/answer-vote")?> method="get">
                        <input hidden name="voteId" value="<?=$question->id?>">
                        <input hidden name="voteType" value="question">
                        <input hidden name="questionId" value="<?=$question->id?>">
                        <button type="submit" name="voteDirection" value="up">
                            <i class="fas fa-chevron-up"></i>
                        </button>
                    </form>
                </div>
                <div>
                    <p style="margin:20px;"><b><?=$question->votes?></b>
                </div>
                <div>
                    <form action=<?=url("answers/answer-vote")?> method="get">
                        <input hidden name="voteId" value="<?=$question->id?>">
                        <input hidden name="voteType" value="question">
                        <input hidden name="questionId" value="<?=$question->id?>">
                        <button type="submit" name="voteDirection" value="down" >
                            <i class="fas fa-chevron-down"></i>
                        </button>
                    </form>
                </div>
            </div>
        <?php endif; ?>

        <p><?= $filter->markdown($question->question); ?></p>
        <p>Posted at: <?= $question->created ?> </p>
        <p>By: <a href="<?= url("user/view-user-info/") . "/" . $user->id . "/user"; ?>"><?= $user->firstname . " " . $user->lastname?></a></p>
        <?php if (!$di->session->get("user")) : ?>
            <h5 style="text-align:center;color:red;border-bottom:none;">Login to be able to answer or comment</h5>
        <?php else: ?>
                <div style="text-align:center;">
                    <a  class="button-comment"  href='<?=$urlToComment."/". $question->id. "/". -1 ?>'>Comment</a>
                    <a  class="button-answer" href='<?=$urlToAnswer."/".$question->id?>'>Answer</a>
                </div>
        <?php endif; ?>
    </div>


    <div style="width:50%;float:right;position: relative;">
        <?php foreach ($questionComment as $commentInfo) : ?>
            <?php if (!empty($commentInfo) && $commentInfo->answerId == -1) : ?>
                    <div class="comment-box-view" style="width:100%;margin-bottom:20px;">
                        <div style="margin:auto;padding:40px;text-align:center;">
                            <img style="width:70px;margin-left:10px; border-radius: 30px;border:3px solid black; padding:10px;"
                            src="../../img/<?= $user->find("id", $commentInfo->userId)->gender . ".png"?>"/>
                        </div>
                        <h3 style="text-align:center;">
                        <p>Comment On question <?= $question->id ?></p>
                        </h3>
                        <?php if ($di->session->get("user")) : ?>
                            <div class="voting">
                                <div>
                                    <form action=<?=url("answers/answer-vote")?> method="get">
                                        <input hidden name="voteId" value="<?=$commentInfo->id?>">
                                        <input hidden name="voteType" value="comment">
                                        <input hidden name="questionId" value="<?=$commentInfo->questionId?>">
                                        <button type="submit" name="voteDirection" value="up">
                                            <i class="fas fa-chevron-up"></i>
                                        </button>
                                    </form>
                                </div>
                                <div>
                                    <p style="margin:20px;"><?=$commentInfo->votes?></p>
                                </div>
                                <div>
                                    <form action=<?=url("answers/answer-vote")?> method="get">
                                        <input hidden name="voteId" value="<?=$commentInfo->id?>">
                                        <input hidden name="voteType" value="comment">
                                        <input hidden name="questionId" value="<?=$commentInfo->questionId?>">
                                        <button type="submit" name="voteDirection" value="down">
                                            <i class="fas fa-chevron-down"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        <?php endif; ?>
                        <div style="padding-top:20px;">
                            <p><?= $filter->markdown($commentInfo->comment); ?></p>
                            Commented by: <a href="<?= url("user/view-user-info/") . "/" . $commentInfo->userId . "/user"; ?>"><?= $commentInfo->username ?></a>
                        </div>
                    </div>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>

    <?php if(!empty($answers)) : ?>
        <div style="width:100%;margin:auto;float:left;">
            <p>Sort Answers by:</p>
            <a class="button-comment" href="<?= url("questions/view/{$question->id}?sort-by=votes DESC"); ?>">Answer rank</a>
            <a class="button-comment" href="<?= url("questions/view/{$question->id}?sort-by=created DESC"); ?>">last created</a>
            <a class="button-comment" href="<?= url("questions/view/{$question->id}?sort-by=created ASC"); ?>">Without filter</a>
        </div>
    <?php endif; ?>

        <div style="margin-top:100px;">
            <?php foreach ($answers as $answer) : ?>
            <div class="answer-box-view">

                <h2 style="text-align:center;">
                        <img style="width:70px;margin-left:10px; border-radius: 30px;border:3px solid black; padding:10px;"
                        src="../../img/<?= $user->find("id", $answer->userId)->gender . ".png"?>"/>
                    </p>
                    Answer: <?= $answer->id ?>
                </h2>
                <?php if ($di->session->get("user")) : ?>
                    <div class="voting">
                        <div>
                            <form action=<?=url("answers/answer-vote")?> method="get">
                                <input hidden name="voteId" value="<?=$answer->id?>">
                                <input hidden name="voteType" value="answer">
                                <input hidden name="questionId" value="<?=$answer->questionId?>">
                                <button type="submit" name="voteDirection" value="up">
                                    <i class="fas fa-chevron-up"></i>
                                </button>
                            </form>
                        </div>
                        <div>
                            <p style="margin:20px;"><b><?=$answer->votes?></b>
                        </div>
                        <div>
                            <form action=<?=url("answers/answer-vote")?> method="get">
                                <input hidden name="voteId" value="<?=$answer->id?>">
                                <input hidden name="voteType" value="answer">
                                <input hidden name="questionId" value="<?=$answer->questionId?>">
                                <button type="submit" name="voteDirection" value="down">
                                    <i class="fas fa-chevron-down"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                <?php endif; ?>
                <div style="padding-top:20px;">
                    <p><?= $filter->markdown($answer->answer); ?></p>

                    <p>Answered By:  <a href="<?= url("user/view-user-info/") . "/" . $answer->userId . "/user"; ?>"><?= $answer->username ?></a>
                        <br>
                    <?php if (!$di->session->get("user")) : ?>
                        <h5 style="text-align:center;color:red;border-bottom:none;">Login to be able to comment on this answer</h5>
                    <?php else: ?>
                    <div style="text-align:center;">
                        <a class="button-comment"   href='<?=$urlToComment."/" . $answer->questionId . "/" .$answer->id?>'">Comment</a>
                    </div>
                    <?php endif; ?>
                </div>
            </div>


        <?php  $comments = $comment->findAllWhere("answerId = ?", $answer->id) ?>
        <div style="width:50%;float:right;position: relative;">
            <?php foreach ($comments as $commentInfo) : ?>
                <?php if (!empty($comments) &&$commentInfo->answerId !== -1) : ?>
                    <div  class="comment-box-view" style="width:100%;margin-bottom:20px;">
                            <div style="margin:auto;padding:40px;text-align:center;">
                                <img style="width:70px;margin-left:10px; border-radius: 30px;border:3px solid black; padding:10px;"
                                src="../../img/<?= $user->find("id", $commentInfo->userId)->gender . ".png"?>"/>
                            </div>
                        <h2 style="text-align:center;">
                            Comment on answer: <?= $answer->id ?>
                        </h2>
                        <?php endif; ?>
                        <?php if ($di->session->get("user")) : ?>
                            <div style="margin-bottom:100px;float:left;width:100%;">
                                <div class="voting" style="float:right;">
                                    <div>
                                        <form action=<?=url("answers/answer-vote")?> method="get">
                                            <input hidden name="voteId" value="<?=$commentInfo->id?>">
                                            <input hidden name="voteType" value="comment">
                                            <input hidden name="questionId" value="<?=$commentInfo->questionId?>">
                                            <button type="submit" name="voteDirection" value="up">
                                                <i class="fas fa-chevron-up"></i>
                                            </button>
                                        </form>
                                    </div>
                                    <div>
                                        <p style="margin:20px;"><?=$commentInfo->votes?></p>
                                    </div>
                                    <div>
                                        <form action=<?=url("answers/answer-vote")?> method="get">
                                            <input hidden name="voteId" value="<?=$commentInfo->id?>">
                                            <input hidden name="voteType" value="comment">
                                            <input hidden name="questionId" value="<?=$commentInfo->questionId?>">
                                            <button type="submit" name="voteDirection" value="down">
                                                <i class="fas fa-chevron-down"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                                    <div style="padding-top:20px;">
                                        <p><?= $filter->markdown($commentInfo->comment); ?></p>
                                        Comment By: <a href="<?= url("user/view-user-info/") . "/" . $commentInfo->userId  . "/user"; ?>"><?= $commentInfo->username ?></a>
                                    </div>
                            </div>
                        <?php endif; ?>
                    </div>
            <?php endforeach; ?>
        </div>
        </div>
    <?php endforeach; ?>
</div>
