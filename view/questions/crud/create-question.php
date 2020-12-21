<?php

namespace Anax\View;


// Gather incoming variables and use default values if not set
$items = isset($items) ? $items : null;

// Create urls for navigation
$urlToViewItems = url("user");



?><h1>Create a new question</h1>

<?= $form ?>

<p>
    <a href="<?= $urlToViewItems ?>">View all</a>
</p>
