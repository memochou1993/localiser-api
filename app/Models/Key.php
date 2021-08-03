<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $project_id
 * @property Project $project
 */
class Key extends Model
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

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function language()
    {
        return $this->belongsTo(Language::class);
    }

    public function values()
    {
        return $this->hasMany(Value::class);
    }
}
