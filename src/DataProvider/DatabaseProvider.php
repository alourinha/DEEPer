<?php

namespace App\DataProvider;

use App\Entity\CheckIn;
use App\Entity\Product;
use App\Entity\User;
use App\Hydrator\Hydrator;
use PDO;

class DatabaseProvider
{
    private \PDO $dbh;

    public function __construct()
    {
        try {
            $this->dbh = new PDO(
                'mysql:dbname=project;host=mysql',
                $_ENV['username'],
                $_ENV['password']
            );

            $this->dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        } catch (PDOException $e) {
            die('Unable to establish a database connection');
        }

    }

    public function getAllProducts(): array
    {
        $product_array = [];
        $stmt = $this->dbh->prepare('SELECT id FROM product'
        );

        $stmt->execute();
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($products as $product){
            $stmt = $this->dbh->prepare(
                'SELECT
            p.id AS product_id, p.title, p.description, p.image_path,
            c.id, c.name, c.rating, c.review, c.submitted,
            (
                SELECT AVG(checkins.rating) FROM checkins WHERE product_id = p.id
            ) as average_rating
            FROM product AS p
            LEFT JOIN checkins c ON c.product_id = p.id WHERE p.id = :id'
            );
            $stmt->execute([
                'id' => $product['id']
            ]);

            $productAndCheckInData = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $hydrator = new Hydrator();
            $test = $hydrator->hydrateProductWithCheckIns($productAndCheckInData);
            $product_array[] = $test;

        }
        return $product_array;

    }

    public function getProducts(string $searchTerm): array
    {
        $stmt = $this->dbh->prepare('SELECT id, title, image_path, glutten_free, has_filling, keywords FROM product WHERE title OR keywords LIKE :searchTerm');
        $stmt->execute([
            'searchTerm' => '%' . $searchTerm . '%'
        ]);

        return $stmt->fetchAll(PDO::FETCH_CLASS, Product::class);
    }

    public function getProduct(int $productId): ?Product
    {
        $stmt = $this->dbh->prepare(
            'SELECT
            p.id AS product_id, p.title, p.description, p.image_path,
            c.id, c.name, c.rating, c.review, c.submitted,
            (
                SELECT AVG(checkins.rating) FROM checkins WHERE product_id = p.id
            ) as average_rating
            FROM product AS p
            LEFT JOIN checkins c ON c.product_id = p.id
            WHERE p.id = :id'
        );
        $stmt->execute([
            'id' => $productId
        ]);

        $productAndCheckInData = $stmt->fetchAll(PDO::FETCH_ASSOC);


        $hydrator = new Hydrator();
        return  $hydrator->hydrateProductWithCheckIns($productAndCheckInData);

    }

    public function userReviews(string $user): ?array
    {
        $stmt = $this->dbh->prepare(
            'SELECT
            p.title, c.name, c.rating, c.review, c.submitted
            FROM product AS p
            LEFT JOIN checkins c ON c.product_id = p.id
            WHERE c.name = :name'
        );
        $stmt->execute([
            'name' => $user
        ]);

        return  $stmt->fetchAll(PDO::FETCH_ASSOC);

    }

    public function createProduct(Product $product): Product
    {
        $stmt = $this->dbh->prepare(
            'INSERT INTO product (title, description, image_path, glutten_free, has_filling, keywords)
            VALUES (:title, :description, :image_path, :glutten_free, :has_filling, :keywords)'
        );

        $stmt->execute([
            'title' => $product->title,
            'description' => $product->description,
            'image_path' => $product->image_path,
            'glutten_free' => $product->glutten_free,
            'has_filling' => $product->has_filling,
            'keywords' => $product->keywords,
        ]);

        $lastInsertId = $this->dbh->lastInsertId();
        $newProduct = $this->getProduct($lastInsertId);
        return $newProduct;
    }

    public function getCheckIn(int $checkInId): ?CheckIn
    {
        $stmt = $this->dbh->prepare(
            'SELECT id, product_id, name, rating, review, submitted
            FROM checkins
            WHERE id = :id'
        );
        $stmt->execute(['id' => $checkInId]);

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if (empty($result)) {
            return null;
        }

        $hydrator = new Hydrator();
        return $hydrator->hydrateCheckIn($result);
    }

    public function createCheckin(CheckIn $checkIn): CheckIn
    {
        $stmt = $this->dbh->prepare('
        INSERT INTO checkins (name, rating, review, product_id, submitted)
        VALUE (:name, :rating, :review, :productId, :submitted)
        ');

        $stmt->execute([
            'name' => $checkIn->name,
            'rating' => $checkIn->rating,
            'review' => $checkIn->review,
            'productId' => $checkIn->productId,
            'submitted' => $checkIn->submitted
        ]);

        $lastInsertId = $this->dbh->lastInsertId();
        $newCheckIn = $this->getCheckIn($lastInsertId);

        return $newCheckIn;
    }

    public function getUser(int $userId): ?User
    {
        $stmt = $this->dbh->prepare(
            'SELECT id, name, email_address, password, is_admin
            FROM user
            WHERE id = :id'
        );
        $stmt->execute(['id' => $userId]);

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if (empty($result)) {
            return null;
        }

        $hydrator = new Hydrator();
        return $hydrator->hydrateUser($result);
    }

    public function getUserByEmail(string $email): ?User
    {
        $stmt = $this->dbh->prepare(
            'SELECT id, name, email_address, password
            FROM user
            WHERE email_address = :email'
        );
        $stmt->execute(['email' => $email]);

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if (empty($result)) {
            return null;
        }

        $hydrator = new Hydrator();
        return $hydrator->hydrateUser($result);
    }

    public function createUser(User $user): User
    {
        $stmt = $this->dbh->prepare(
            'INSERT INTO user (`name`, `email_address`, `password`)
            VALUES (:name, :emailAddress, :password)'
        );

        $stmt->execute([
            'name' => $user->name,
            'emailAddress' => $user->emailAddress,
            'password' => $user->password,
        ]);

        $lastInsertId = $this->dbh->lastInsertId();
        $newUser = $this->getUser($lastInsertId);

        return $newUser;
    }
}
