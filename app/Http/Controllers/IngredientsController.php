<?php

namespace App\Http\Controllers;

use App\Http\FilterTrait;
use App\Http\OrderTrait;
use App\Models\Ingredient;
use App\Models\ProductIngredient;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rule;

class IngredientsController extends Controller
{
    use OrderTrait;
    use FilterTrait;

    public static array $orderFields = [
        'name',
        'kkal',
        'price'
    ];

    public static array $filterFields = [
        'name' => [
            'type' => '',
            'action' => 'like'
        ],
        'max_price' => [
            'type' => '',
            'action' => '<='
        ],
        'min_price' => [
            'type' => '1',
            'action' => '>='
        ],
    ];

    public function __construct()
    {
        $this->middleware('permission:ingredient-list|ingredient-edit|ingredient-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:ingredient-edit', ['only' => ['create', 'store', 'edit', 'update']]);
        $this->middleware('permission:ingredient-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): Response
    {
        $ingredients = Ingredient::query();
        $ingredients = self::filterData($request, $ingredients);
        $ingredients = self::orderData($request, $ingredients);
        $ingredients = $ingredients->paginate(6);

        return response()->view('ingredients.index', [
            'ingredients' => $ingredients,
            'filter' => self::filterGenerate($request),
            'order' => self::orderGenerate($request)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        return response()->view('ingredients.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique(Ingredient::class, 'name')],
            'kkal' => ['required', 'decimal:0,2', 'min:0'],
            'price' => ['required', 'integer', 'min:1'],
        ]);

        $fields = [
            'name' => $request->post('name'),
            'kkal' => $request->post('kkal'),
            'price' => $request->post('price'),
        ];

        Ingredient::query()->create($fields);

        return Redirect::route('ingredients.create')->with('status', 'ingredient-created');
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id): Response
    {
        $ingredient = Ingredient::findOrFail($id);

        return response()->view('ingredients.show', [
            'ingredient' => $ingredient,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id): Response
    {
        $ingredient = Ingredient::findOrFail($id);

        return response()->view('ingredients.edit', [
            'ingredient' => $ingredient,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique(Ingredient::class, 'name')->ignore($id)],
            'kkal' => ['required', 'decimal:0,2', 'min:0'],
            'price' => ['required', 'integer', 'min:1'],
        ]);

        $fields = [
            'name' => $request->post('name'),
            'kkal' => $request->post('kkal'),
            'price' => $request->post('price'),
        ];

        Ingredient::findOrFail($id)->update($fields);

        return Redirect::route('ingredients.edit', $id)->with('status', 'ingredient-updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): RedirectResponse
    {
        $check = ProductIngredient::query()->where('ingredient_id', $id)->value('id');
        if (!empty($check)) {
            return redirect()->route('ingredients.index')->with('error', 'Нельзя удалить');
        }

        Ingredient::findOrFail($id)->delete();

        return redirect()->route('ingredients.index');
    }
}
