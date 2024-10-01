<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="Client",
 *     description="Client model",
 *     type="object",
 *     title="Client",
 *     @OA\Property(property="id", type="integer", description="ID of the client"),
 *     @OA\Property(property="first_name", type="string", description="First name of the client"),
 *     @OA\Property(property="last_name", type="string", description="Last name of the client"),
 *     @OA\Property(property="rentedBooks", type="array", @OA\Items(ref="#/components/schemas/Book"), description="Books rented by the client")
 * )
 */
class Client extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
    ];

    /**
     * Relationships.
     * A client can have many rented books.
     */
    public function rentedBooks()
    {
        return $this->hasMany(Book::class, 'rented_by');
    }
}
