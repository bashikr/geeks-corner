<?php

namespace Anax\View;

// Gather incoming variables and use default values if not set
$user = isset($user) ? $user : null;

$filter = new \Anax\TextFilter\TextFilter;
$answers = isset($answers) ? $answers : null;
$questions = isset($questions) ? $questions : null;
$currentRoute = $this->di->request->getRoute();
?>

<div style="width:100%;margin:auto;">
    <h2 style="text-align:center;border-bottom:none;font-weight:1000;">View User Profile</h2>

    <table>
        <tr>
            <th>Id</th>
            <th>Firstname</th>
            <th>Lastname</th>
            <th>Image</th>
            <th>Join date</th>
            <th>User credits</th>
        </tr>
        <tr>
            <td><?= $user->id ?></td>
            <td><?= $user->firstname?></td>
            <td><?=$user->lastname ?></td>
            <td><img src="../../../img/<?= $user->gender . ".png" ?>" ></td>
            <td><?=$user->created ?></td>
            <td><?=$user->score + count($questions) + count($answers) + count($comments) ?></td>
        </tr>
    </table>

    <h2 style="text-align:center;margin:40px auto;">User established activities</h2>
    <div style="margin-bottom:350px;">
        <div style="float:right;border-left:4px solid black;padding:0 100px;">
            <p style="font-weight:bold;">User votes on: </p>
            <p>Questions: <?= count($questionVotesUsr) ?>.</p>
            <p>Answers: <?= count($answerVotesUsr) ?>.</p>
            <p>Comments: <?= count($commentVotesUsr) ?>.</p>
        </div>
        <div style="float:left;padding:0 100px;border-right:4px solid black;">
            <p>Questions: <a href="<?= url("user/view-user-info/" . $user->id . "/user-questions") ?>"><?= count($questions) ?></a></p>
            <p>Answers: <a href="<?= url("user/view-user-info/" . $user->id . "/user-answers") ?>"><?= count($answers) ?></a></p>
            <p>Comments: <a href="<?= url("user/view-user-info/" . $user->id . "/user-comments") ?>"><?= count($comments) ?></a></p>
        </div>
    </div>


    <?php if($currentRoute == "user/view-user-info/" . $user->id . "/user-questions") : ?>
        <h2 style="text-align:center">User Questions</h2>
        <div style="padding: 0 20%;">
            <?php foreach ($questions as $question) : ?>
            <div style="padding:10px;margin:50px 0px;background:#f5f5f5;border-radius:25px;background-image: linear-gradient(315deg,#088080 0,#380036 74%);">
                <div class="box-questions" style="padding:10px;width:100%;margin-bottom:20px;height:auto;background:white;box-shadow: 7px 22px 42px -20px black;">
                    <a href="<?= url("questions/view/{$question->id}"); ?>">
                        <h2><?= mb_substr(strtoupper($question->question), 0, 25, "UTF-8") ?></h2>
                    </a>
                    <div style="text-align:left;padding-left:100px;">
                    <?php if (empty($di->session->get("login"))) : ?>
                        <div style="filter: blur(4px);" id="test" onmousedown='return false;' onselectstart='return false;'>
                            <h3>Question:</h3> <p ><?= $filter->markdown($question->question); ?></p>
                        </div>
                    <?php elseif(!empty($di->session->get("login"))) :?>
                        <div>
                            <h3>Question:</h3> <p><?= $filter->markdown($question->question); ?></p>
                        </div>
                    <?php endif; ?>
                        <p>votes: <?= $question->votes ?> </p>
                        <p>tags: <?= $question->tags ?> </p>
                        <p>By: <a href="<?= url("user/"); ?>"><?= $question->username?></a></p>
                        <p>Posted at: <?= $question->created ?>. </p>
                    </div>
                </div>
            </div>
            <?php endforeach ?>
        </div>
    <?php endif; ?>



    <?php if($currentRoute == "user/view-user-info/" . $user->id . "/user-answers") : ?>
        <h2 style="text-align:center">User Answers</h2>
        <div style="padding: 0 20%;">
            <?php foreach ($answers as $answer) : ?>
                <div style="padding:10px;margin:50px 0px;background:#f5f5f5;border-radius:25px;background-image: linear-gradient(315deg,#088080 0,#380036 74%);">
                    <div class="box-questions" style="padding:10px;width:100%;margin-bottom:20px;height:auto;background:white;box-shadow: 7px 22px 42px -20px black;">
                        <a href="<?= url("questions/view/{$answer->questionId}"); ?>">
                            <h2><?= mb_substr(strtoupper($answer->answer), 0, 25, "UTF-8") ?></h2>
                        </a>
                        <div style="text-align:left;padding-left:100px;">

                            <p>Answer: <?= $filter->doFilter($answer->answer, ["markdown"]); ?></p>
                            <p>Answered on question nr: <?= $answer->questionId; ?>.</p>
                            <p>votes: <?= $answer->votes ?>.</p>
                            <p>By: <a href="<?= url("user/"); ?>"><?= $answer->username?>.</a></p>
                            <p>Posted at: <?= $answer->created ?>. </p>
                        </div>
                    </div>
                </div>
            <?php endforeach ?>
        </div>
    <?php endif; ?>


    <?php if($currentRoute == "user/view-user-info/" . $user->id . "/user-comments") : ?>
        <h2 style="text-align:center">User Comments</h2>
        <div style="padding: 0 20%;">
            <?php foreach ($comments as $comment) : ?>
                <div style="padding:10px;margin:50px 0px;background:#f5f5f5;border-radius:25px;background-image: linear-gradient(315deg,#088080 0,#380036 74%);">
                    <div class="box-questions" style="padding:10px;width:100%;margin-bottom:20px;height:auto;background:white;box-shadow: 7px 22px 42px -20px black;">
                        <a href="<?= url("questions/view/{$comment->questionId}"); ?>">
                            <h2><?= mb_substr(strtoupper($comment->comment), 0, 25, "UTF-8") ?></h2>
                        </a>
                        <div style="text-align:left;padding-left:100px;">

                            <p>comment: <?= $filter->doFilter($comment->comment, ["markdown"]); ?></p>
                            <p>Commented on question nr: <?= $comment->questionId; ?>.</p>
                            <p>Commented on answer nr: <?= $comment->answerId; ?>.</p>
                            <p>votes: <?= $comment->votes ?> </p>
                            <p>By: <a href="<?= url("user/"); ?>"><?= $comment->username?></a></p>
                            <p>Posted at: <?= $comment->created ?>. </p>
                        </div>
                    </div>
                </div>
            <?php endforeach ?>
    <?php endif; ?>
</div>





<style>
    img {
        border-style: none;
        box-sizing: border-box;
        width: 100px;
        max-width:100%;
    }

    table {
        border: 20px solid #333;
        padding: .5em;
        width: 75%;
        border-radius: 25px;
        max-width: 100%;
        text-align: center;
        margin:20px auto;
    }
</style>
