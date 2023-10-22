<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ProductsCategoriesController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:category-list|category-create|category-edit|category-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:category-edit', ['only' => ['create', 'store', 'edit', 'update']]);
        $this->middleware('permission:category-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        $categories = ProductCategory::orderBy('name')
            ->get();

        return response()->view('products_categories.index', [
            'categories' => $categories
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
     * Display the specified resource.
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

        return redirect()->route('products_categories.index');
    }
}
