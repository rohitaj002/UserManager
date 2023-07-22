<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;


class Users extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {

        // Your User controller logic here
        
        // Example: Get all users from the database
        $users = User::all();
        
        return view('livewire.user-management', ['users' => $users]);
    }
}
