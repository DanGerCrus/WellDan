<?php

namespace App\Http\Controllers;

use App\Http\FilterTrait;
use App\Http\OrderTrait;
use App\Models\Ingredient;
use App\Models\Order;
use App\Models\OrderHasProduct;
use App\Models\OrderHistory;
use App\Models\OrderProductIngredient;
use App\Models\OrderStatus;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rule;
use Illuminate\Support\Carbon;

class OrderController extends Controller
{
    use FilterTrait;
    use OrderTrait;

    public static array $orderFields = [
        'client_id',
        'creator_id',
        'date_order'
    ];

    public static array $filterFields = [
        'max_date_order' => [
            'type' => null,
            'action' => '<='
        ],
        'min_date_order' => [
            'type' => null,
            'action' => '>='
        ],
        'client_id' => [
            'type' => '0',
            'action' => '='
        ],
        'creator_id' => [
            'type' => '0',
            'action' => '='
        ],
    ];

    public function __construct()
    {
        $this->middleware('permission:order-list|order-create|order-edit', ['show']);
        $this->middleware('permission:order-list', ['only' => ['index']]);
        $this->middleware('permission:order-create', ['only' => ['create', 'store', 'repeat', 'cancel']]);
        $this->middleware('permission:order-edit', ['only' => ['edit', 'update', 'destroy']]);
    }

    public function datatable(Request $request, bool $currentUser = false): array
    {
        self::setDefaultOrder(['date_order' => 'desc']);
        $orders = Order::with(
            'status',
            'creator',
            'client',
            'products.ingredients.ingredient',
            'products.product'
        );
        if ($currentUser) {
            $orders = $orders->where('client_id', '=', Auth::id())
                ->orWhere('creator_id', '=', Auth::id());
        }
        $orders = self::filterData($request, $orders);
        $orders = self::orderData($request, $orders);
        $orders = $orders->paginate(15);

        return [
            'orders' => $orders,
            'users_select' => User::autocomplete(),
            'orders_filter' => self::filterGenerate($request),
            'orders_order' => self::orderGenerate($request)
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): Response
    {
        return response()->view('orders.index', $this->datatable($request));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): Response
    {
        return response()->view('orders.create', [
            'products_select' => Product::autocomplete(),
            'ingredients_select' => Ingredient::getForSelect(),
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
            'products.*.ingredients' => ['array'],
            'products.*.ingredients.*.id' => ['integer', 'nullable'],
            'products.*.ingredients.*.count' => ['integer'],
        ]);
        $fields = [
            'status_id' => 1,
            'creator_id' => Auth::user()->id,
            'client_id' => $request->post('client_id'),
            'date_order' => Carbon::now()->toDateTime(),
        ];

        $orderID = Order::query()->create($fields)->id;
        OrderHistory::query()->create([
            'order_id' => $orderID,
            'status_id' => $fields['status_id'],
        ]);

        foreach ($request->post('products') as $product) {
            $orderProductFields = [
                'order_id' => $orderID,
                'product_id' => $product['id'],
                'count' => $product['count'],
            ];
            $orderProductID = OrderHasProduct::query()->create($orderProductFields)->id;
            $ingredients = [];
            if (!empty($product['ingredients'])) {
                foreach ($product['ingredients'] as $ingredient) {
                    if (!empty($ingredient['id']) && !empty($ingredient['count']) && $ingredient['count'] > 0 && !in_array($ingredient['id'], $ingredients)) {
                        $orderProductIngredientFields = [
                            'order_product_id' => $orderProductID,
                            'ingredient_id' => $ingredient['id'],
                            'count' => $ingredient['count'],
                        ];
                        $ingredients[] = $ingredient['id'];
                        OrderProductIngredient::query()->create($orderProductIngredientFields);
                    }
                }
            }
        }

        if ($request->has('basket_clear')) {
            BasketController::clear($request->post('client_id'));
            return Redirect::route('basket.index')->with('status', 'order-created');
        }

        $route = 'orders.create';
        if ($request->has('welcome')) {
            $route = 'welcome';
        }

        return Redirect::route($route)->with('status', 'order-created');
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id): Response
    {
        $order = Order::with(
            'status',
            'creator',
            'client',
            'products.ingredients.ingredient',
            'products.product'
        )
            ->findOrFail($id);
        $history = OrderHistory::query()
            ->select(
                'id',
                'status_id',
                DB::raw('DATE_FORMAT(created_at, "%d.%m.%Y %h:%i") as date'),
            )
            ->with('status')
            ->where('order_id', '=', $order->id)
            ->get();

        return response()->view('orders.show', [
            'order' => $order,
            'history' => $history,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id): Response
    {
        $order = Order::with(
            'status',
            'creator',
            'client',
            'products.ingredients'
        )
            ->findOrFail($id);
        $orderStatuses = OrderStatus::select('id', 'name')
            ->get();
        $nextStatuses = explode(',', $order->status->next_status_id);
        $statuses = collect([]);
        foreach ($orderStatuses as $status) {
            if ($status->id === $order->status->id || in_array((string)$status->id, $nextStatuses)) {
                $statuses->push((object)[
                    'value' => $status->id,
                    'label' => $status->name,
                ]);
            }
        }

        return response()->view('orders.edit', [
            'order' => $order,
            'statuses' => $statuses,
            'products' => Product::autocomplete(),
            'ingredients' => Ingredient::getForSelect(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        $request->validate([
            'status_id' => ['required', 'integer', Rule::exists(OrderStatus::class, 'id')],
            'products' => ['required', 'array'],
            'products.*' => ['required', 'array'],
            'products.*.id' => ['required', 'integer', Rule::exists(Product::class, 'id')],
            'products.*.count' => ['required', 'integer', 'min:1'],
            'products.*.ingredients' => ['array'],
            'products.*.ingredients.*.id' => ['integer', 'nullable'],
            'products.*.ingredients.*.count' => ['integer'],
        ]);

        $fields = [
            'status_id' => $request->post('status_id'),
        ];
        $order = Order::find($id);
        $order->update($fields);
        $orderHistory = OrderHistory::query()->where('order_id', $id)->orderBy('id', 'desc')->first();
        if ($order->status_id !== $orderHistory->status_id) {
            OrderHistory::query()->create([
                'order_id' => $id,
                'status_id' => $fields['status_id'],
            ]);
        }

        if ($request->has('products')) {
            $orderProductsID = OrderHasProduct::query()
                ->where('order_id', '=', $id)
                ->pluck('id');
            OrderProductIngredient::query()
                ->whereIn('order_product_id', $orderProductsID)
                ->delete();
            OrderHasProduct::query()
                ->where('order_id', '=', $id)
                ->delete();
            foreach ($request->post('products') as $product) {
                $orderProductFields = [
                    'order_id' => $id,
                    'product_id' => $product['id'],
                    'count' => $product['count'],
                ];
                $ingredients = [];
                $orderProductID = OrderHasProduct::query()->create($orderProductFields)->id;
                if (!empty($product['ingredients'])) {
                    foreach ($product['ingredients'] as $ingredient) {
                        if (!empty($ingredient['id']) && !empty($ingredient['count']) && $ingredient['count'] > 0 && !in_array(
                                $ingredient['id'],
                                $ingredients
                            )) {
                            $orderProductIngredientFields = [
                                'order_product_id' => $orderProductID,
                                'ingredient_id' => $ingredient['id'],
                                'count' => $ingredient['count'],
                            ];
                            $ingredients[] = $ingredient['id'];
                            OrderProductIngredient::query()->create($orderProductIngredientFields);
                        }
                    }
                }
            }
        }

        return Redirect::route('orders.edit', $id)->with('status', 'order-updated');
    }

    public function repeat(int $id): RedirectResponse
    {
        $order = Order::with(
            'status',
            'creator',
            'client',
            'products.ingredients.ingredient',
            'products.product'
        )
            ->findOrFail($id);

        $repeatID = Order::query()->create([
            'status_id' => 1,
            'creator_id' => Auth::user()->id,
            'client_id' => $order->client_id,
            'date_order' => Carbon::now()->toDateTime(),
        ])->id;

        if (!empty($order->products) && $order->products->isNotEmpty()) {
            foreach ($order->products as $product) {
                $orderProductID = OrderHasProduct::query()->create([
                    'order_id' => $repeatID,
                    'product_id' => $product->product_id,
                    'count' => $product->count,
                ])->id;
                if (!empty($product->ingredients) && $product->ingredients->isNotEmpty()) {
                    foreach ($product->ingredients as $ingredient) {
                        OrderProductIngredient::query()->create([
                            'order_product_id' => $orderProductID,
                            'ingredient_id' => $ingredient->ingredient_id,
                            'count' => $ingredient->count,
                        ]);
                    }
                }
            }
        }

        return Redirect::route('orders.show', $repeatID)->with('status', 'order-repeat');
    }

    public function cancel(int $id): RedirectResponse
    {
        Order::query()->findOrFail($id)->update([
            'status_id' => 7
        ]);

        return Redirect::route('orders.show', $id)->with('status', 'order-cancel');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): RedirectResponse
    {
        Order::findOrFail($id)->delete();

        return redirect()->route('orders.index');
    }
}
