<?php

class Book
{
    public int $id;
    public string $title;
    public string $author;
    public string $description;
    public string $price;
    public string $image_url;
    public string $quantity;
    public string $cost_per_quantity;

    public function __construct($id, $title, $author, $description, $price, $image_url, $quantity, $cost_per_quantity)
    {
        $this->id = $id;
        $this->title = $title;
        $this->author = $author;
        $this->description = $description;
        $this->price = $price;
        $this->image_url = $image_url;
        $this->quantity = $quantity;
        $this->cost_per_quantity = $cost_per_quantity;
    }
}
