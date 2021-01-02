<?php

namespace Anax\View;

// Gather incoming variables and use default values if not set
$items = isset($items) ? $items : null;
// Create urls for navigation
$urlToCreate = url("comments/create-comment");
$urlToDelete = url("comments/delete");
?><h1>View all items</h1>

<p>
    <a href="<?= $urlToCreate ?>">Create</a> |
    <a href="<?= $urlToDelete ?>">Delete</a>
</p>

<?php if (!$items) : ?>
    <p>There are no items to show.</p>
    <?php
    return;
endif;
?>

<table>
    <tr>
        <th>Id</th>
        <th>Column1</th>
        <th>Column2</th>
    </tr>
    <?php foreach ($items as $item) : ?>
    <tr>
        <td>
            <a href="<?= url("comments/update/{$item->id}"); ?>"><?= $item->id ?></a>
        </td>
        <td><?= $item->comment ?></td>
        <td><?= $item->username ?></td>
    </tr>
    <?php endforeach; ?>
</table>
