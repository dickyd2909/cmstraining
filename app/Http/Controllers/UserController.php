<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    //
    public function login()
    {
        $data['title'] = 'Login Dashboard';
        return view('user/login', $data);
    }

    public function login_action(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);
        if (Auth::attempt(['username' => $request->username, 'password' => $request->password])) {
            $request->session()->regenerate();
            return redirect()->intended('dashboard');
        }

        return back()->withErrors([
            'password' => 'Wrong username or password',
        ]);
    }

    public function register()
    {
        $data['title'] = 'Register Page';
        return view('user/register', $data);
    }

    public function register_action(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'username' => 'required|unique:tb_user',
            'password' => 'required',
            'password_confirm' => 'required|same:password',
        ]);

        $user = new User([
            'name' => $request->name,
            'username' => $request->username,
            'password' => Hash::make($request->password),
        ]);
        $user->save();

        return redirect()->route('login')->with('success', 'Registration success. Please login!');
    }

    public function dashboard()
    {
        
        $data['title'] = 'Dashboard';
        return view('dashboard/dashboard', $data);
    }

    public function admin(Request $request)
    {
        
        $data['title'] = 'Admin';
        $data['admin'] = User::all();
        return view('admin/admin', $data);
        
    }

    public function admin_save(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'username' => 'required|unique:tb_user',
            'password' => 'required',
            'password_confirm' => 'required|same:password',
        ]);

        $user = new User([
            'name' => $request->name,
            'username' => $request->username,
            'password' => Hash::make($request->password),
        ]);
        $user->save();

        return redirect()->route('admin')->with('success', 'Tambah data admin berhasil!');
    }

    public function admin_update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'username' => 'required',
        ]);
      
        $u = User::findOrFail($id);
        $u->name = $request->name;
        $u->username = $request->username;
        $u->save();
      
        return redirect()->route('admin')->with('success','User Berhasil Diubah');
    }

    public function admin_hapus($id)
    {
        $user = User::find($id);
        $user->delete();
        return redirect()->route('admin')->with('success','User Berhasil Dihapus');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
