<?php

namespace App\Http\Controllers\Auth\Register;

use App\Models\Users\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\DB;

class RegisterController extends Controller
{
    /**
      * Create a new user instance after a valid registration.
      *
      * @param  array  $data
      * @return \App\User
      */
      protected function create(array $data){
          return User::create([
              'username' => $data['username'],
              'email' => $data['email'],
              'password' => bcrypt($data['password']),
          ]);
      }

      public function register(Request $request){
          if($request->isMethod('post')){
              $data = $request->input();
              $validator = Validator::make($data,[
                'username' => 'required|max:30',
                'email' => 'required|max:100|email:rfc,dns|unique:users,email',
                'password' => 'required|min:8|max:30|confirmed',
                'password_confirmation' => 'required|min:8|max:30',
              ]);

              if($validator->fails()){
                return redirect('/register')
                ->withErrors($validator)
                ->withInput();

              } else {
                $this->create($data);
                return redirect('added');
              }
            }
            return view('auth.register');
      }

      public function added(){
          return view('auth.added');
      }
}
