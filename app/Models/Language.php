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
 * @property string $locale
 * @property int $project_id
 * @property Project $project
 * @property Carbon created_at
 * @property Carbon updated_at
 */
class Language extends Model
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
        'locale',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
