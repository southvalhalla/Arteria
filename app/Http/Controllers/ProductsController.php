<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductsRequest;
use Illuminate\Http\Request;
use App\Models\Categories;
use App\Models\Products;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Products::orderBy('id','desc')->get();
        $categories = Categories::orderBy('category','asc')->get();
        return view('products.index', ['products' => $products,'categories' => $categories]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductsRequest $request)
    {
        Products::create([
            'cod'           => 'P'.rand(4000,6000),
            'name'          => $request->name,
            'trademark'     => $request->trademark,
            'in_inventary'  => $request->in_inventary,
            'category_id'   => $request->category,
            'description'   => $request->description,
            'price'         => $request->price,
        ]);

        return redirect()->route('products.index')->with('success', 'Producto creado correctamente.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Products::find($id);
        $categories = Categories::orderBy('category','asc')->get();
        return view('products.detail', ['product' => $product, 'categories' => $categories]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProductsRequest $request, $id)
    {
        $product = Products::find($id);

        $product->name          = $request->name;
        $product->trademark     = $request->trademark;
        $product->in_inventary  = $request->in_inventary;
        $product->category_id   = $request->category;
        $product->description   = $request->description;
        $product->price         = $request->price;
        $product->save();

        return redirect()->route('products.index')->with('success', 'Producto Actualizado.');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Products::find($id);
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Producto Eliminado.');
    }
}
