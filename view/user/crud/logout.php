<?php
namespace Anax\View;

// Create urls for navigation
$urlToCreate = url("user/register");
$urlToSignIn = url("user/login");
$urlToLogout = url("user/logout");

?>


<?php if ($di->session->get("login") == false || $di->session->get("login") == null) : ?>
    <div class="form" style="width:50%;">
        <div style="padding-top:70px;">
            <a class="button" href="<?= $urlToCreate ?>">Register</a>
            <a class="button" href="<?= $urlToSignIn ?>">Login</a>
        </div>
    </div>
<?php elseif($di->session->get("login") == true) : ?>
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
<p style="text-align:center;">You have logged out<p>
