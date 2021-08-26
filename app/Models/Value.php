<?php

namespace App\Models;

use App\Models\Traits\HasHashId;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property int $hash_id
 * @property string $text
 * @property Key $key
 * @property Carbon created_at
 * @property Carbon updated_at
 */
class Value extends Model
{
    use HasFactory;
    use HasHashId;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'text',
        'language_id',
    ];

    public function key()
    {
        return $this->belongsTo(Key::class);
    }

    public function language()
    {
        return $this->belongsTo(Language::class);
    }
}
