<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;
//use Illuminate\Foundation\Testing\WithFaker;

class OrderTest extends TestCase
{
    use DatabaseTransactions;
//    use WithFaker;

    /** @test **/
    public function manage_order_ability_can_change_order_status()
    {
        $rick = $this->signIn()->assignRole('super-admin');

        $order = factory(\App\Models\Order::class)->create();

//        $testRole = Role::create(['name' => 'admin']);
//        $testRole->givePermissionTo(['manage-orders', 'edit-products']); //, 'delete-products'
        $response = $this->json('PUT', env('APP_API_URL').'/order/'.$order->id, $newParams = $this->getNewOrderParams());

        $response->seeStatusCode(202);

        $this->seeInDatabase('orders', [
            'order_id' => $order->id,
            'status' => $newParams['status'],
            //'user_id' => $rick->id,
        ]);
    }

    /** @test **/
    public function unauthorized_user_cannot_change_order_status()
    {

    }

    /**
     * @param array $override
     *
     * @return array
     */
    private function getNewOrderParams($override = [])
    {
        return array_merge([
            'status' => 'processing',
        ], $override);
    }
}
