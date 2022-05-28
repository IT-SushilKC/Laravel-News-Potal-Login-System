<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Str;
use DB;
use Session;

class CategoryController extends Controller
{
    public function index(){
        Session::put('admin_page','category');
        $category = Category::latest()->get();
        return view('admin.category.index',['category'=>$category]);
    }
    public function categoryAdd(){
        Session::put('admin_page','category');
        $category = Category::where('parent_id',0)->get();
        return view('admin.category.add',['category'=>$category]);
    }

    public function categoryStore(Request $request){
        $request->validate([
            'category_name'=>'required',
            'parent_id'=>'required',
            'description'=>'required',
        ]);
        $category = new Category();
        $category->parent_id = $request->parent_id;
        $category->category_name = $request->category_name;
        $category->slug = Str::slug($request->category_name);
        $category->description = $request->description;
        if(!empty($request->status)){
            $category->status = 1;
        }else{
            $category->status=0;
        }
        $category->save();
        return redirect()->route('category.add')->with('success','Category has been Successfully Added');
    }

    public function Edit($id){
        $category = Category::findOrFail($id);
        $categories = Category::where('parent_id',0)->get();
        Session::put('admin_page','category');
        return view('admin.category.edit',['category'=>$category, 'categories'=>$categories]);
    }
    public function Update(Request $request, $id){
        $request->validate([
            'category_name'=>'required',
            'parent_id'=>'required',
            'description'=>'required',
        ]);
        $category = Category::find($id);
        $category->parent_id = $request->parent_id;
        $category->category_name = $request->category_name;
        $category->slug = Str::slug($request->category_name);
        $category->description = $request->description;
        if(!empty($request->status)){
            $category->status = 1;
        }else{
            $category->status=0;
        }
        $category->save();
        return redirect()->route('category.index')->with('success','Category has been Successfully Updated');
    }
    public function DeleteCategory($id){
        $category = Category::find($id);
        DB::table('categories')->where('parent_id', $id)->delete();
        $category->delete();
        return redirect()->route('category.index')->with('delete','Category has been Successfully Deleted');
    }
    
}
