<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="Book",
 *     description="Book model",
 *     type="object",
 *     title="Book",
 *     @OA\Property(property="id", type="integer", description="ID of the book"),
 *     @OA\Property(property="title", type="string", description="Title of the book"),
 *     @OA\Property(property="author", type="string", description="Author of the book"),
 *     @OA\Property(property="year_of_publication", type="integer", description="Year the book was published"),
 *     @OA\Property(property="publisher", type="string", description="Publisher of the book"),
 *     @OA\Property(property="is_rented", type="boolean", description="Indicates if the book is rented"),
 *     @OA\Property(property="rented_by", type="integer", description="ID of the client who rented the book", nullable=true)
 * )
 */
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
