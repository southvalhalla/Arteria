<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoriesRequest;
use Illuminate\Http\Request;
use App\Models\Categories;

class CategoriesController extends Controller
{
    public function store(CategoriesRequest $request){

        Categories::create([
            'category' => $request->category,
            'characteristics' => $request->characteristics,
        ]);

        return redirect()->route('newCategory')->with('success', 'Categoria creada correctamente.');
    }

    public function index(){
        $categories = Categories::orderBy('id','asc')->get();
        return view('categories.index', ['categories' => $categories]);
    }

    public function show($id){
        $category = Categories::find($id);
        return view('categories.detail', ['category' => $category]);
    }

    public function update(CategoriesRequest $request, $id){
        $category = Categories::find($id);

        $category->category = $request->category;
        $category->characteristics = $request->characteristics;
        $category->save();

        return redirect()->route('categories')->with('success', 'Categoria Actualizada.');
    }

    public function destroy($id){
        $category = Categories::findOrFail($id);
        $category->products()->each(function($product){
            $product->delete();
        });
        $category->delete();
        return redirect()->route('categories')->with('success', 'Categoria Eliminada.');
    }
}
