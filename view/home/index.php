<?php

namespace Anax\View;

$filter = new \Anax\TextFilter\TextFilter;
$questions = isset($questions) ? $questions : null;

?>

    <div style="margin:10px;width:10%;" class="wrap2">
        <audio id="audioMusic">
            <source src="./img/welcome.mp3" type="audio/mpeg">
        </audio>
        <a class="hover-fx"><i class="fas fa-play-circle" onclick="bell()"></i></a>
    </div>
    <script>
        var audio = document.getElementById("audioMusic");
    
        function bell() {
            audio.play();
        }
    </script>
<h2 style="text-align:center;">THE MOST ACTIVE USERS</h2>
<div style="margin:20px;text-align:center;">
    <?php foreach ($topThreeActiveUsers as $activeUser) : ?>
        <div class="box-user-home">

                <a style="text-decoration:none;" class="tagsA" href="<?= url("user/view-user-info/" . $activeUser->id . "/user"); ?>">
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
<div style="padding: 0 20%;">
<?php foreach ($topThreeQuestions as $question) : ?>
    <div style="padding:10px;margin:50px 0px;background:#f5f5f5;border-radius:25px;background-image: linear-gradient(315deg,#088080 0,#380036 74%);">
    <div class="box-questions" style="padding:10px;width:100%;margin-bottom:20px;height:auto;background:white;box-shadow: 7px 22px 42px -20px black;">
        <a href="<?= url("questions/view/{$question->id}"); ?>">
            <h2><?= mb_substr(strtoupper($question->question), 0, 25, "UTF-8") ?></h2>
        </a>
        <div class="boxInsideBox">
        <?php if (empty($di->session->get("login"))) : ?>
            <div style="filter: blur(4px);" id="test" onmousedown='return false;' onselectstart='return false;'>
                <h3>Question:</h3> <p ><?= $filter->markdown($question->question); ?></p>
            </div>
        <?php elseif(!empty($di->session->get("login"))) :?>
            <div>
                <h3>Question:</h3> <p><?= $filter->markdown($question->question); ?></p>
            </div>
        <?php endif; ?>

            <p style="border-top:2px solid black;padding-top:25px;">Answers on this question: <?= 
            count($answers->findAllWhere("questionId = ? AND userId = ?", [$question->id, $question->userId])) ?></p>
            <p>Question rank: <?= $question->votes ?> </p>
            <p>Tags: 
                <i class="fas fa-hashtag ml-5 tagsI"></i>
                <?= $question->tags ?>.</p>

            <p>Written by: <a class="tagsA" href="<?= url("user/view-user-info") . "/" . $question->userId . "/user"; ?>">
            <?= $question->username?></a></p>
            <p>Posted at: <?= $question->created ?>. </p>
        </div>
    </div>
</div>
    <?php endforeach ?>
    </div>



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
        border-radius:50%;
        border:15px solid #174D52;
        padding:10px;
    }
</style>
