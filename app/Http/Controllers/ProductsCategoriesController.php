<?php

namespace App\Http\Controllers;

use App\Http\FilterTrait;
use App\Http\OrderTrait;
use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Redirect;

class ProductsCategoriesController extends Controller
{
    use OrderTrait;
    use FilterTrait;

    public static array $orderFields = [
        'name',
    ];

    public static array $filterFields = [
        'name' => [
            'type' => '',
            'action' => 'like'
        ],
    ];

    public function __construct()
    {
        $this->middleware('permission:category-list|category-create|category-edit|category-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:category-edit', ['only' => ['create', 'store', 'edit', 'update']]);
        $this->middleware('permission:category-delete', ['only' => ['destroy']]);
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function index(Request $request): Response
    {
        $categories = ProductCategory::query();
        $categories = self::filterData($request, $categories);
        $categories = self::orderData($request, $categories);
        $categories = $categories->paginate(6);

        return response()->view('products_categories.index', [
            'categories' => $categories,
            'filter' => self::filterGenerate($request),
            'order' => self::orderGenerate($request)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        return response()->view('products_categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);

        $fields = [
            'name' => $request->post('name'),
        ];

        ProductCategory::query()->create($fields);

        return Redirect::route('categories.create')->with('status', 'products_category-created');
    }

    /**
     * @param int $id - идентификатор хуя
     * @return Response
     */
    public function show(int $id): Response
    {
        $category = ProductCategory::find($id);

        return response()->view('products_categories.show', [
            'category' => $category
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id): Response
    {
        $category = ProductCategory::find($id);

        return response()->view('products_categories.edit', [
            'category' => $category
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);

        $fields = [
            'name' => $request->post('name'),
        ];

        ProductCategory::find($id)->update($fields);

        return Redirect::route('categories.edit', $id)->with('status', 'products_category-updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): RedirectResponse
    {
        Product::where('category_id', '=', $id)->delete();
        ProductCategory::find($id)->delete();

        return redirect()->route('categories.index');
    }
}
