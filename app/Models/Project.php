<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property Collection $users
 * @property Collection $languages
 * @property Collection $keys
 */
class Project extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class)->withPivot(['roles']);
    }

    public function languages()
    {
        return $this->hasMany(Language::class);
    }

    public function keys()
    {
        return $this->hasMany(Key::class);
    }
}
