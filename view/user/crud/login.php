<?php

namespace Anax\View;

// Gather incoming variables and use default values if not set
$items = isset($items) ? $items : null;


// Prepare classes
$classes[] = "article";
if (isset($class)) {
    $classes[] = $class;
}


?>
<article style="text-align:center;" <?= classList($classes) ?>>
<?= $form ?>
</article>
