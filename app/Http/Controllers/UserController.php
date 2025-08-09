<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Cache;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $perPage = 50; // Number of records per page
        $search = $request->input('search');

        // Cache the query for 10 minutes to reduce database load
        $cacheKey = 'users_' . md5($search . '_' . $request->page);
        $users = Cache::remember($cacheKey, 600, function () use ($search, $perPage) {
            $query = User::query();

            // Apply search filter
            if ($search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            }

            return $query->paginate($perPage);
        });

        return view('index', compact('users', 'search'));
    }
}
