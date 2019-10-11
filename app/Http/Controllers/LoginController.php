<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Model\User;

class LoginController extends Controller
{
	public function login()
	{
		return view('login');
	}

	public function do_login(Request $request)
	{
		$res=$request->all();
		$info=User::get();
		dd($info);
	}

	public function logout(Request $request)
	{
		return redirect('/');
	}
}
