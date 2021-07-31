<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
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
        'value',
        'language_id',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function language()
    {
        return $this->belongsTo(Language::class);
    }
}
