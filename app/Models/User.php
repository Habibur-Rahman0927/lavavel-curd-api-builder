<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    const USER_TYPE_DEFAULT = 0;
    const USER_TYPE_SUPER_ADMIN = 1;
    const USER_TYPE_ADMIN = 2;

    const USER_IS_IN_ACTIVE = 0;
    const USER_IS_ACTIVE = 1;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'user_type',
        'is_active',
        'role'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public static function getPermissionGroups(): Collection
    {
        return DB::table('permissions')
            ->select('group_name', 'name', 'id')
            ->orderBy('group_name', 'ASC')
            ->get()
            ->groupBy('group_name');
    }
}
