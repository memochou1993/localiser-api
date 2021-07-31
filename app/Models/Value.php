<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property Key $key
 */
class Value extends Model
{
    use HasFactory;

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
