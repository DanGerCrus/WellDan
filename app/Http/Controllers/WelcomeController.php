<?php

namespace App\Http\Controllers;

use App\Models\Ingredient;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class WelcomeController extends Controller
{
    public function index(Request $request): Response
    {
        $data = [
            'products_select' => Product::autocomplete(),
            'ingredients_select' => Ingredient::getForSelect(),
        ];
        $products = (new ProductsController())->datatable($request);
        $orders = (new OrderController())->datatable($request, true);

        return response()->view('welcome', array_merge($data, $products, $orders));
    }
}
