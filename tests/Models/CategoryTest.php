<?php

namespace Tests\Models;

use App\Models\Category;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use DatabaseTransactions;

    public function test_category() {
        $this->prepareLogger();

        $category = Category::first();
    }

    public function test_category_to_product() {
        $this->prepareLogger();
        $product = Category::first()->products;

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
