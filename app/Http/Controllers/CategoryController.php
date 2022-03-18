<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
class CategoryController extends Controller
{
    //
    public function AllCat()
    {



        //method 1 to get data without join table
        $categories = Category::latest()->paginate(5);

        //method 2 to get data without join table
        // $categories = DB::table('categories')->latest()->paginate(5);

        //method 3 to get data with join table

        // $categories = DB::table('categories')->join('users', 'categories.user_id', 'users.id')
        //     ->select('categories.*', 'users.name')->latest()->paginate(5);

        //trash list
        $trashCat = Category::onlyTrashed()->latest()->paginate(3);
        //user comact to read data
        return view('admin.category.index', compact('categories', 'trashCat'));
    }
    public function AddCat(Request $request)
    {
        $validated = $request->validate([

            //category_name form name of form
            //categories from table categories
            'category_name' => 'required|unique:categories|max:255',
        ],
        [

            //custom error message
            'category_name.required' => 'Please Input Category Name',


        ]

        );
        //method 1

        Category::insert([
            'category_name' => $request->category_name,
            'user_id' => Auth::user()->id,
            'created_at' => Carbon::now()

        ]);


        //method 2
        // $category = new Category;
        // $category->category_name = $request->category_name;
        // $category->user_id = Auth::user()->id;
        // $category->save();

        //method 3 insert data using query
        // $data = array();
        // $data['category_name'] = $request->category_name;
        // $data['user_id'] = Auth::user()->id;
        // DB::table('categories')->insert($data);

        return Redirect()->back()->with('success', 'Category Inserted Successfull');
    }
    public function Edit($id)
    {
        //method 1
        // $categories = Category::find($id);

        //method 2
        $categories = DB::table('categories')->where('id', $id)->first();

        return view('admin.category.edit', compact('categories'));

    }

    public function Update(Request $request, $id)
    {

        //method 1
        // $update = Category::find($id)->update([
        //     'category_name' => $request->category_name,
        //     'user_id' => Auth::user()->id

        // ]);

        //method 2
        $data = array();
        $data['category_name'] = $request->category_name;
        $data['user_id'] = Auth::user()->id;
        DB::table('categories')->where('id', $id)->update($data);
        return Redirect()->route('all.category')->with('success', 'Category Updated Successfull');

    }

    public function SoftDelete($id)
    {
        $delete = Category::find($id)->delete();
        return Redirect()->back()->with('success', 'Category Soft Delete Successfully');
    }
    public function Restore($id)
    {
        $delete = Category::withTrashed()->find($id)->restore();
        return Redirect()->back()->with('success', 'Category Restore Successfully');

    }

    public function Pdelete($id)
    {
        $delete = Category::onlyTrashed()->find($id)->forceDelete();
        return Redirect()->back()->with('success', 'Category Permanently Deleted');

    }
}
