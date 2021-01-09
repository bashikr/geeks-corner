<?php

namespace Anax\View;

// Gather incoming variables and use default values if not set
$user = isset($user) ? $user : null;

// Create urls for navigation
$urlToCreate = url("user/register");
$urlToSignIn = url("user/login");
$urlToLogout = url("user/logout");

?>

<?php if ($this->di->session->get("login") == false || $di->session->get("login") == null) : ?>
    <div class="form" style="width:50%;">
        <div style="padding-top:70px;">
            <a class="button" href="<?= $urlToCreate ?>">Register</a>
            <a class="button" href="<?= $urlToSignIn ?>">Login</a>
        </div>
    </div>

<?php elseif($this->di->session->get("login") == true) : ?>
    <p style="text-align:center;">
        <a href="<?= $urlToLogout ?>">Logout</a>
    </p>

    <table>
        <tr>
            <th>Id</th>
            <th>Name</th>
            <th>Email</th>
            <th>Image</th>
        </tr>
        <tr>
            <td>
                <a href="<?= url("user/update/{$user->id}"); ?>"><?= $user->id ?></a>
            </td>
            <td><?= $user->firstname . " " . $user->lastname ?></td>
            <td><?= $user->email ?></td>
            <td><img src="img/<?= $user->gender . ".png" ?>" ></td>
        </tr>
    </table>
<?php endif; ?>


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
