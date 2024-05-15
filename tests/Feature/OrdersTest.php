<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Tests\TestCase;

class OrdersTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_orders_controller_index_success(): void
    {
        $user = User::factory()->create();
        $user->syncPermissions(['order-list']);

        $response = $this
            ->actingAs($user)
            ->get('/orders');

        $response->assertViewIs('orders.index');
        $response->assertViewHasAll([
            'orders',
            'users_select',
            'orders_filter',
            'orders_order',
        ]);
        $response->assertStatus(200);
    }

    public function test_orders_controller_index_no_rules(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->get('/orders');

        $response->assertStatus(403);
    }

    public function test_orders_controller_show_success(): void
    {
        $order = Order::factory()->create();
        $user = User::factory()->create();
        $user->syncPermissions(['order-create']);

        $response = $this
            ->actingAs($user)
            ->get('/orders/' . $order->id);

        $response->assertViewIs('orders.show');
        $response->assertViewHasAll([
            'order' => $order,
        ]);
        $response->assertStatus(200);
    }

    public function test_orders_controller_show_no_rules(): void
    {
        $order = Order::factory()->create();
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->get('/orders/' . $order->id);

        $response->assertStatus(403);
    }

    public function test_orders_controller_create_success(): void
    {
        $user = User::factory()->create();
        $user->syncPermissions(['order-create']);

        $response = $this
            ->actingAs($user)
            ->get('/orders/create');

        $response->assertViewIs('orders.create');
        $response->assertViewHasAll([
            'products_select',
            'ingredients_select',
        ]);
        $response->assertStatus(200);
    }

    public function test_orders_controller_create_no_rules(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->get('/orders/create');

        $response->assertStatus(403);
    }

    public function test_orders_controller_edit_success(): void
    {
        $order = Order::factory()->create();
        $user = User::factory()->create();
        $user->syncPermissions(['order-edit']);

        $response = $this
            ->actingAs($user)
            ->get('/orders/' . $order->id . '/edit');

        $response->assertViewIs('orders.edit');
        $response->assertViewHasAll([
            'order',
            'statuses',
            'products',
            'ingredients',
        ]);
        $response->assertStatus(200);
    }

    public function test_orders_controller_edit_no_rules(): void
    {
        $order = Order::factory()->create();
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->get('/orders/' . $order->id . '/edit');

        $response->assertStatus(403);
    }

    public function test_orders_controller_store_success(): void
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();
        $user->syncPermissions(['order-create']);

        $response = $this
            ->actingAs($user)
            ->from('/orders/create')
            ->post('/orders', [
                'products' => [
                    [
                        'id' => $product->id,
                        'count' => 2,
                        'ingredients' => [
                            [
                                'id' => 0,
                                'count' => 0
                            ],
                        ]
                    ]
                ],
            ]);

        $response->assertRedirectToRoute('orders.create');
        $response->assertSessionHas('status', 'order-created');
        $response->assertStatus(302);
    }

    public function test_orders_controller_store_no_rules(): void
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();

        $response = $this
            ->actingAs($user)
            ->from('/orders/create')
            ->post('/orders', [
                'products' => [
                    [
                        'id' => $product->id,
                        'count' => 2,
                        'ingredients' => [
                            [
                                'id' => 0,
                                'count' => 0
                            ],
                        ]
                    ]
                ],
            ]);

        $response->assertStatus(403);
    }

    public function test_orders_controller_store_no_products_ingredients(): void
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();
        $user->syncPermissions(['order-create']);

        $response = $this
            ->actingAs($user)
            ->from('/orders/create')
            ->post('/orders', [
                'products' => [
                    [
                        'id' => $product->id,
                        'count' => 2,
                    ]
                ],
            ]);

        $response->assertRedirectToRoute('orders.create');
        $response->assertInvalid(['products.0.ingredients']);
        $response->assertStatus(302);
    }

    public function test_orders_controller_update_success(): void
    {
        $order = Order::factory()->create();
        $user = User::factory()->create();
        $product = Product::factory()->create();
        $user->syncPermissions(['order-edit']);

        $response = $this
            ->actingAs($user)
            ->from('/orders/' . $order->id . '/edit')
            ->patch('/orders/' . $order->id, [
                'status_id' => 1,
                'products' => [
                    [
                        'id' => $product->id,
                        'count' => 2,
                        'ingredients' => [
                            [
                                'id' => 0,
                                'count' => 0
                            ],
                        ]
                    ]
                ],
            ]);

        $response->assertRedirectToRoute('orders.edit', $order->id);
        $response->assertSessionHas('status', 'order-updated');
        $response->assertStatus(302);
    }

    public function test_orders_controller_update_no_rules(): void
    {
        $order = Order::factory()->create();
        $user = User::factory()->create();
        $product = Product::factory()->create();

        $response = $this
            ->actingAs($user)
            ->from('/orders/' . $order->id . '/edit')
            ->patch('/orders/' . $order->id, [
                'status_id' => 1,
                'products' => [
                    [
                        'id' => $product->id,
                        'count' => 2,
                        'ingredients' => [
                            [
                                'id' => 0,
                                'count' => 0
                            ],
                        ]
                    ]
                ],
            ]);

        $response->assertStatus(403);
    }

    public function test_orders_controller_update_no_products_ingredients(): void
    {
        $order = Order::factory()->create();
        $user = User::factory()->create();
        $product = Product::factory()->create();
        $user->syncPermissions(['order-edit']);

        $response = $this
            ->actingAs($user)
            ->from('/orders/' . $order->id . '/edit')
            ->patch('/orders/' . $order->id, [
                'status_id' => 1,
                'products' => [
                    [
                        'id' => $product->id,
                        'count' => 2,
                    ]
                ],
            ]);

        $response->assertRedirectToRoute('orders.edit', $order->id);
        $response->assertInvalid(['products.0.ingredients']);
        $response->assertStatus(302);
    }

    public function test_orders_controller_cancel_success(): void
    {
        $order = Order::factory()->create();
        $user = User::factory()->create();
        $user->syncPermissions(['order-create']);

        $response = $this
            ->actingAs($user)
            ->from('/orders/' . $order->id)
            ->post('/orders/' . $order->id . '/cancel');

        $response->assertRedirectToRoute('orders.show', $order->id);
        $response->assertSessionHas('status', 'order-cancel');
        $response->assertStatus(302);
    }

    public function test_orders_controller_cancel_no_rules(): void
    {
        $order = Order::factory()->create();
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->from('/orders/' . $order->id)
            ->post('/orders/' . $order->id . '/cancel');

        $response->assertStatus(403);
    }

    public function test_orders_controller_repeat_success(): void
    {
        $order = Order::factory()->create();
        $user = User::factory()->create();
        $user->syncPermissions(['order-create']);

        $response = $this
            ->actingAs($user)
            ->from('/orders/' . $order->id)
            ->post('/orders/' . $order->id . '/repeat');

        $response->assertRedirectToRoute('orders.show', $order->id + 1);
        $response->assertSessionHas('status', 'order-repeat');
        $response->assertStatus(302);
    }

    public function test_orders_controller_repeat_no_rules(): void
    {
        $order = Order::factory()->create();
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->from('/orders/' . $order->id)
            ->post('/orders/' . $order->id . '/repeat');

        $response->assertStatus(403);
    }

    public function test_orders_controller_destroy_success(): void
    {
        $order = Order::factory()->create();
        $user = User::factory()->create();
        $user->syncPermissions(['order-edit']);

        $response = $this
            ->actingAs($user)
            ->from('/orders/' . $order->id)
            ->delete('/orders/' . $order->id);

        $response->assertRedirectToRoute('orders.index');
        $response->assertStatus(302);
    }

    public function test_orders_controller_destroy_no_rules(): void
    {
        $order = Order::factory()->create();
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->from('/orders/' . $order->id)
            ->delete('/orders/' . $order->id);

        $response->assertStatus(403);
    }
}
