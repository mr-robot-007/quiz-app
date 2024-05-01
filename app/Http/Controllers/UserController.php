<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{


    public function login(){
        return view('pages.login');
    }
    public function loginPost(Request $request) {
        $credentials  = $request->validate([
            'email'=> 'required',
            'password' => 'required',
        ]);
    
        // dd($credentials['email']);
    
        if(Auth::attempt($credentials )) {
            $user = User::where('email',$credentials['email'])->first();
            if($user->status === 'inactive' || $user->status ==='blocked'){
                return back()->withErrors([
                    'loginErr'=>"Can't login as you are blocked by administrator"
                ])->onlyInput('email','password');
            }
            $request->session()->regenerate();
            return redirect()->route('dashboard');
        }
    
        return back()->withErrors([
            'loginErr'=>'Incorrect email and password'
        ])->onlyInput('email','password');
    }

    public function logout(Request $request){
        if(!Auth::check()) {
            return redirect()->route('users.login');;
        }
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();;
        return redirect('/');
    
    }

    public function dashboard(){
        if(Auth::check()) {
            $current_user = Auth::user();
            return view('layouts.dashboard',['current_user'=>$current_user]);
        }
        else{
            return redirect()->route('users.login');;
        }
    }

    public function show(string $id): View
    {
        return view('user.profile', [
            'user' => User::findOrFail($id)
        ]);
    }

    public function index(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('users.login');
        }

        $current_user = Auth::user();

        $users = DB::table('users')
                    ->select('id', 'name', 'email', 'status', 'role')->whereNotIn('status', ['deleted'])
                    ->get();

        return view('users.list', [ 'current_user' => $current_user]);
    }

    
public function userData(Request $request)
{
    // Fetch users data
    // $users = User::all();
    $users = DB::table('users')
    ->select('id', 'name', 'email', 'status', 'role')->whereNotIn('status', ['deleted'])
    ->get();

    // dd($users);
    Log::info("ajax call made");
    

    // Return JSON response
    return response()->json(['data'=>$users]);
}

    public function register() {
        if(!Auth::check()) {
            return redirect()->route('users.login');;
        }
        $current_user = Auth::user();

        return view('users.form',['current_user'=>$current_user]);
    }

    public function store(Request $request) {
        if(!Auth::check()) {
            return redirect()->route('users.login');;
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email'=> 'required|unique:users,email',
            'password' => 'required',
            'confirm_password'=>'required|same:password'
        ]);
    
        // dd($validator);
    
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    
        $user = new User;
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = $request->input('password');
        $user->status = $request->input('status');
        $user->save();
    
        return redirect()->route('users.list');
    }


    public function edit(string $userId) {
        if(!Auth::check()) {
            return redirect()->route('users.login');;
        }
        $current_user = Auth::user();
        $user = User::findOrFail($userId);
        return view('users.form',['user'=>$user,'current_user'=>$current_user]);
    }
    public function update(string $userId, Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('users.login');
        }
    
        $user = User::findOrFail($userId);

        // dd($user);
    
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'status' => 'required|in:active,inactive,blocked,deleted',
        ]);
    
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->status = $request->input('status');
        $user->save();
    
        return redirect()->route('users.list');
    }
    

    public function destroy(string $userId) {
        if(!Auth::check()) {
            return redirect()->route('users.login');;
        }
        $user = User::find($userId); // Fetch the User model instance using the ID
        $user->status = 'deleted';
        $user->save();
        if ($user) {
            $user->delete();
        }
        return redirect()->route('users.list');
    }

    public function toggleblock(string $userId) {
        if(!Auth::check()) {
            return redirect() ->route('users.login');
        }
        $user = User::findOrFail($userId); // Fetch the User model instance using the ID
        // dd($user);
        if($user->status =='blocked') {
            $user->status = 'active';
        }
        else {
            $user->status='blocked';
        }
        $user->save();
        return redirect()->route('users.list');
    }

    public function editPassword() {
        if(!Auth::check()) {
            return redirect() ->route('users.login');
        }
        $current_user = Auth::user();
        return view('updatePasswordForm',['current_user'=>$current_user]);
    }

    public function updatePassword(Request $request) {
        if (!Auth::check()) {
            return redirect()->route('users.login');
        }
        
        $user = Auth::user();
        // dd($request->all());
        
        $validator = Validator::make($request->all(), [
            'current_password' => 'required',
            'new_password' => 'required',
            'confirm_new_password' => 'required|same:new_password',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        
        // Validate the current password
        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->back()->withErrors(['password' => 'The current password is incorrect.'])->withInput();
        }
        
        // Update the password
        $user->password = Hash::make($request->new_password);
        $user->save();
        
        return redirect()->route('password.edit')->with('success', 'Password updated successfully!');
    }
    

}

// $validator = Validator::make($request->all(), [
//     'current_password' => 'required',
//     'new_password' => 'required',
//     'confirm_new_password' => 'required|same:new_password',
// ]);
// $validator = Validator::make($request->all(), [
//     'current_password' => 'required',
//     'new_password' => 'required',
//     'confirm_new_password' => 'required|same:new_password',
// ]);
