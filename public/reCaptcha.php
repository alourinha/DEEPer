<?php

require_once '../src/setup.php';

$recaptcha = new \ReCaptcha\ReCaptcha("6LdWwVYaAAAAAFAFJyt1RT5IWavb0OKqG7bjwbZD");
$resp = $recaptcha->setExpectedHostname($_SERVER['SERVER_NAME'])
    ->verify($_POST['captchaResponse'], $_SERVER['REMOTE_ADDR']);

if ($resp->isSuccess()):
    // If the response is a success, that's it!
    echo true;
else:
    // If it's not successful, then one or more error codes will be returned.
    echo false;
endif;