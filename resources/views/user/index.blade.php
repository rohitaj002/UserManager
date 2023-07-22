<!-- resources/views/login_logout_events/index.blade.php -->

@extends('layouts.app')

@section('content')
    <h1>Login and Logout Events</h1>

    <!-- Search Form -->
    <form action="{{ route('login_logout_events.index') }}" method="GET">
        <input type="text" name="user_name" placeholder="User Name" value="{{ request('user_name') }}">
        <input type="text" name="date_range" placeholder="Date Range" value="{{ request('date_range') }}" class="datepicker">
        <button type="submit">Search</button>
    </form>

    <!-- Event Table -->
    <table>
        <thead>
            <tr>
                <th>
                    User Name
                    <a href="{{ route('login_logout_events.index', ['sort_column' => 'user.name', 'sort_order' => $sortOrder == 'asc' ? 'desc' : 'asc']) }}">
                        <i class="fas fa-sort{{ $sortColumn == 'user.name' ? '-' . ($sortOrder == 'asc' ? 'down' : 'up') : '' }}"></i>
                    </a>
                </th>
                <th>
                    Logged In
                    <a href="{{ route('login_logout_events.index', ['sort_column' => 'login_time', 'sort_order' => $sortOrder == 'asc' ? 'desc' : 'asc']) }}">
                        <i class="fas fa-sort{{ $sortColumn == 'login_time' ? '-' . ($sortOrder == 'asc' ? 'down' : 'up') : '' }}"></i>
                    </a>
                </th>
                <th>
                    Logout
                    <a href="{{ route('login_logout_events.index', ['sort_column' => 'logout_time', 'sort_order' => $sortOrder == 'asc' ? 'desc' : 'asc']) }}">
                        <i class="fas fa-sort{{ $sortColumn == 'logout_time' ? '-' . ($sortOrder == 'asc' ? 'down' : 'up') : '' }}"></i>
                    </a>
                </th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($events as $event)
                <tr>
                    <td>{{ $event->user->name }}</td>
                    <td>{{ $event->login_time }}</td>
                    <td>
                        @if ($event->logout_time)
                            {{ $event->logout_time }}
                        @else
                            <form action="{{ route('login_logout_events.force_logout', ['event' => $event->id]) }}" method="POST">
                                @csrf
                                <button type="submit">Logout Forcefully</button>
                            </form>
                        @endif
                    </td>
                    <td>
                        <!-- Add additional action buttons/icons here -->
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $events->links() }}

    <script>
        // Date Range Picker Initialization
        // $('.datepicker').datepicker();
    </script>
@endsection
