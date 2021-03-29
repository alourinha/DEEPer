<?php

use App\Hydrator\Hydrator;
use Carbon\Carbon;

require_once '../src/setup.php';

/** @var Carbon $carbon*/
/** @var PDO $dbProvider*/


if (!empty($_POST)) {

    if (filter_var($_POST['rating'], FILTER_VALIDATE_INT, array("options" => array("min_range"=>1, "max_range"=>5))) === false) {
        echo 'invalid rating';
    }

    if (filter_var(strlen($_POST['review']), FILTER_VALIDATE_INT, array("options" => array("min_range"=>20, "max_range"=>200))) === false) {
        echo 'invalid review';
    }

    $data = $_POST;
    $data['review'] = strip_tags($data['review']);
    $data['name'] = $loggedInUser->name;
    $data['rating'] = strip_tags($data['rating']);
    $data['submitted'] = $carbon::now()->toDateTimeString();

    // Build new object

    $hydrator = new Hydrator();
    $checkin = $hydrator->hydrateCheckin($data);

    $dbProvider->createCheckin($checkin);

}
