<?php

namespace App\Models;

use App\Models\Traits\HasHashId;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property int $hash_id
 * @property string $name
 * @property string $description
 * @property int $project_id
 * @property Carbon created_at
 * @property Carbon updated_at
 * @property Project $project
 */
class Key extends Model
{
    use HasFactory;
    use HasHashId;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
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
