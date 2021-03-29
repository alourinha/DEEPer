<?php

require_once '../src/setup.php';
/** @var Class $dbProvider*/

$products = $dbProvider->getAllProducts();



?>
<div class="modal fade mb-5 pb-5" id="exampleModalCenter" tabindex="-1" role="dialog"  aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-xl " role="document">
        <div class="modal-content" style="background-color: #4AB5D2;">
            <div class="modal-header">
                <h5 class="modal-title text-white" id="exampleModalLongTitle">Our Products</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-white" >
                <div class="container" style="background-color: #abdde5">
                    <div class="row py-5 pl-5">
                        <?php foreach ($products as $product) : ?>
                        <div class="col-sm-4">
                            <a href="product.php?product_id=<?= $product->id ?>"><img class="prod" src=<?= $product->image_path?> width="40%"  >
                                <p class="prodName"><?= $product->title ?></p></a>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>