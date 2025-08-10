<?php

namespace App\Http\Controllers\Admin;

use App\Models\Slider;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Slider\CreateSliderRequest;
use App\Http\Requests\Admin\Slider\UpdateSliderRequest;

class SliderController extends Controller
{
    public function index()
    {
        return view('admin.sliders.index');
    }

    public function create()
    {
        return view('admin.sliders.create');
    }

    public function store(CreateSliderRequest $request)
    {
        $image = $request->file('image');
        $imageName = time() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('sliders'), $imageName);

        Slider::create([
            'image' => $imageName,
            'link' => $request->link,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.sliders.index')->with('success', 'اسلایدر با موفقیت ثبت شد');
    }

    public function edit($id)
    {
        $slider = Slider::find($id);
        if(!$slider)
            return redirect()->route('admin.sliders.index')->with('error', 'اسلایدر یافت نشد');
        return view('admin.sliders.edit', compact('slider'));
    }

    public function update(UpdateSliderRequest $request, $id)
    {
        $slider = Slider::find($id);
        if(!$slider)
            return redirect()->route('admin.sliders.index')->with('error', 'اسلایدر یافت نشد');

            $imageName = $slider->image;
            if($request->hasFile('image')){
                $image = $request->file('image');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('sliders'), $imageName);
            }

        $slider->update([
            'image' => $imageName,
            'link' => $request->link,
            'status' => $request->status,
        ]);
        return redirect()->route('admin.sliders.index')->with('success', 'اسلایدر با موفقیت ویرایش شد');
    }

}
