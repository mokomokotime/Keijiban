<?php

namespace App\Http\Controllers\Auth\Login;

use App\Http\Controllers\Controller;
use app\Models\Users\User;
use Illuminate\Http\Request;
use Auth;

class LoginController extends Controller
{

    protected $redirectTo = '/top';

    /**
    * Create a new controller instance.
    *
    * @return void
    */
    public function __construct(){
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request){
        if($request->isMethod('post')){
            $data = $request->only('email','password');

        if(Auth::attempt($data)){
            return redirect()->route('user.index');
          }
      }

      return view("auth.login");
  }

  public function logout(){
      Auth::logout();
      return redirect('/login');
  }
}
