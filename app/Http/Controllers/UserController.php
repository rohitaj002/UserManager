<?php

namespace App\Http\Controllers;

use App\Models\LoginLogoutEvent;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Models\Picture;
use GuzzleHttp\Client;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = LoginLogoutEvent::with('user');

        // Apply search filters
        if ($request->has('user_name')) {
            $query->whereHas('user', function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->input('user_name') . '%');
            });
        }

        if ($request->has('date_range')) {
            $dates = explode(' - ', $request->input('date_range'));
            $query->whereBetween('login_time', [$dates[0], $dates[1]]);
        }

        // Apply sorting
        $sortColumn = $request->input('sort_column', 'login_time');
        $sortOrder = $request->input('sort_order', 'desc');
        $query->orderBy($sortColumn, $sortOrder);

        $events = $query->paginate(20);

        return view('user.index', ['events' => $events,'sortOrder'=>$sortOrder,'sortColumn'=>$sortColumn]);
    }

    public function forceLogout(LoginLogoutEvent $event)
    {
        if ($event->logout_time === null) {
            $event->logout_time = now();
            $event->save();
        }

        // Add your logic to forcefully log out the user here

        return redirect()->route('user.logout')->with('success', 'User forcefully logged out.');
    }

    public function create()
    {
        return view('user.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:users',
            'phone' => 'required|digits:10',
            'password' => 'required|min:8',
            'image' => 'nullable',
        ]);

        $url = 'https://foremflickr.com/240/320/boy'; // Replace with the actual API URL

        $client = new Client();

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Store the user and process the image URL
        $user = new User();
        $user->first_name = $request->input('first_name');
        $user->last_name = $request->input('last_name');
        $user->email = $request->input('email');
        $user->phone = $request->input('phone');
        $user->password = bcrypt($request->input('password'));

        // Process and store the image
        if (!$request->has('image')) {
            $imageUrl = $client->get($url);
            // var_dump($imageUrl);
            $fileName = basename($imageUrl);
            $user->image = $fileName;
        }

        $user->save();

        return redirect()->back()->with('success', 'User created successfully.');
    }
    public function success()
    {
        return view('user.success');
    }

    public function update(Request $request, User $user)
    {
        // Validate the input data
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|unique:users,email,' . $user->id,
            'phone' => 'required',
        ]);

        // Update the user
        $user->first_name = $request->input('first_name');
        $user->last_name = $request->input('last_name');
        $user->email = $request->input('email');
        $user->phone = $request->input('phone');
        // Update the user image if provided
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images'), $imageName);
            $user->image = $imageName;
        }
        $user->save();

        return redirect()->route('users.index')->with('success', 'User updated successfully!');
    }

    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('users.index')->with('success', 'User deleted successfully!');
    }

    public function edit(User $user)
    {
        return view('user.edit', ['user' => $user]);
    }




}
