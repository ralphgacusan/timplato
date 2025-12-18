<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;
use App\Models\AdminLog;
use App\Models\User;
use App\Models\Order;
use App\Models\Cart;
use App\Models\Notification;


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


    // OAuth Functions

    // Redirect user to Google
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    // Handle Google callback
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->stateless()->user();

            // Find existing user or create new
            $user = User::firstOrCreate(
                ['email' => $googleUser->getEmail()],
                [
                    'first_name' => $googleUser->user['given_name'] ?? $googleUser->getName(),
                    'middle_name'   => $googleUser->user['middle_name'] ?? null,
                    'last_name'  => $googleUser->user['family_name'] ?? '',
                    'password'   => Hash::make(uniqid()),
                    'role'       => 'user',
                    'gender'     => null,
                    'date_of_birth' => null,
                    'phone'      => null,
                ]
            );

            //  Suspension Check (same as manual login)
            if ($user->suspended_until) {
                $now = now();

                if ($now->lessThan($user->suspended_until)) {
                    // Still suspended
                    return redirect()->route('login')->withErrors([
                        'email' => 'Your account is suspended until ' . $user->suspended_until->format('F d, Y') . '.',
                    ]);
                } else {
                    // Suspension expired — clear it
                    $user->update(['suspended_until' => null]);
                }
            }

            // Log the user in
            Auth::login($user);

            // Redirect based on role (same as signin logic)
            if ($user->role === 'admin') {
                return redirect()->route('admin.product-management')
                    ->with('success', 'Welcome Admin ' . $user->first_name . '!');
            }

            // Decide message based on sign in vs sign up
            $message = $user->wasRecentlyCreated
                ? 'Registration successful! Welcome, ' . $user->first_name . '!'
                : 'Welcome back ' . $user->first_name . '!';
            
            return redirect()->route('customer.home')->with('success', $message);

        } catch (\Exception $e) {
            return redirect()->route('login')
                ->withErrors(['oauth' => 'Something went wrong, please try again.']);
        }
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
            'middle_name' => [
                'nullable',
                'max:50',
                'regex:/^[A-Za-z\s\-]+$/',
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
                'nullable',
                'in:male,female,prefer_not_to_say',
            ],
            'date_of_birth' => [
                'nullable',
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

        // Attempt login
        if (Auth::attempt(['email' => $validated['email'], 'password' => $validated['password']])) {

            // Regenerate session to prevent fixation
            $request->session()->regenerate();

            // Get the authenticated user
            $user = Auth::user();

            // Check for suspension
        if ($user->suspended_until) {
            $now = now();

            if ($now->lessThan($user->suspended_until)) {
                // User is still suspended
                if (Auth::check()) {
                    Auth::user()->update(['last_logout_at' => now()]);
                }

                Auth::logout();

                return back()->withErrors([
                    'email' => 'Your account is suspended until ' . \Carbon\Carbon::parse($user->suspended_until)->format('F d, Y') . '.',
                ])->onlyInput('email');
            } else {
                // Suspension expired — automatically clear it
                $user->update(['suspended_until' => null]);
            }
        }

            // Update last login
            $user->update(['last_login_at' => now()]);

        // Log admin login action
        if ($user->role === 'admin') {
            $this->logAdminAction('login', 'Admin', $user->id, 'Admin logged in');
        }

            // Check if the user is admin
            if ($user->role === 'admin') {
                return redirect()->route('admin.dashboard')->with('success', 'Welcome Admin ' . $user->first_name . '!');
            } else {
                // Merge guest cart for regular users
                $oldSessionId = $request->session()->getId();
                $this->mergeGuestCart($oldSessionId);

                return redirect()->intended(route('customer.home'))
                    ->with('success', 'Welcome back ' . $user->first_name . '!');
            }
        }

        // Authentication failed
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }


    // Log out
    public function logout(Request $request)
    {
        if (Auth::check()) {
            $user = Auth::user();
            $user->last_logout_at = now();
            $user->save();

            // Log admin logout action
            if ($user->role === 'admin') {
                $this->logAdminAction('logout', 'Admin', $user->id, 'Admin logged out');
            }
        }

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

    // Load all orders once with items and product images
    $orders = Order::with(['items.product.primaryImage'])
        ->where('user_id', $user->id)
        ->orderBy('created_at', 'desc')
        ->get();

    // Group orders by status
    $groupedOrders = [
        'all' => $orders,
        'to-pay' => $orders->filter(fn($o) => $o->current_status === 'pending')->values(),
        'to-ship' => $orders->filter(fn($o) => in_array($o->current_status, ['confirmed', 'processing']))->values(),
        'to-receive' => $orders->filter(fn($o) => $o->current_status === 'shipped')->values(),
        'completed' => $orders->filter(fn($o) => $o->current_status === 'delivered')->values(),
        'cancelled' => $orders->filter(fn($o) => $o->current_status === 'cancelled')->values(),
        'return-refund' => $orders->filter(fn($o) => in_array($o->current_status, ['returned', 'return_requested','return_approved', 'refunded', 'refund_requested', 'refund_approved']))->values(),
    ];

    // Fetch both user-specific and general notifications
    $notifications = Notification::with(['order.items.product.primaryImage', 'product'])
        ->where('user_id', $user->id)
        ->orWhereNull('user_id') // include general notifications
        ->orderBy('created_at', 'desc')
        ->get();

    return view('customer.user-profile', compact('user', 'groupedOrders', 'notifications'));
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
            'middle_name' => 'nullable|string|max:50|regex:/^[A-Za-z\s\-]+$/',
            'last_name' => 'required|string|max:50|regex:/^[A-Za-z\s\-]+$/',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|regex:/^\+?[0-9]{11,13}$/',
            'gender' => 'nullable|in:male,female,other',
            'date_of_birth' => 'nullable|date|before:today',
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
        // dd($validated);
    }




    private function mergeGuestCart($oldSessionId)
    {
        $guestCart = Cart::where('session_id', $oldSessionId)->first();
        $userCart = Cart::firstOrCreate(['user_id' => Auth::id()]);

        if ($guestCart) {
            foreach ($guestCart->items as $item) {
                $existing = $userCart->items()
                    ->where('product_id', $item->product_id)
                    ->first();

                if ($existing) {
                    $existing->quantity += $item->quantity;
                    $existing->save();
                } else {
                    $item->cart_id = $userCart->cart_id;
                    $item->save();
                }
            }
            $guestCart->delete();
        }
    }


    // ADMIN SIDE
   public function showUserManagement(Request $request)
    {
        $query = User::query();

        // Search
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                ->orWhere('last_name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%")
                ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        // Role filter
        if ($request->filled('role')) {
            $query->where('role', $request->input('role'));
        }

        // Sorting
        switch ($request->input('sort')) {
            case 'az':
                $query->orderByRaw("CONCAT(first_name, ' ', last_name) ASC");
                break;
            case 'za':
                $query->orderByRaw("CONCAT(first_name, ' ', last_name) DESC");
                break;
            case 'newest':
                $query->orderBy('created_at', 'desc');
                break;
            case 'oldest':
                $query->orderBy('created_at', 'asc');
                break;
            case 'last-login':
                $query->orderBy('last_login_at', 'desc');
                break;
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }

        // Pagination
        $users = $query->paginate(30)->appends($request->query());

        return view('admin.user-management', compact('users'));
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        $this->logAdminAction('delete', 'User', $user->id, 'Deleted user account');

        return redirect()->route('admin.user-management')->with('success', 'User deleted successfully.');
    }

    public function suspend($id)
    {
        $user = User::findOrFail($id);

        // Suspend for 30 days from now
        $user->suspended_until = now()->addDays(30);
        $user->save();

            $this->logAdminAction('suspend', 'User', $user->id, 'Suspended user account for 30 days');
        return redirect()->route('admin.user-management')->with('success', 'User suspended for 30 days.');
    }

    public function unsuspend($id)
    {
        $user = User::findOrFail($id);

        // Remove suspension
        $user->suspended_until = null;
        $user->save();
         $this->logAdminAction('unsuspend', 'User', $user->id, 'Unsuspended user account');
        return redirect()->route('admin.user-management')->with('success', 'User has been unsuspended successfully.');
    }

    

    // Show specific user profile for admin
    public function userAccountViewPage($id)
    {
        $user = User::with('addresses')->findOrFail($id); // Load user and their addresses
        return view('admin.user-account-view', compact('user'));
    }


    public function userAccountViewEditInformationPage(User $user){
        return view('admin.user-account-edit-information', compact('user'));
    }

    // Update User Account (Admin)
public function updateUserAccountInformation(Request $request, $userId)
{
    // Find the user or fail
    $user = User::findOrFail($userId);

       // Validation
        $rules = [
            'first_name' => 'required|string|max:50|regex:/^[A-Za-z\s\-]+$/',
            'middle_name' => 'nullable|string|max:50|regex:/^[A-Za-z\s\-]+$/',
            'last_name' => 'required|string|max:50|regex:/^[A-Za-z\s\-]+$/',
            'role' => 'required|in:user,admin',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|regex:/^\+?[0-9]{11,13}$/',
            'gender' => 'nullable|in:male,female,other',
            'date_of_birth' => 'nullable|date|before:today',
            'profile_photo' => 'nullable|image|max:2048', // optional photo, max 2MB
        ];

    $validated = $request->validate($rules);

    // Handle profile photo upload
    if ($request->hasFile('profile_photo')) {
        $file = $request->file('profile_photo');

        // Delete old profile photo if it exists
        if ($user->profile_picture_path && file_exists(public_path($user->profile_picture_path))) {
            unlink(public_path($user->profile_picture_path));
        }

        // Save new photo
        $fileName = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('images/user-profile-pictures'), $fileName);
        $validated['profile_picture_path'] = 'images/user-profile-pictures/' . $fileName;
    }

    // Update user data
    $user->update($validated);

    // // Debug check
    // dd($validated);
    
    $this->logAdminAction('update', 'User', $user->id, 'Updated user account information');
    // Or redirect back (after testing)
    return redirect()->route('admin.user-account-view', $user->id)
        ->with('success', 'User account updated successfully!');
}


    public function userAccountViewEditAddressPage($id)
    {
        // Fetch user with their addresses
        $user = \App\Models\User::with('addresses')->findOrFail($id);

        return view('admin.user-account-edit-address', compact('user'));
    }
        

    // Add User
    // Show "Add User" Page
    public function createUserPage()
    {
        return view('admin.user-management-create');
    }


    // Handle Add User Form Submission
    public function storeUser(Request $request)
    {
        // Validation rules
        $rules = [
            'first_name' => 'required|string|max:50|regex:/^[A-Za-z\s\-]+$/',
            'middle_name' => 'nullable|string|max:50|regex:/^[A-Za-z\s\-]+$/',
            'last_name' => 'required|string|max:50|regex:/^[A-Za-z\s\-]+$/',
            'email' => 'required|string|email|max:255|unique:users,email',
            'phone' => 'nullable|string|regex:/^\+?[0-9]{11,13}$/',
            'gender' => 'nullable|in:male,female,other',
            'date_of_birth' => 'nullable|date|before:today',
            'role' => 'required|in:user,admin',
            'password' => 'required|string|min:8|max:64|confirmed',
            'profile_photo' => 'nullable|image|max:2048',
        ];

        $validated = $request->validate($rules);

        // Handle profile photo
        if ($request->hasFile('profile_photo')) {
            $file = $request->file('profile_photo');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('images/user-profile-pictures'), $fileName);
            $validated['profile_picture_path'] = 'images/user-profile-pictures/' . $fileName;
        }

        // Hash password
        $validated['password'] = Hash::make($validated['password']);

        // dd($request);
        // Create user
        User::create($validated);
         $this->logAdminAction('create', 'User', $user->id, 'Created new user account');
        // Redirect back
        return redirect()->route('admin.user-management')->with('success', 'User added successfully.');
    }

// Protected helper to log admin actions
    protected function logAdminAction($action, $targetType = null, $targetId = null, $details = null)
    {
        AdminLog::create([
            'admin_id' => auth()->id(),
            'action' => $action,
            'target_type' => $targetType,
            'target_id' => $targetId,
            'details' => $details,
            'ip_address' => request()->ip(),
        ]);
    }

}
