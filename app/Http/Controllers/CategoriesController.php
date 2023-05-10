<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoriesRequest;
use Illuminate\Http\Request;
use App\Models\Categories;

class CategoriesController extends Controller
{
    public function all(Request $request){
        if($request->has('activate')){
            $categories = Categories::where('activate', true)->get();
        }else{
            $categories = Categories::orderBy('id','asc')->get();
        }
        return response()->json($categories);
    }

    public function add(CategoriesRequest $request){

        $category = new Categories();
        $category->fill($request->all());
        $category->save();

        return response()->json($category, 201);

    }

    public function get($id){
        $category = Categories::find($id);
        return response()->json($category, 201);
    }

    public function patch(CategoriesRequest $request, $id){
        $category = Categories::find($id);
        $category->fill($request->all());
        $category->save();
        return response()->json($category, 201);

    }

    public function destroy($id){
        $category = Categories::findOrFail($id);
        $category->products()->each(function($product){
            $product->delete();
        });
        $category->delete();
    }
}
