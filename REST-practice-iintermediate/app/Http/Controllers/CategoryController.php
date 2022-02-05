<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends ApiController
{
    public function index()
    {
        $categories = Category::all();
        return $this->showAllResponse($categories);
    }

    public function show($id)
    {
        $category = Category::findOrFail($id);
        return $this->showSingleResponse($category);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:2|max:250',
            'description' => 'nullable|max:500',
        ]);

        $category = new Category();
        $category->name = $request->name;
        $category->description = $request->desciption;
        $category->save();

        return $this->showSingleResponse($category, 201);
    }

    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $request->validate([
            'name' => 'min:2|max:250',
            'description' => 'nullable|max:500',
        ]);

        $category->fill($request->only([
            'name',
            'description',
        ]));

        if($category->isClean()){
            return $this->errorResponse('No change', 422);
        }

        $category->save();

        return $this->showSingleResponse($category);
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();
        return $this->showSingleResponse($category);
    }
}
