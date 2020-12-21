<?php

namespace Anax\View;

// Gather incoming variables and use default values if not set
$items = isset($items) ? $items : null;

// Create urls for navigation
$urlToCreate = url("questions/create-question");

?><h1 style="text-align:center;">View all items</h1>
<!-- <?php var_dump($isLoggedIn) ?> -->

<p style="text-align:center;">
    <a href="<?= $urlToCreate ?>">Create a new question</a>
</p>

<?php if (!$items) : ?>
    <p style="text-align:center;">There are no items to show.</p>
<?php
    return;
endif;
?>



<?php foreach ($items as $item) : ?>
<div class="box">
    <!-- <a><?= $item->id ?></a> -->
    <p>Question<?= $item->question ?></p>
    <p>By:<?= $item->userId ?></p>
    <p>Tag:<?= $item->tags ?></p>
    <p>Posted at: <?= $item->created ?></p>
</div>

<?php endforeach; ?>




<style>
    .box {
        border: 2px solid #333;
        padding: .5em;
        width: 50%;
        max-width: 100%;
        text-align: center;
        margin-bottom:20px;
    }
</style>
