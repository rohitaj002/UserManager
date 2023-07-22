<?php

namespace App\Http\Controllers;

use App\Models\LoginLogoutEvent;
use Illuminate\Http\Request;

class LoginLogoutEventController extends Controller
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

        return view('login_logout_events.index', ['events' => $events]);
    }

    public function forceLogout(LoginLogoutEvent $event)
    {
        if ($event->logout_time === null) {
            $event->logout_time = now();
            $event->save();
        }

        // Add your logic to forcefully log out the user here

        return redirect()->route('login_logout_events.index')->with('success', 'User forcefully logged out.');
    }
}
