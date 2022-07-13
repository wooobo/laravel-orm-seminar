<?php

namespace Tests\Models;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use DatabaseTransactions;

    public function test_all_category()
    {
        $this->prepareLogger();
        Category::all();
    }

    public function test_all_product()
    {
        $this->prepareLogger();
        $product = Product::all();

        $this->assertNotEmpty($product);
    }

    public function test_product_category_join()
    {
        $this->prepareLogger();

        $product = Product::first();
        $category = $product->category;

        $this->assertNotEmpty($category);
    }

    public function test_product_category_eager_loading()
    {
        $this->prepareLogger();

        $product = Product::with('category')->first();

        dump($product->toArray());
        $this->assertNotEmpty($product);
    }

    public function test_product_category_eager_loading_protected_add()
    {
        //protected $with = ['category'];
        $this->prepareLogger();

        $product = Product::first();

        dump($product->toArray());
        $this->assertNotEmpty($product);
    }

    public function test_product_to_category_save()
    {
        $this->prepareLogger();

        $product = Product::first();
        $category = $product->category;
        $category->name = '수정';
        $product->save();
        $category->save();

        dump($product->toArray());
        $this->assertNotEmpty($product);
    }

    private function prepareLogger()
    {
        DB::listen(function ($query) {
            dump("----------------------------------------------------------------");
            dump('sql => ' . $query->sql);
            dump($query->bindings);
            dump('elapsed time => ' . $query->time);
        });
    }
}
