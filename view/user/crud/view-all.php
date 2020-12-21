<?php

namespace Anax\View;

// Gather incoming variables and use default values if not set
$items = isset($items) ? $items : null;

// Create urls for navigation
$urlToCreate = url("user/register");
$urlToSignIn = url("user/login");
$urlToLogout = url("user/logout");
// $urlToDelete = url("user/delete");


?><h1 style="text-align:center;">View all items</h1>

<p style="text-align:center;">
    <a href="<?= $urlToCreate ?>">Register</a> | 
    <a href="<?= $urlToSignIn ?>">Login</a>
    <a href="<?= $urlToLogout ?>">Logout</a>
</p>

<?php if (!$items) : ?>
    <p style="text-align:center;">There are no items to show.</p>
<?php
    return;
endif;
?>


<table>
    <tr>
        <th>Id</th>
        <th>Title</th>
        <th>Author</th>
        <th>Gender</th>
        <th>Password</th>
        <th>Image</th>
    </tr>
    <?php foreach ($items as $item) : ?>
    <tr>
        <td>
            <a href="<?= url("user/update/{$item->id}"); ?>"><?= $item->id ?></a>
        </td>
        <td><?= $item->firstname . " " . $item->lastname ?></td>
        <td><?= $item->email ?></td>
        <td><?= $item->gender ?></td>
        <td><?= $item->password ?></td>
        <td><img src="img/<?= $item->image ?>" ></td>

    </tr>
    <?php endforeach; ?>
</table>

<style>
    img {
        border-style: none;
        box-sizing: border-box;
        width: 100px;
        max-width:100%;
    }

    table {
        border: 2px solid #333;
        padding: .5em;
        width: 100%;
        max-width: 100%;
        text-align: center;
        margin-bottom:20px;
    }
</style>
