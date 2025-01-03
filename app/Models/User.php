<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * Class User
 * 
 * @property int $id
 * @property string $name
 * @property string $email
 * @property Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string $role
 * @property bool $is_active
 * @property string|null $address
 * @property string|null $telephone
 * 
 * @property Collection|DeliveryMan[] $delivery_men
 * @property Collection|Seller[] $sellers
 *
 * @package App\Models
 */
class User extends Authenticatable
{
    use HasFactory;
    protected $table = 'users';

    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_active' => 'bool'
    ];

    protected $hidden = [
        'password',
        'remember_token'
    ];

    protected $fillable = [
        'name',
        'email',
        'avatar',
        'email_verified_at',
        'password',
        'remember_token',
        'role',
        'is_active',
        'address',
        'telephone'
    ];

    public function delivery_men()
    {
        return $this->hasMany(DeliveryMan::class);
    }

    public function sellers()
    {
        return $this->hasMany(Seller::class);
    }

    protected static function booted()
    {
        static::saved(callback: function ($user) {
            //
        });
    }
}
