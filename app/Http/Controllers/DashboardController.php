<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * DashboardController
 *
 * Prepares summary metrics for the Ponnus restaurant dashboard:
 * - Current authenticated user details and role
 * - Total menu items count
 * - Available menu items count
 * - Unavailable menu items count
 */
class DashboardController extends Controller
{
    /**
     * Show the application dashboard.
     */
    public function index()
    {
        $user = Auth::user();

        // Calculate key menu statistics using Eloquent query builder
        $totalMenus       = Menu::count();
        $availableMenus   = Menu::where('availability', 'Available')->count();
        $unavailableMenus = Menu::where('availability', 'Unavailable')->count();

        // Pass variables to the Blade view using compact()
        return view('dashboard.index', compact(
            'user',
            'totalMenus',
            'availableMenus',
            'unavailableMenus'
        ));
    }
}
