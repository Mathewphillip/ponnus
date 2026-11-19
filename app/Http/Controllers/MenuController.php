<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;

/**
 * MenuController
 *
 * Demonstrates traditional Laravel MVC controller architecture:
 * Handles HTTP requests, coordinates with the Menu Eloquent model,
 * and returns Blade views with data.
 *
 * Note on Teaching Convention:
 * index() and create() are deliberately assigned as:
 * - index()  => Display the add-menu form
 * - create() => Display the menu items list
 * This deliberate arrangement demonstrates custom route and controller mappings.
 */
class MenuController extends Controller
{
    /**
     * Display the add-menu form.
     * (Deliberate teaching convention: index displays the creation form)
     */
    public function index()
    {
        return view('dashboard.add-menu');
    }

    /**
     * Display the menu items list.
     * (Deliberate teaching convention: create displays the menu items list)
     */
    public function create()
    {
        // Eloquent ORM: Retrieve all records from the menus table
        $menus = Menu::all();

        // Pass data to the Blade view using compact()
        return view('dashboard.menu', compact('menus'));
    }

    /**
     * Save a new menu item to the database.
     * Demonstrates Request injection, basic validation, and Eloquent persistence.
     */
    public function store(Request $request)
    {
        // 1. Basic Laravel Form Validation
        $request->validate([
            'name'         => 'required|string|max:255',
            'description'  => 'nullable|string',
            'category'     => 'required|string|max:100',
            'price'        => 'required|numeric|min:0',
            'availability' => 'required|in:Available,Unavailable',
        ]);

        // 2. Instantiate a new Menu Eloquent model
        $menu = new Menu();

        // 3. Retrieve submitted form values using $request->input() and assign individually
        $menu->name         = $request->input('name');
        $menu->description  = $request->input('description');
        $menu->category     = $request->input('category');
        $menu->price        = $request->input('price');
        $menu->availability = $request->input('availability');

        // 4. Persist the record to MySQL database using save()
        $menu->save();

        // 5. Redirect back with a flash success message
        return redirect()->back()->with('success', 'Menu item "' . $menu->name . '" created successfully!');
    }

    /**
     * Display the edit form for an existing menu item.
     */
    public function edit($id)
    {
        // Eloquent ORM: Retrieve the record or trigger a 404 HTTP exception
        $menu = Menu::findOrFail($id);

        return view('dashboard.edit-menu', compact('menu'));
    }

    /**
     * Update an existing menu item in the database.
     * Demonstrates retrieval via findOrFail(), individual property update, and save().
     */
    public function update(Request $request, $id)
    {
        // 1. Validate the submitted form data
        $request->validate([
            'name'         => 'required|string|max:255',
            'description'  => 'nullable|string',
            'category'     => 'required|string|max:100',
            'price'        => 'required|numeric|min:0',
            'availability' => 'required|in:Available,Unavailable',
        ]);

        // 2. Retrieve existing record using findOrFail()
        $menu = Menu::findOrFail($id);

        // 3. Assign updated form values individually to model properties
        $menu->name         = $request->input('name');
        $menu->description  = $request->input('description');
        $menu->category     = $request->input('category');
        $menu->price        = $request->input('price');
        $menu->availability = $request->input('availability');

        // 4. Persist updates to the database
        $menu->save();

        // 5. Redirect back with a flash success message
        return redirect()->back()->with('success', 'Menu item "' . $menu->name . '" updated successfully!');
    }

    /**
     * Delete a menu item from the database.
     * Demonstrates record deletion using findOrFail() and delete().
     */
    public function destroy($id)
    {
        // Retrieve the record to be deleted
        $menu = Menu::findOrFail($id);
        $itemName = $menu->name;

        // Delete the record from the database
        $menu->delete();

        // Redirect back with a flash success notification
        return redirect()->back()->with('success', 'Menu item "' . $itemName . '" deleted successfully!');
    }
}
