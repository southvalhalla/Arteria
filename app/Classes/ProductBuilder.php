<?php

namespace App\Classes;

use App\Classes\Product;

class ProductBuilder {

    private $id;
    private $name;
    private $price;
    private $quantity;

    public function withId($id) {
        $this->id = $id;
        return $this;
    }

    public function withName($name) {
        $this->name = $name;
        return $this;
    }

    public function withPrice($price) {
        $this->price = $price;
        return $this;
    }

    public function withQuantity($quantity) {
        $this->quantity = $quantity;
        return $this;
    }

    public function build() {
        $product = new Product();
        $product->id = $this->id;
        $product->name = $this->name;
        $product->price = $this->price;
        $product->quantity = $this->quantity;
        return $product;
    }
}
