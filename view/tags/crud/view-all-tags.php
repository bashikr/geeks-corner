<?php

namespace Anax\View;

// Gather incoming variables and use default values if not set
$items = isset($items) ? $items : null;

?>

<?php if (!$items) : ?>
    <p style="text-align:center;">There are no items to show.</p>
<?php
    return;
endif;
?>


<h3>All tags</h3>
    <div class="box-center">
        <?php foreach ($items as $item) : ?>
            <div class="box">
                <p><?= $item->tag?></p>
            </div>
        <?php endforeach; ?>
    </div>




<style>
    .box {
        border: 2px solid #333;
        padding: .5em;
        width: 30%;
        max-width: 100%;
        text-align: center;
        margin-bottom:20px;
        vertical-align: center;

    }

    .box-center p {
        vertical-align: center;
    }

    .box-center {
        margin: auto;
        width: 40%;
        vertical-align: center;
        padding: 20px;
    }
</style>
