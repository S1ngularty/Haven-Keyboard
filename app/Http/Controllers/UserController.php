<?php

namespace App\Http\Controllers;
use App\Models\user;
use Illuminate\Http\Request;
use App\DataTables\userDataTable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(userDataTable $user_data_table)
    {
        return $user_data_table->render("admin.users.index");
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */  
    public function viewProfile()
    {
        $account = Auth::user(); // returns logged in Account model
        $user = $account->user;  // uses the hasOne() relationship
    
        return view('customer.profile.view', compact('user'));
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(user $user)
    {
        $account = Auth::user();
        $user = $account->user;
    
        return view('customer.profile.edit', compact('user', 'account'));    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $account = Auth::user();         // Logged-in account
        $user = $account->user;          // Related user
    
        $request->validate([
            'username' => 'required|string|max:255|unique:accounts,username,' . $account->account_id . ',account_id',
            'email' => 'required|email|max:255|unique:accounts,email,' . $account->account_id . ',account_id',
            'fname' => 'required|string|max:255',
            'lname' => 'required|string|max:255',
            'age' => 'required|integer|min:1',
            'gender' => 'required|in:male,female',
            'contact' => 'required|string|max:255|unique:users,contact,' . $user->user_id . ',user_id',
            'address' => 'required|string|max:255',
            'img' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'password' => 'nullable|min:8|confirmed',
        ]);
    
        // Update account fields
        $account->username = $request->username;
        $account->email = $request->email;
    
        // Update user fields
        $user->fname = $request->fname;
        $user->lname = $request->lname;
        $user->age = $request->age;
        $user->gender = $request->gender;
        $user->contact = $request->contact;
        $user->address = $request->address;
    
        // Handle image upload
        if ($request->hasFile('img')) {
            $file = $request->file('img');
            $filename = $file->hashName();
            $path = $file->storeAs('user_img', $filename, 'public');
    
            if ($path) {
                $user->img = $filename;
            } else {
                return redirect()->back()->with('error', 'Image upload failed.');
            }
        }
    
        // Update password if provided
        if ($request->filled('password')) {
            $account->password = Hash::make($request->password);
        }
    
        // Save changes
        $account->save();
        $user->save();
    

        
        return redirect()->route('profile.view')->with('success', 'Profile updated successfully!');
    }
    
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(user $user)
    {
        //
    }
}
