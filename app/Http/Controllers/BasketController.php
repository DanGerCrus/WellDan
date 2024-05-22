<?php

namespace App\Http\Controllers;

use App\Models\Basket;
use App\Models\BasketIngredient;
use App\Models\Ingredient;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rule;

class BasketController extends Controller
{
    public function index(Request $request): Response
    {
        $user = User::query()->with('basket.product', 'basket.ingredients')->findOrFail(Auth::id());

        return response()->view('basket.index', [
            'basket' => $user->basket,
            'products' => Product::autocomplete(),
            'ingredients' => Ingredient::getForSelect(),
        ]);
    }

    public function store(int $productID, Request $request): RedirectResponse
    {
        $ownerID = Auth::user()->id;
        $count = (int)Basket::query()
            ->where('owner_id', '=', $ownerID)
            ->where('product_id', '=', $productID)
            ->value('count');
        if ($count === 0) {
            Basket::query()
                ->create([
                    'owner_id' => $ownerID,
                    'product_id' => $productID,
                    'count' => 1
                ]);
        } else {
            Basket::query()
                ->where('owner_id', '=', $ownerID)
                ->where('product_id', '=', $productID)
                ->update([
                    'count' => $count + 1
                ]);
        }

        return Redirect::to($request->post('route'))->with('status', 'basket-created');
    }

    public function update(Request $request): RedirectResponse
    {
        if (!$request->has('products')) {
            $ownerID = Auth::id();
            Basket::query()
                ->where('owner_id', '=', $ownerID)
                ->delete();
        } else {
            $request->validate([
                'products' => ['required', 'array'],
                'products.*' => ['required', 'array'],
                'products.*.id' => ['required', 'integer', Rule::exists(Product::class, 'id')],
                'products.*.count' => ['required', 'integer', 'min:1'],
                'products.*.ingredients' => ['required', 'array'],
                'products.*.ingredients.*.id' => ['integer', 'nullable'],
                'products.*.ingredients.*.count' => ['integer'],
            ]);
            $ownerID = Auth::id();
            Basket::query()
                ->where('owner_id', '=', $ownerID)
                ->delete();
            foreach ($request->post('products') as $product) {
                Basket::query()
                    ->create([
                        'owner_id' => $ownerID,
                        'product_id' => $product['id'],
                        'count' => $product['count']
                    ]);
                $basketID = Basket::query()
                    ->where('owner_id', '=', $ownerID)
                    ->where('product_id', '=', $product['id'])
                    ->value('id');
                BasketIngredient::query()->where('basket_id', '=', $basketID)->delete();
                foreach ($product['ingredients'] as $ingredient) {
                    if (!empty($ingredient['id']) && !empty($ingredient['count'])) {
                        $basketIngredientFields = [
                            'basket_id' => $basketID,
                            'ingredient_id' => $ingredient['id'],
                            'count' => $ingredient['count'],
                        ];
                        BasketIngredient::query()->create($basketIngredientFields);
                    }
                }
            }
        }

        return Redirect::route('basket.index')->with('status', 'basket-updated');
    }

    public static function clear(int $ownerID): void
    {
        $basketIDs = Basket::query()
            ->where('owner_id', '=', $ownerID)
            ->pluck('id');
        BasketIngredient::query()->whereIn('basket_id', $basketIDs)->delete();
        Basket::query()
            ->where('owner_id', $ownerID)
            ->delete();
    }
}
