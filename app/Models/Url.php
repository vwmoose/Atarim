<?php

namespace App\Models;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Url extends Model
{
    use HasFactory;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'code',
        'domain',
        'url'
    ];

    /**
     * filter urls by code
     */
    public function scopeByCode($query, $code): Builder
    {
        return $query->where('code', $code);
    }
}
