<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Category\AddCategoryRequest;
use App\Http\Requests\Admin\Category\UpadateCategoryRequest;
use App\Http\Requests\Admin\Category\UpadteCategoryRequest;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $categories=Category::orderBy('created_at', 'desc')->get();;


        return View('dashbord.categories.index',compact('categories'));
    }


    public function create()
    {
        return view('dashbord.categories.create');
    }

    public function store(AddCategoryRequest $request)
    {



    $data = $request->validated();


      Category::create($data);


        return redirect()->route('categories.index')->with('success', 'تم إضافة البيانات بنجاح');

    }




    public function edit(Category $category)
    {

        return view('dashbord.categories.edit',compact('category'));


    }


    public function update(UpadateCategoryRequest $request, Category $category)
    {
            $data = $request->validated();

           $category->update($data);

            return Redirect()->route('categories.index')->with('warning', 'تم تعديل البيانات بنجاح');

    }

 
    public function destroy(Category $category)
    {

        $category->delete();
        return back()->with('error','تم حذف البايانات بنجاح');
    }
}
