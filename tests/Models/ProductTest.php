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

        $this->assertTrue(true);
    }

    /**
     * 상품 전체 조회
     */
    public function test_all_product()
    {
        $this->prepareLogger();
        $product = Product::all();
        // select * from `products`

        $this->assertNotEmpty($product);
    }

    /**
     * 상품->카테고리 모델 가져오기
     */
    public function test_product_category_join()
    {
        $this->prepareLogger();

        $product = Product::first();
        // select * from `products` limit 1
        $category = $product->category;
        // select * from `categories` where `categories`.`id` = ? limit 1

        $this->assertNotEmpty($category);
    }

    /**
     * 상품 전체 목록을 가져와서, 카테고리 데이터 접근시 발생 하는 N+1 문제
     */
    public function test_product_category_n1_problem()
    {
        $this->prepareLogger();

        $products = Product::all();
        $categoryNames = [];
        foreach ($products as $product) {
            // 상품의 수(N)만큼 쿼리가 추가적으로 발생
            $categoryNames[] = $product->category->name ?? '';
        }

        $this->assertNotEmpty($categoryNames);
    }

    /**
     * N+1 문제를 해결하기 위한 다양한 방법이 있음,
     * with 를 활용하기
     */
    public function test_product_category_n1_problem_with()
    {
        $this->prepareLogger();

        $products = Product::with('category')->get();
        $categoryNames = [];
        foreach ($products as $product) {
            // 이미 로딩되어 있으므로 쿼리를 N개 만큼 보내지 않음
            $categoryNames[] = $product->category->name ?? '';
        }

        dump($categoryNames);
        $this->assertNotEmpty($categoryNames);
    }

    /**
     * 모델에 `$with` 속성을 지정하면, 모든 쿼리조회시 기본적으로 즉시로딩이 됩니다.
     * protected $with = ['category'];
     */
    public function test_product_category_eager_loading_protected_add()
    {
        $this->prepareLogger();

        $product = Product::all();

        $this->assertNotEmpty($product);
    }

    /**
     * 즉시로딩 제거하기
     * 이미 with 가 지정되어있고 많은 곳에서 사용하고있다면, 제거하기 힘들수 있음
     * 그럴때는, setEagerLoads 활용해 볼수있음
     * 하지만, 근본적으로 with(즉시로딩)이 문제이므로 setEagerLoads 를 난발하는것 또한 문제
     */
    public function test_setEagerLoads()
    {
        $this->prepareLogger();
        $product1 = Product::get();
        $product2 = Product::setEagerLoads([])->get();

        $this->assertTrue(true);
    }

    /**
     * Product->category 와 Product->category() 의 차이
     * Product->category 는 모델을 가져옴
     * Product->category() 는 쿼리 빌더임
     */
    public function test_attribute_builder()
    {
        $this->prepareLogger();

        $product = Product::first();
        $categoryQueryBuilder = $product->category();
        $categoryModel = $product->category;
        $categoryModel2 = $categoryQueryBuilder->first();

        $this->assertTrue(true);
    }

    /**
     * 특정 컬럼만 조회하기
     */
    public function test_select_column(){
        $this->prepareLogger();

        $product = Product::select('price')->first();

        dump($product->toArray());
        $this->assertTrue(true);
    }

    /**
     * join 쿼리 활용시
     * 같은 컬럼 데이터 덮어 씌워짐
     */
    public function test_join()
    {
        $this->prepareLogger();

        // 같은 이름의 컬럼을 덮어 씌워버림
        $product = Product::join('categories', 'categories.id', '=', 'products.category_id')->first();

        dump($product->toArray());
        $this->assertTrue(true);
    }

    /**
     * join 쿼리 사용시 컬럼을 지정하는 것이 좋아 보임
     */
    public function test_join_where()
    {
        $this->prepareLogger();

        // 조회 컬럼 지정
        $products = Product::select('products.*', 'categories.name as cateName')
            ->join('categories', 'categories.id', '=', 'products.category_id')
            ->where('categories.id', 2)
            ->get();

        dump($products->toArray());
        $this->assertTrue(true);
    }

    /**
     * has
     * whereHas
     */
    public function test_has() {
        $this->prepareLogger();

        $products1 = Product::whereHas('category', function($query) {
            $query->where('name', '=', '의류');
        })->get();
        $products2 = Product::has('category')->get();

        dump($products1->toArray());
        dump($products2->toArray());
        $this->assertTrue(true);
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
