<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;

class SliderController extends Controller
{


    public function index(){

        $sliders=Slider::all();

        return view('dashbord.sliders.index' ,compact('sliders'));

    }


    public function create(){

        return view('dashbord.sliders.create');

    }




public function store(Request $request)
{
    $data = $request->validate([
        'big_title'   => 'required|string|max:255',
        'small_title' => 'nullable|string|max:255',

        'image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
    ]
    );

    if ($request->hasFile('image')) {
        $image = $request->file('image');
        $imageName = time() . '_' . $image->getClientOriginalName();
        $image->move(public_path('images/sliders'), $imageName);
        $data['image'] = $imageName;
    }

   Slider::create($data);

    return redirect()->route('sliders.index')->with('success', 'تمت الإضافة بنجاح');
}




    public function destroy(Slider $slider)
    {

    $imagePath = public_path('images/sliders/' . $slider->image);

if ($slider->image && file_exists($imagePath)) {
    unlink($imagePath);
}
        $slider->delete();

        return back()->with('error','تم حذف  بناجح');
    }



}
