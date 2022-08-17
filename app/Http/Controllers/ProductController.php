<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Image;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $limit = $request->query('page_size', 10);
        $products = Product::with(['categories', 'images'])->paginate($limit);
        return response()->json($products);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // request categories and images are string separated by comma
        $validated = $request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
            'enable' => 'required',
            'categories' => 'required|string',
            'images' => 'required|string',
        ]);

        $enable = $request['enable'] === 'true' ? true : false;
        $product = Product::create([
            'name' => $request['name'],
            'description' => $request['description'],
            'enable' => $enable
        ]);

        $categories = explode(",", $request['categories']);
        $category_ids = [];
        foreach ($categories as $key => $name) {
            $category = Category::firstOrCreate([
                'name' => $name,
                'enable' => true
            ]);

            $category_ids[] = $category->id;
        }
        // relate product with categories
        $product->categories()->sync($category_ids);

        // upload images
        $image_files = explode(",", $request['images']);
        $image_ids = [];

        foreach ($image_files as $file) {

            $image = Image::firstOrCreate([
                'file' => $file
            ], [
                'name' => $file,
                'enable' => true
            ]);

            $image_ids[] = $image->id;
        }

        // relate product with images
        $product->images()->sync($image_ids);

        return response()->json($product, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return response()->json($product->load(['images', 'categories']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
    }
}
