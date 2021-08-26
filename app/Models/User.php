<?php

namespace App\Models;

use App\Models\Traits\HasHashId;
use App\Models\Traits\HasTokens;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;

/**
 * @property string $id
 * @property string $hash_id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property int $role
 * @property Carbon created_at
 * @property Carbon updated_at
 * @property Carbon deleted_at
 * @property Pivot pivot
 * @property Collection $projects
 */
class User extends Authenticatable
{
    use HasFactory;
    use HasApiTokens, HasTokens {
        HasTokens::tokens insteadof HasApiTokens;
        HasTokens::createToken insteadof HasApiTokens;
    }
    use HasHashId;
    use Notifiable;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }

    public function projects()
    {
        return $this->belongsToMany(Project::class)->withPivot('role');
    }
}
