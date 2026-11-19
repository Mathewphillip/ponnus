<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Menu Model
 *
 * Demonstrates Eloquent ORM in Laravel:
 * - Represents the 'menus' table in the MySQL database.
 * - Each instance represents a single row/record.
 * - Provides methods to retrieve (all(), findOrFail()), create (save()),
 *   update (save()), and delete (delete()) records.
 */
class Menu extends Model
{
    use HasFactory;

    /**
     * The database table associated with the model.
     * Laravel convention automatically maps 'Menu' to 'menus',
     * but defining it explicitly helps beginner understanding.
     *
     * @var string
     */
    protected $table = 'menus';

    /**
     * The attributes that are mass assignable.
     *
     * $fillable protects against Mass Assignment vulnerability by defining
     * which database columns are allowed to be populated via arrays or mass assignment.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
        'category',
        'price',
        'availability',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'price' => 'decimal:2',
    ];
}
