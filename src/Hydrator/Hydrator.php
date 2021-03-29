<?php

namespace App\Hydrator;

use App\Entity\CheckIn;
use App\Entity\Product;
use App\Entity\User;
use Carbon\Carbon;
use App\DataProvider\DatabaseProvider;

class Hydrator
{

    function hydrateProduct(array $data): Product
    {
        $product = new Product();
        $product->id = $data['id'] ?? null;
        $product->title = $data ['title'];
        $product->image_path = $data['image_path'];
        $product->description = $data['description'];
        $product->has_filling = $data['has_filling'] ?? null;
        $product->glutten_free = $data['glutten_free'] ?? null;
        $product->average_rating = $data['average_rating'] ?? null;
        $product->keywords = $data['keywords'] ?? null;

        return $product;
    }

    function hydrateCheckin(array $data): CheckIn
    {
        $checkIn = new CheckIn();
        $checkIn->id = $data['id'] ?? null;
        $checkIn->productId = $data['product_id'] ?? null;
        $checkIn->review = $data['review'] ?? null;
        $checkIn->name = $data['name'] ?? null;
        $checkIn->rating = $data['rating'] ?? null;
        $checkIn->submitted = $data['submitted'] ?? null;


        return $checkIn;
    }

    function hydrateProductWithCheckins(array $data): Product
    {
        $productData = [
            'id' => $data[0]['product_id'],
            'title'=> $data[0]['title'],
            'image_path'=> $data[0]['image_path'],
            'description'=> $data[0]['description'],
            'average_rating' => $data[0]['average_rating'],
        ];
        $product = $this->hydrateProduct($productData);

        foreach ($data as $checkinRow) {
            $checkIn = $this->hydrateCheckin($checkinRow);
            $product ->addCheckin($checkIn);
        }

        return $product;
    }

    public function hydrateUser (array $data): User
    {
        $user = new User();
        $user->id = $data['id'] ?? null;
        $user->name = $data['name'];
        $user->emailAddress = $data['email_address'];
        $user->password = $data['password'];
        $user->isAdmin = $data['is_admin'] ?? null;

        return $user;
    }

}