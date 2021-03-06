<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Brand;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Redirect;

class BrandController extends Controller
{
    public function AllBrand()
    {
        $brands = Brand::latest()->paginate(5);
        return view('admin.brand.index', compact('brands'));
    }
    public function StoreBrand(Request $request)
    {

        $validated = $request->validate([


            'brand_name' => 'required|unique:brands|min:4',
        ],
        [

            //custom error message
            'brand_name.required' => 'Please Input brand Name',


        ]
        );

        $brand_image = $request->file('brand_image');
        $name_gen = hexdec(uniqid());
        $img_ext = strtolower($brand_image->getClientOriginalExtension());
        $img_name = $name_gen . '.' . $img_ext;
        $up_location = 'image/brand/';
        $last_image = $up_location . $img_name;

        $brand_image->move($up_location, $img_name);

        Brand::insert([
            'brand_name' => $request->brand_name,
            'brand_image' => $last_image,
            'created_at' => Carbon::now()
        ]);

        return Redirect()->back()->with('success', 'Brand Inserted Successfully');
    }

    public function Edit($id)
    {
        $brands = Brand::find($id);
        return view('admin.brand.edit', compact("brands"));
    }


    public function Update(Request $request, $id)
    {

        $validated = $request->validate([


            'brand_name' => 'required|min:4',
        ],
        [

            //custom error message
            'brand_name.required' => 'Please Input brand Name',


        ]
        );

        $old_image = $request->old_image;
        $brand_image = $request->file('brand_image');
        $name_gen = hexdec(uniqid());
        $img_ext = strtolower($brand_image->getClientOriginalExtension());
        $img_name = $name_gen . '.' . $img_ext;
        $up_location = 'image/brand/';
        $last_image = $up_location . $img_name;

        $brand_image->move($up_location, $img_name);

        Brand::insert([
            'brand_name' => $request->brand_name,
            'brand_image' => $last_image,
            'created_at' => Carbon::now()
        ]);

        return Redirect()->back()->with('success', 'Brand Inserted Successfully');
    }
}
