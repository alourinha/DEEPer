<?php

require_once '../src/setup.php';
require_once 'boilerplates/functions.php';

$product = $dbProvider->userReviews($loggedInUser->name);


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'boilerplates/header.php' ?>
    <link rel="stylesheet" href="css/style-product.css">
</head>
<body class="m-auto">
    <div class="container m-auto" style="">
         <?php include 'boilerplates/navbar.php' ?>

         <?php
         if ($loggedInUser->isAdmin){
         include 'boilerplates/product-create.php'; }?>


        <h2 class="p-3 text-success"style="text-shadow: 2px 2px gray;">Your Recent Reviews</h2>
        <?php foreach ($product as $p): $star = star($p['rating']); ?>
            <div class='p-3 mt-3 border' style='background-color: rgba(164, 182, 254, .3) '>
                <div class='row m-auto ml-md-auto'>
                    <h3><?= $p['title'] ?></h3> &nbsp;&nbsp;
                    <span class='pt-1'>
                 <?php foreach ($star as $s): ?>
                     <?= $s; ?>
                 <?php endforeach; ?>
             </span>
                </div>
                <span class=' m-auto'>
            <p><?= $p['review'] ?></p><p><small><?= $p['submitted'] ?></small></p>
    </span>
            </div>
        <?php endforeach ?>
        <hr>
        <?php include 'boilerplates/footer.php' ?>
    </div>
    <?php include 'boilerplates/scripts.php' ?>

</body>
