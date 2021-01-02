<?php
namespace Anax\View;


// Gather incoming variables and use default values if not set
$items = isset($items) ? $items : null;
// Create urls for navigation
$urlToViewItems = url("answers");
?>

<div class="form" style="height:auto;width:50%;padding-top:20px;">
    <h1 style="border-bottom:none;">Answer on the question</h1>
    <?= $form ?>
</div>
