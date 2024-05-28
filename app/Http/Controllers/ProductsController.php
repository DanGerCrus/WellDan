<?php

namespace App\Http\Controllers;

use App\Http\FilterTrait;
use App\Http\OrderTrait;
use App\Models\Ingredient;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductIngredient;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ProductsController extends Controller
{
    use OrderTrait;
    use FilterTrait;

    public static array $orderFields = [
        'name',
        'kkal',
        'category_id',
        'price'
    ];

    public static array $filterFields = [
        'name' => [
            'type' => '',
            'action' => 'like'
        ],
        'description' => [
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
        'max_kkal' => [
            'type' => '',
            'action' => '<='
        ],
        'min_kkal' => [
            'type' => '1',
            'action' => '>='
        ],
        'category_id' => [
            'type' => '0',
            'action' => '='
        ]
    ];

    /**
     * @param Request $request
     * @return array
     */
    public function datatable(Request $request): array
    {
        self::setDefaultOrder(['name' => 'asc', 'category_id' => 'asc']);
        $products = Product::with('category');
        $products = self::filterData($request, $products);
        $products = self::orderData($request, $products);

        return [
            'products' => $products->paginate(6),
            'products_order' => self::orderGenerate($request),
            'products_filter' => self::filterGenerate($request),
            'category_select' => ProductCategory::autocomplete()
        ];
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function index(Request $request): Response
    {
        return response()->view('products.index', $this->datatable($request));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        $categories = ProductCategory::select('id as value', 'name as label')->get();
        $ingredients = Ingredient::getForSelect();

        return response()->view('products.create', [
            'categories' => $categories,
            'ingredients' => $ingredients
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'price' => ['required', 'integer', 'min:1'],
            'kkal' => ['required', 'decimal:0,2', 'min:0'],
            'no_ingredients' => ['boolean',],
            'photo' => ['required', 'image'],
            'category_id' => ['required', 'integer', 'min:1', Rule::exists(ProductCategory::class, 'id')],
            'ingredients' => ['array'],
            'ingredients.*' => ['array'],
            'ingredients.*.id' => ['integer', Rule::exists(Ingredient::class, 'id')],
            'ingredients.*.count' => ['integer', 'min:1'],
        ]);

        $fields = [
            'name' => $request->post('name'),
            'description' => $request->post('description'),
            'price' => $request->post('price'),
            'kkal' => $request->post('kkal'),
            'no_ingredients' => $request->post('no_ingredients', 0),
            'category_id' => $request->post('category_id'),
        ];

        $id = Product::query()->updateOrCreate(['id' => 0], $fields)->id;
        $this->savePhoto($id, $request->file('photo'));

        if ($request->filled('ingredients')) {
            $ingredients = [];
            foreach ($request->post('ingredients') as $ingredient) {
                if (!in_array($ingredient['id'], $ingredients)) {
                    $productIngredientFields = [
                        'product_id' => $id,
                        'ingredient_id' => $ingredient['id'],
                        'count' => $ingredient['count'],
                    ];
                    ProductIngredient::query()->create($productIngredientFields);
                }
            }
        }

        return Redirect::route('products.create')->with('status', 'product-created');
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id): Response
    {
        $product = Product::with('category', 'ingredients.ingredient')->findOrFail($id);

        return response()->view('products.show', [
            'product' => $product
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id): Response
    {
        $categories = ProductCategory::select('id as value', 'name as label')->get();
        $ingredients = Ingredient::getForSelect();
        $product = Product::with('category', 'ingredients')->findOrFail($id);

        return response()->view('products.edit', [
            'product' => $product,
            'categories' => $categories,
            'ingredients' => $ingredients
        ]);
    }

    /**
     * @param Request $request
     * @param string $id
     * @return RedirectResponse
     */
    public function update(Request $request, string $id): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'price' => ['required', 'integer', 'min:1'],
            'kkal' => ['required', 'decimal:0,2', 'min:0'],
            'no_ingredients' => ['boolean',],
            'photo' => ['image', 'nullable'],
            'category_id' => ['required', 'integer', 'min:1', Rule::exists(ProductCategory::class, 'id')],
            'ingredients' => ['array'],
            'ingredients.*' => ['array'],
            'ingredients.*.id' => ['integer', Rule::exists(Ingredient::class, 'id')],
            'ingredients.*.count' => ['integer', 'min:1'],
        ]);

        $fields = [
            'name' => $request->post('name'),
            'description' => $request->post('description'),
            'price' => $request->post('price'),
            'kkal' => $request->post('kkal'),
            'no_ingredients' => $request->post('no_ingredients', 0),
            'category_id' => $request->post('category_id'),
        ];

        Product::query()->updateOrCreate(['id' => $id], $fields);

        if ($request->hasFile('photo')) {
            $this->savePhoto($id, $request->file('photo'));
        }
        ProductIngredient::query()->where('product_id', '=', $id)->delete();
        if ($request->filled('ingredients')) {
            $ingredients = [];
            foreach ($request->post('ingredients') as $ingredient) {
                if (!in_array($ingredient['id'], $ingredients)) {
                    $productIngredientFields = [
                        'product_id' => $id,
                        'ingredient_id' => $ingredient['id'],
                        'count' => $ingredient['count'],
                    ];
                    ProductIngredient::query()->create($productIngredientFields);
                }
            }
        }

        return Redirect::route('products.edit', $id)->with('status', 'product-updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): RedirectResponse
    {
        Product::findOrFail($id)->delete();

        return redirect()->route('products.index');
    }

    /**
     * @param int $productID
     * @param UploadedFile $file
     *
     * @return void
     */
    private function savePhoto(int $productID, UploadedFile $file): void
    {
        $path = "/products/{$productID}/";
        $fileName = "img.{$file->clientExtension()}";
        Storage::putFileAs('/upload/' . $path, $file, $fileName);
        Product::query()->updateOrCreate(['id' => $productID], [
            'photo' => '/upload/' . trim($path, '/') . '/' . trim($fileName, '/')
        ]);
    }
}
