<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Order;

class AuthController extends Controller
{
    // Show Sign up Page
    public function signupPage(){
        return view('auth.sign-up');
    }

    // Show Sign in Page
    public function signinPage(){
        return view('auth.sign-in');
    }

    

    // User Validation Rules
    private function userValidationRules()
    {
        $rules = [
            'first_name' => [
                'required',
                'string',
                'max:50',
                'regex:/^[A-Za-z\s\-]+$/', // Only letters, spaces, hyphens
            ],
            'last_name' => [
                'required',
                'string',
                'max:50',
                'regex:/^[A-Za-z\s\-]+$/',
            ],
            'email' => [
                'required',
                'string',
                'email:rfc,dns', // Stricter email validation, checks DNS records
                'max:255',
                'unique:users,email',
            ],
            'phone' => [
                'nullable',
                'string',
                'regex:/^\+?[0-9]{11,13}$/', // Only numbers, optional +
            ],
            'password' => [
                'required',
                'string',
                'min:8',
                'max:64', // Prevent crazy long passwords
                'confirmed',
            ],
            'role' => [
                'required',
                'in:user,admin',
            ],
            'gender' => [
                'required',
                'in:male,female,prefer_not_to_say',
            ],
            'date_of_birth' => [
                'required',
                'date',
                'before:today', // Optional: ensures DOB is in the past
            ],
        ];

        return $rules;
    }


    
    // Sign Up
    public function signup(Request $request)
    {
        $rules = $this->userValidationRules();

        // Optional: custom messages
        $messages = [
            'password.confirmed' => 'Passwords do not match.',
            'password.min' => 'Password must be at least :min characters.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $validated = $validator->validated();

        $validated['password'] = Hash::make($validated['password']);

        $user = User::create($validated);

        Auth::login($user);

        return redirect()->route('customer.home')->with('success', 'Registration successful! Welcome, ' . $user->first_name . '!');
    }

    // Sign in
    public function signin(Request $request)
    {
        // Validate the login credentials
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:8',
        ]);

        if (Auth::attempt($validated)) {
            // Regenerate session
            $request->session()->regenerate();
        
            // Create success message
            $successMessage = 'Sign-in successful, welcome back ' . Auth::user()->first_name . '!';
            Log::info('User Success Message: ' . $successMessage);
        
            // Redirect to client area
            return redirect()->intended(route('customer.home'))->with('success', $successMessage);
        } 
        else {
            // Authentication failed
            return back()->withErrors([
                'email' => 'The provided credentials do not match our records.',
            ])->onlyInput('email');
        }
    }

    // Log out
    public function logout(Request $request){
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('customer.home')->with('success', 'You have successfully logged out!');
    } 

    public function redirectToSignin(){
        return view('auth.sign-in');
    }

    // Show user profile page 
    // Customer/UserProfileController.php

    public function showUserProfile()
    {
        $user = Auth::user();

        // Eager load orders with items and products
        $orders = Order::with(['items.product', 'statusHistory'])
                    ->where('user_id', $user->id)
                    ->orderBy('created_at', 'desc')
                    ->get();

        return view('customer.user-profile', compact('user', 'orders'));
    }



    public function showEditProfilePage(){
        // Get the currently logged-in user
        $user = Auth::user();

        // Return the view with the user's data
        return view('customer.edit-profile', compact('user'));
    }

    public function updateProfile(Request $request){
        $user = Auth::user();

        // Validation
        $rules = [
            'first_name' => 'required|string|max:50|regex:/^[A-Za-z\s\-]+$/',
            'last_name' => 'required|string|max:50|regex:/^[A-Za-z\s\-]+$/',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|regex:/^\+?[0-9]{11,13}$/',
            'gender' => 'required|in:male,female,other',
            'date_of_birth' => 'required|date|before:today',
            'profile_photo' => 'nullable|image|max:2048', // optional photo, max 2MB
        ];

        $validated = $request->validate($rules);

        // Update profile photo if uploaded
        if ($request->hasFile('profile_photo')) {
            $file = $request->file('profile_photo');

            // Delete old photo if exists
            if ($user->profile_picture_path && file_exists(public_path($user->profile_picture_path))) {
                unlink(public_path($user->profile_picture_path));
            }

            // Generate unique file name
            $fileName = time() . '_' . $file->getClientOriginalName();

            // Move file to public/images/user-profile-pictures
            $file->move(public_path('images/user-profile-pictures'), $fileName);

            // Save relative path in DB
            $validated['profile_picture_path'] = 'images/user-profile-pictures/' . $fileName;
        }

        // Update user
        $user->update($validated);

        return redirect()->route('auth.user-profile')->with('success', 'Profile updated successfully!');
    }






    


}
