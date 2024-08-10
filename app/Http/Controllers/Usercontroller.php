<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Hash;


class Usercontroller extends Controller
{
    public function userregister()
    {
        $categories = Category::orderBy('priority')->get();
        return view('userregister',compact('categories'));

    }

    public function userstore(Request $request)
    {
        $data = $request->validate([
            'name'=> 'required',
            'phone'=> 'required',
            'email'=> 'required',
            'address'=> 'required',
            'password'=> ['required','confirmed',Rules\Password::defaults()],
            'photopath' => 'required|image|mimes:jpeg,png,jpg'
            
        ]);
        if($request->hasFile('photopath')){
            $image =$request->file('photopath');
            $name = time().'.'.$image->getClientOriginalExtension();
            $destinationPath = public_path('/images/user');
            $image->move($destinationPath,$name);
            $data['photopath'] = $name;

        }

        

        $data['password'] = Hash::make($data['password']);
        $data['role'] = 'user';

        User::create($data);
        return redirect(route('Home'));

    }

    


}
