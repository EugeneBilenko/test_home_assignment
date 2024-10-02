<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'role',
        'access',
    ];

    public static function managerRole()
    {
        return self::where('role', 'manager')->value('id') ?? 0;
    }

    public static function employeeRole()
    {
        return self::where('role', 'employee')->value('id') ?? 0;
    }
}
