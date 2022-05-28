<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin;
use Session;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class AdminLoginController extends Controller
{
    //Login Functionality
    public function adminLogin(Request $request){
        if($request->isMethod('post')){
            $data = $request->all();
            $request->validate([
                'email'=>'required|email|max:255',
                'password'=>'required'
            ]);
            if(Auth::guard('admin')->attempt(['email'=>$data['email'],'password'=>$data['password']])){
                return redirect()->route('admindashboard');
            }else{
                return redirect()->route('adminlogin')->with('fail','Username and Password are Wrong');
            }
           
        }
    //Admin donot return login Page
    if(Auth::guard('admin')->check()){
        return redirect()->route('admindashboard');
    }else{
        return view('admin/login');
        }
    }
    //View Forget Password
    public function ForgetPassword(){
        return view('admin.forgetpassword');
    }
    //View Dashboard
    public function adminDashboard(){
        Session::put('admin_page','dashboard');
        return view('admin.dashboard');
    }
    //Admin Logout
    public function AdminLogout(){
        Auth::guard('admin')->logout();
        return redirect()->route('adminlogin');
    }
    //Admin Profile 
    public function AdminProfile(){
        $profile = Auth::guard('admin')->user();
        return view('admin.profile',['profile'=>$profile]);
    }

    //Admin Profile Update
    public function ProfileUpdate(Request $request,$id){
        $request->validate([
            'name'=>'required',
            'address'=>'required',
        ]);
        $profile = Auth::guard('admin')->user()->id;
        $profile=Admin::findOrFail($id);
        $profile->name=$request->name;
        $profile->address=$request->address;
        $profile->phone_number=$request->phone_number;
        $random = Str::random(10);
        if($request->hasFile('image')){
            $image_tmp=$request->file('image');
            if($image_tmp->isValid()){
                $extension=$image_tmp->getClientOriginalExtension();
                $filename = $random.'.'.$extension;
                $image_path='./uploads/'.$filename;
                Image::make($image_tmp)->save($image_path);
                $profile->image=$filename;
            }
        }
        $profile->save();
        Session::flash('success','Profile has been Updated Successfully');
        return redirect()->route('profile');
    }
    public function ChangePassword(){
        $admin = Admin::where('email', Auth::guard('admin')->user()->email)->first();
        return view('admin.changepassword');
    }
   

    // Check User Password
    public function checkUserPassword(Request  $request){
        $data = $request->all();
        $current_password = $data['current_password'];
        $user_id = Auth::guard('admin')->user()->id;
        $check_password = Admin::where('id', $user_id)->first();
        if(Hash::check($current_password, $check_password->password)){
            return "true"; die;
        } else {
            return "false"; die;
        }
    }


   
}








