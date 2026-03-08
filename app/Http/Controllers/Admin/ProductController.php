<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Product\AddProductRequest;
use App\Http\Requests\Admin\Product\UpdateProductRequest;

class ProductController extends Controller
{

public function index()
{
    $products = Product::orderBy('created_at', 'desc')->get();

    return view('dashbord.products.index', compact('products'));
}


    public function create()
    {

  {

        $categories = Category::all();
        return view('dashbord.products.create',compact('categories'));


    }

    }
    public function store(AddProductRequest $request)

    {
        $data=$request->validated();
if ($request->hasFile('image')) {

    $image = $request->file('image');

    $imageName = time() . '_' . $image->getClientOriginalName();

    $image->move(public_path('images'), $imageName);

    $data['image'] = $imageName;
}

else {
   
    $data['image'] = 'default.jpg';
}


        Product::create($data);

        return redirect()->route('products.index')->with('success','تم اضافة المنتج بنجاح');

    }




    public function edit(Product $product)
    {
       $categories = Category::all();

        return view('dashbord.products.edit',compact('categories','product'));
    }

    public function update( UpdateProductRequest $request, Product $product)
    {

             $data=$request->validated();

    if ($request->hasFile('image')) {
        $image = $request->file('image');
        $imageName = time() . '_' . $image->getClientOriginalName();
        $image->move(public_path('images'), $imageName);

        $data['image'] = $imageName;
    }
    $product->update($data);

    return redirect()->route('products.index')->with('update',('تم تعديل المنتج بنجاح'));


    }


    public function destroy(Product $product)
    {

        if ($product->orderItems()->exists()) {
        $product->orderItems()->delete();
    }
           if ($product->image && file_exists(public_path('images/' . $product->image))) {
        unlink(public_path('images/' . $product->image));
    }
        $product->delete();

        return back()->with('error','تم حذف المنتج بناجح');
    }
}
