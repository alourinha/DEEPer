<?php


require_once '../src/setup.php';

// Search Term
$searchTerm = '';
if (isset($_GET['search'])) {
    $searchTerm = $_GET['search'];
}


$products = $dbProvider->getProducts($searchTerm);


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'boilerplates/header.php' ?>
    <link rel="stylesheet" href="css/style-product.css">
</head>
<body class="m-auto">
    <div class="container m-auto">
        <?php include 'boilerplates/navbar.php' ?>

            <div class="row m-auto">


                <?php
                if (count($products) < 1) { ?>
                    <p class="text-white">Sorry no results found, try a different search or check out our products link above</p>
                <?php
                } else {
                    foreach($products as $product): ?>

                    <div class="col-6 p-3 border-white border text-center">
                        <a href="product.php?product_id=<?= $product->id; ?>"><img class="prod" src="<?= $product->image_path; ?>" width="40%"></a>
                    </div>
                    <div class="col-6 p-5 border-white border">
                        <a href="product.php?product_id=<?= $product->id; ?>"><p class="prodName"><?= $product->title; ?></p></a>
                        <?php

                        if ($product->glutten_free === 'true') {
                            ?>
                        <p class="text-white" style="text-shadow: 2px 2px gray; font-size: 1.5rem"><strong>Glutten Free!</strong>  </p>
                        <?php
                        }
                        if ($product->has_filling === 'true') {
                            ?>
                            <p class="text-white" style="text-shadow: 2px 2px gray; font-size: 1.5rem"><strong> With filling!</strong> </p>
                        <?php } else { ?>
                            <p class="text-white" style="text-shadow: 2px 2px gray; font-size: 1.5rem"><strong> No Filling </strong> </p>
                        <?php
                        }
                        ?>
                    </div>

                <?php endforeach; }?>

            </div>
        <?php include 'boilerplates/footer.php' ?>
    </div>
    <?php include 'boilerplates/scripts.php' ?>

</body>
