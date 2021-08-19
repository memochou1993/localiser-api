<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string $name
 * @property Pivot pivot
 * @property Carbon created_at
 * @property Carbon updated_at
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
        return $this->belongsToMany(User::class)->withPivot(['role']);
    }

    public function languages()
    {
        return $this->hasMany(Language::class);
    }

    public function keys()
    {
        return $this->hasMany(Key::class);
    }

    public function values()
    {
        return $this->hasMany(Value::class);
    }
}
