<?php

use App\Hydrator\Hydrator;
require_once '../src/setup.php';

$registered = false;
if (isset($_POST['name'], $_POST['email'], $_POST['password'], $_POST['confirmPassword'])) {
    if ($_POST['password'] === $_POST['confirmPassword']) {
        $formUser = [
            'name' => strip_tags($_POST['name']),
            'email_address' => filter_var($_POST['email'], FILTER_SANITIZE_EMAIL),
            'password' => password_hash($_POST['password'], PASSWORD_DEFAULT),
        ];
        $hydrator = new Hydrator();
        $formUser = $hydrator->hydrateUser($formUser);

        $user = $dbProvider->createUser($formUser);
        $registered = true;
    }
    // Handle passwords that don't match
}

if (isset($_POST['email'], $_POST['password'])) {
    $user = $dbProvider->getUserByEmail($_POST['email']);

    if ($user && password_verify($_POST['password'], $user->password)) {

        // Logged in
        $_SESSION['loginId'] = $user->id;
        header("Refresh: 2; url=user_page.php");

    } else {
        $errorMessage = 'Incorrect details, please try again';
    }
}



?>
<div class="modal fade" id="loginModalCenter" tabindex="-1" role="dialog"  aria-labelledby="loginModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-xl " role="document">
        <div class="modal-content" style="background-color: #4AB5D2">
            <div class="modal-header">
                <h5 class="modal-title text-white" id="loginModalLongTitle">Log In</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-white">
                <?php if (isset($errorMessage)): ?>
                    <div class="alert alert-warning"><?= $errorMessage ?></div>
                <?php endif; ?>
                <form method="post" autocomplete="off" id="login">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email-input">Email Address</label>
                                <input name="email" type="email" class="form-control" id="email-input" value="<?= $_POST['email'] ?? '' ?>">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="password-input">Password</label>
                                <input name="password" type="password" class="form-control" id="password-input">
                            </div>
                        </div>
                        <div class="col-md-12 text-center">
                            <button type="submit"  class="btn btn-primary">Log in</button>
                        </div>
                    </div>
                </form>
                <h2 class="pt-5 pb-3 text-center">Not registered yet?</h2>
                <h5>Register Now!</h5>
                <?php if ($registered): ?>
                    <div class="alert alert-success">Thank you for registering, please now Log in!</div>
                <?php endif; ?>
                <form method="post">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" name="name" id="name" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="email">Email address</label>
                                <input type="email" name="email" id="email" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" name="password" id="password" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="confirm">Confirm Password</label>
                                <input type="password" name="confirmPassword" id="confirm" class="form-control">
                            </div>
            </div>
                    </div>
                    <div class="col-md-12 text-center">
                        <input type="submit"  class="btn btn-primary">
                    </div>
                </div>
            </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>