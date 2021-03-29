<?php

require_once '../src/setup.php';


$products = $dbProvider->getAllProducts();

function cmp($a, $b) {
    if ($a->average_rating == $b->average_rating) {
        return 0;
    }
    return ($a->average_rating > $b->average_rating) ? -1 : 1;
}
uasort($products, 'cmp');
$sorted_products = $products;

$top_list = [];

foreach ($sorted_products as $product) {
    $top_list[] = $product;
}


?>

    <div class="col-lg-3 column hover">
            <a href="product.php?product_id= <?= $top_list[0]->id ?> "><img class="prod" src= <?= $top_list[0]->image_path ?> width="90%">
            <p class="top"> <?= $top_list[0]->title ?> </p></a>
        </div>
        <div class="col-lg-3 column hover">
            <a href="product.php?product_id= <?= $top_list[1]->id ?> "><img class="prod" src= <?= $top_list[1]->image_path ?> width="90%">
            <p class="top"> <?= $top_list[1]->title ?> </p></a>
        </div>
        <div class="col-lg-3 column hover ">
            <a href="product.php?product_id= <?= $top_list[2]->id ?> "><img class="prod" src= <?= $top_list[2]->image_path ?> width="90%">
            <p class="top"> <?= $top_list[2]->title ?> </p></a>
        </div>
    </div>
    <div class="row m-auto text-center justify-content-center pb-md-5 pt-md-4">
        <div class="col-lg-3 column hover">
            <a href="product.php?product_id= <?= $top_list[3]->id ?> "><img class="prod" src= <?= $top_list[3]->image_path ?> width="90%">
            <p class="top"> <?= $top_list[3]->title ?> </p></a>
        </div>
        <div class="col-lg-3 column hover">
            <a href="product.php?product_id= <?= $top_list[4]->id ?> "><img class="prod" src= <?= $top_list[4]->image_path?> width="90%">
            <p class="top"> <?= $top_list[4]->title ?> </p></a>
        </div>
        <div class="col-lg-3 column hover">
            <a href="product.php?product_id= <?= $top_list[5]->id ?> "><img class="prod" src= <?= $top_list[5]->image_path ?> width="90%">
                <p class="top"> <?= $top_list[5]->title ?> </p></a>
        </div>


