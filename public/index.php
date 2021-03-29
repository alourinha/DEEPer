<?php

require_once  '../src/setup.php';

?>
<!doctype html>
<html lang="en">
<head>
    <?php include 'boilerplates/header.php' ?>
    <link id="css" rel="stylesheet" href="css/style-home.css">
</head>
<body class="mx-md-auto my-0 p-0">
<div class="container p-0">
    <?php include 'boilerplates/navbar.php' ?>
    <h1 class="col-12 text-center mx-auto mt-5" id="shadow" style="padding-top: 6rem">Retro Dough</h1>
    <h2 class="col-12 text-center m-auto py-5" >Our Top Rated Doughnuts</h2>
    <div class="row m-auto text-center justify-content-center" >
        <?php include 'boilerplates/top_products.php' ?>
    </div>
    <?php include 'boilerplates/footer.php' ?>
</div>
<?php include 'boilerplates/scripts.php' ?>
</body>

</html>

