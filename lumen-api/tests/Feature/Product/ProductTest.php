<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;
//use Illuminate\Foundation\Testing\WithFaker;

class ProductTest extends TestCase
{
    use DatabaseTransactions;
//    use WithFaker;

    /** @test **/
    public function add_product_ability_can_add_products()
    {
//        $this->get('/');
//
//        $this->assertEquals(
//            $this->app->version(), $this->response->getContent()
//        );
    }
}
