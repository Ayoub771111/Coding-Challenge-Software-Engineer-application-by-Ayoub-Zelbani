<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Product;
use App\Models\Category;

class CreateProduct extends Command
{
    protected $signature = 'product:create {name} {description} {price} {categories*}';
    protected $description = 'Create a new product';

    public function handle()
    {
        $name = $this->argument('name');
        $description = $this->argument('description');
        $price = $this->argument('price');
        $categoriesIds = $this->argument('categories');

        $product = Product::create([
            'name' => $name,
            'description' => $description,
            'price' => $price,
            // 'image' => 'path/to/image' // Handle as per your logic
        ]);

        $product->categories()->sync($categoriesIds);

        $this->info("Product {$product->name} created successfully.");
    }
}
