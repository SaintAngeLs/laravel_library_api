<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'author',
        'year_of_publication',
        'publisher',
        'is_rented',
        'rented_by', // stores client_id if rented
    ];

    /**
     * Relationships.
     * A book can be rented by a client.
     */
    public function client()
    {
        return $this->belongsTo(Client::class, 'rented_by');
    }

    /**
     * Scope to filter books by rental status.
     *
     * @param $query
     * @param bool $isRented
     * @return mixed
     */
    public function scopeIsRented($query, $isRented = true)
    {
        return $query->where('is_rented', $isRented);
    }
}
