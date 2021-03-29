<?php

use App\Entity\Product;
use Carbon\Carbon;

require_once '../src/setup.php';

if (!empty($_POST['title']) && !empty($_POST['description'])) {
    $formData = [
        'title' => strip_tags($_POST['title']),
        'description' => strip_tags($_POST['description']),
        'glutten_free' => $_POST['glutten_free'],
        'has_filling' => $_POST['has_filling'],
        'keywords' => $_POST['keywords'],
    ];

    $formProduct = new Product();
    $formProduct->title = $formData['title'];
    $formProduct->description = $formData['description'];
    $formProduct->has_filling = $formData['has_filling'];
    $formProduct->glutten_free = $formData['glutten_free'];
    $formProduct->keywords = $formData['keywords'];

    $formProduct->image_path = 'images/'.$carbon::now()->timestamp.'.jpg';
    move_uploaded_file($_FILES['picture']['tmp_name'], $formProduct->image_path);

    // Create Product
    $product = $dbProvider->createProduct($formProduct);
    header('Location: product.php?product_id=' . $product->id);
    exit;
}
// deal with empty submission
?>
<h1 class="pl-3">Add New Doughnut</h1>
<hr>
<form enctype="multipart/form-data" id="myForm" method="post">
    <div class="row m-auto">
    <div class="col-md-5 col-sm-12">
        <label for="title">Title</label>
        <input class="form-control" name="title" id="title" placeholder="Title">
        <label for="description">Description</label>
        <textarea class="form-control" name="description" id="description" placeholder="Description" rows="10"></textarea>
    </div>
    <div class="col-md-5 col-sm-12">
        <p>Glutten Free?</p>
        <input type="radio" id="gfTrue" name="glutten_free" value="true">
        <label for="gfTrue">True</label><br>
        <input type="radio" id="gfFalse" name="glutten_free" value="false">
        <label for="gfFalse">False</label><br>
        <p>Has Filling?</p>
        <input type="radio" id="fTrue" name="has_filling" value="true">
        <label for="fTrue">True</label><br>
        <input type="radio" id="fFalse" name="has_filling" value="false">
        <label for="fFalse">False</label><br>
        <label for="keywords">Keywords</label>
        <input name="keywords" id="keywords" placeholder="keywords">
        <br>
        <label for="picture">Picture</label>
        <input  type="file" id="picture" name="picture" value="" ><br>
        <button type="submit" class="btn btn-primary py-2 my-3">Create</button>
    </div>

    </div>
    <hr>

</form>
