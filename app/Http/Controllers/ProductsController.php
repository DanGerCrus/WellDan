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

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function welcome(Request $request): Response
    {
        $categories = ProductCategory::orderBy('name')->get();
        $products = Product::with('category')
            ->orderBy('name')
            ->orderBy('category_id')
            ->when($request->query('category_id'), function ($query) use ($request) {
                $query->where('category_id', '=', $request->query('category_id'));
            })
            ->get();

        return response()->view('welcome', [
            'products' => $products,
            'categories' => $categories,
        ]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        $products = Product::with('category')
            ->orderBy('name')
            ->orderBy('category_id')
            ->get();

        return response()->view('products.index', [
            'products' => $products
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        $categories = ProductCategory::select('id as value', 'name as label')->get();

        return response()->view('products.create', [
            'categories' => $categories
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
            'price' => ['required', 'integer'],
            'photo' => ['required', 'image'],
            'category_id' => ['required', 'integer', 'min:1', Rule::exists(ProductCategory::class, 'id')]
        ]);

        $fields = [
            'name' => $request->post('name'),
            'description' => $request->post('description'),
            'price' => $request->post('price'),
            'category_id' => $request->post('category_id'),
        ];

        $id = Product::query()->updateOrCreate(['id' => 0], $fields)->id;
        $this->savePhoto($id, $request->file('photo'));

        return Redirect::route('products.create')->with('status', 'product-created');
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id): Response
    {
        $product = Product::with('category')->find($id);

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
        $product = Product::with('category')->find($id);

        return response()->view('products.edit', [
            'product' => $product,
            'categories' => $categories
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'price' => ['required', 'integer'],
            'photo' => ['image', 'nullable'],
            'category_id' => ['required', 'integer', 'min:1', Rule::exists(ProductCategory::class, 'id')]
        ]);

        $fields = [
            'name' => $request->post('name'),
            'description' => $request->post('description'),
            'price' => $request->post('price'),
            'category_id' => $request->post('category_id'),
        ];

        Product::query()->updateOrCreate(['id' => $id], $fields);

        if ($request->hasFile('photo')) {
            $this->savePhoto($id, $request->file('photo'));
        }

        return Redirect::route('products.edit', $id)->with('status', 'product-updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): RedirectResponse
    {
        Product::find($id)->delete();

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
