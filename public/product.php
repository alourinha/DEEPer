<?php
require_once '../src/setup.php';
require_once 'boilerplates/functions.php';
/** @var Class $carbon*/
/** @var Class $checkinData*/



if (!isset($_GET['product_id'])) {
    die('Missing productId in the URL');
}

$productId = $_GET['product_id'];

$product = $dbProvider->getProduct($productId);


if (!$product) {
    header('Location: 404.php');
    die;
}
$checkins = $product->getCheckins();

$average = $product->average_rating;



?>
<!doctype html>
<html lang="en">
<head>
    <?php include 'boilerplates/header.php' ?>
    <link rel="stylesheet" href="css/style-product.css">
</head>
<body class="m-auto">
<div class="container m-auto " >
    <?php include 'boilerplates/navbar.php' ?>
    <div id="alert">
        <div class="alert alert-success" id="success-alert" hidden>
            <button type="button" class="close" data-dismiss="alert">x</button>
            <strong>Success! </strong> Your review has been submitted.
        </div>
    </div>
    <div class="row  m-3 mt-5">
        <div class="col-md-6">
                        <img src=<?= $product->image_path ?> class="d-block w-100" alt="doughnut picture">
        </div>
        <div class="col-md-6 pb-3 mt-3 border border-white" style='background-color: rgba(164, 182, 254, .3); '>
            <h1 id="" class="pt-3"><?= $product->title  ?></h1>
            <p class="pr-3 pt-3"><?= $product->description ?>
            </p>
            <button type="button" class="btn btn-success btn-lg" data-toggle="modal"  data-target="#ModalLoginForm">Check In</button>
        </div>
    </div>

    <!-- New Review Modal-->
    <div id="ModalLoginForm" class="modal fade">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #abdde5" >
                    <h1 class="modal-title">Check In</h1>
                </div>
                <div class="modal-body">
                    <div id="alertError">
                        <div class="alert alert-danger" id="error-alert">
                            <button type="button" class="close" data-dismiss="alert">x</button>
                            <strong>Error! </strong> Please correct errors before submission.
                        </div>
                    </div>
                    <form id="checkinForm" name="checkinForm" role="form" method="POST" action="">
                        <div class="form-group">
                            <label class="control-label">Rating</label>
                            <input id="product_id" value="<?= $productId ?>" style="display: none">
                            <div>
                                <div class="container">
                                    <div class="row align-content-star">
                                        <div class="col-lg-12">
                                            <div class="star-rating">
                                                <span class=" fas fa-star fa-lg text-secondary" data-rating="1"></span>
                                                <span class="fas fa-star fa-lg text-secondary" data-rating="2"></span>
                                                <span class="fas fa-star fa-lg text-secondary" data-rating="3"></span>
                                                <span class="fas fa-star fa-lg text-secondary" data-rating="4"></span>
                                                <span class="fas fa-star fa-lg text-secondary" data-rating="5"></span>
                                                <input id="rating" type="hidden" name="rating" class="rating-value" value="1">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label mt-2">Review</label>
                                <div>
                                    <textarea rows="4" id="review" type="text" class="form-control" name="review"></textarea>
                                    <small id="charCount" class="text-danger"><span id="currentChar">0</span>/200</small>
                                    <p id="reviewErrorMin"><small class="text-danger">Minimum 20 characters</small></p>
                                    <p id="reviewErrorMax"><small class="text-danger">Max characters 200</small></p>
                                </div>
                            </div>
                            <div class="form-group">
                                <script src="https://www.google.com/recaptcha/api.js" async defer></script>

                                <div class="g-recaptcha" data-sitekey="6LdWwVYaAAAAAKNeNXgjiArDjywnb5ncE1GGiUsn" id="recaptchaVal"> </div>
                                <div>
                                    <button id="submitButton" type="button"  class="btn btn-success">Submit</button>

                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div id="checkins">
        <?php if ($average) { ?>
        <h2 class="p-3 text-success"style="text-shadow: 2px 2px gray;" >Additional Information</h2>
        <div class="border p-3 m-3"style='background-color: rgba(164, 182, 254, .3) '>
            <table class="table">
                <tbody>
                <tr>
                    <th scope="row">Average Rating</th>
                    <td>
                    <span id="overallRating">
                    <?php
                    $thisArray = updateOverallRating($average);
                    foreach ($thisArray as $theStars) {
                        echo $theStars;
                    }
                    ?>
                    </span>
                    </td>
                </tr>
                <tr>
                    <th scope="row">Yum Yum Rating</th>
                    <td>78/100</td>
                </tr>
                <tr>
                    <th scope="row">Wow Factor</th>
                    <td>Jaw Dropping</td>
                </tr>
                </tbody>
            </table>
        </div>
        <h2 class="p-3 text-success"style="text-shadow: 2px 2px gray;">Recent Checkins</h2>


        <?php foreach ($checkins as $checkin): $star = star($checkin->rating); ?>
    <div class='p-3 mt-3 border' style='background-color: rgba(164, 182, 254, .3) '>
        <div class='row m-auto ml-md-auto'>
            <h3><?= $checkin->name ?></h3> &nbsp;&nbsp;
            <span class='pt-1'>
                 <?php foreach ($star as $s): ?>
                     <?= $s; ?>
                 <?php endforeach; ?>
             </span>
        </div>
        <span class=' m-auto'>
            <p><?= $checkin->review ?></p><p><small><?= $checkin->submitted ?></small></p>
    </span>
    </div>
<?php endforeach ?>
    </div>
    <?php } ?>
    <!-- Footer -->
    <?php include 'boilerplates/footer.php' ?>
    <!-- Scripts -->
    <?php include 'boilerplates/scripts.php' ?>
</body>
</html>

