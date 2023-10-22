<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderHasProduct;
use App\Models\OrderStatus;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rule;
use Illuminate\Support\Carbon;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        $orders = Order::with('status', 'creator')
            ->orderBy('date_order', 'desc')
            ->get();

        return response()->view('orders.index', [
            'orders' => $orders
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        $statuses = OrderStatus::select('id as value', 'name as label')
            ->get();
        $products = Product::selectRaw('
            products.id as value,
            CONCAT(products_categories.name, " ", products.name) as label
        ')
            ->join('products_categories', 'products_categories.id', '=', 'products.category_id')
            ->orderBy('products.name')
            ->get();
        return response()->view('orders.create', [
            'statuses' => $statuses,
            'products' => $products,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'products' => ['required', 'array'],
            'products.*' => ['required', 'array'],
            'products.*.id' => ['required', 'integer', Rule::exists(Product::class, 'id')],
            'products.*.count' => ['required', 'integer', 'min:1'],
        ]);

        $fields = [
            'status_id' => 1,
            'creator_id' => Auth::user()->id,
            'date_order' => Carbon::now()->toDateTime(),
        ];

        $orderID = Order::query()->updateOrCreate(['id' => 0], $fields)->id;

        foreach ($request->post('products') as $product) {
            $orderProductFields = [
                'order_id' => $orderID,
                'product_id' => $product['id'],
                'count' => $product['count'],
            ];
            OrderHasProduct::query()->create($orderProductFields);
        }

        return Redirect::route('orders.create')->with('status', 'order-created');
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id): Response
    {
        $order = Order::with('status', 'creator')
            ->find($id);

        return response()->view('orders.show', [
            'order' => $order,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id): Response
    {
        $order = Order::with('status', 'creator', 'products')
            ->find($id);

        $statuses = OrderStatus::select('id as value', 'name as label')
            ->get();
        $products = Product::selectRaw('
            products.id as value,
            CONCAT(products_categories.name, " ", products.name) as label
        ')
            ->join('products_categories', 'products_categories.id', '=', 'products.category_id')
            ->orderBy('products.name')
            ->get();

        return response()->view('orders.edit', [
            'order' => $order,
            'statuses' => $statuses,
            'products' => $products,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): RedirectResponse
    {
        $request->validate([
            'status_id' => ['integer', Rule::exists(OrderStatus::class, 'id')],
            'products' => ['array'],
            'products.*' => ['required', 'array'],
            'products.*.id' => ['required', 'integer', Rule::exists(Product::class, 'id')],
            'products.*.count' => ['required', 'integer', 'min:1'],
        ]);

        $fields = [
            'status_id' => $request->post('status_id'),
        ];

        Order::find($id)->update($fields);

        if ($request->has('products')) {
            $currentProducts = OrderHasProduct::query()->select('id', 'product_id')
                ->where('order_id', '=', $id)
                ->pluck('id', 'product_id')
                ->toArray();
            foreach ($request->post('products') as $product) {
                $orderProductID = 0;
                $orderProductFields = [
                    'order_id' => $id,
                    'product_id' => $product['id'],
                    'count' => $product['count'],
                ];

                if (!empty($currentProducts[$product['id']])) {
                    $orderProductID = $currentProducts[$product['id']];
                }

                OrderHasProduct::find($orderProductID)->update($orderProductFields);
            }
        }

        return Redirect::route('orders.edit', $id)->with('status', 'order-updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): RedirectResponse
    {
        OrderHasProduct::where('order_id', '=', $id)->delete();
        Order::find($id)->delete();

        return redirect()->route('orders.index');
    }
}
