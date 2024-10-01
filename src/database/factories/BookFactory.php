<?php

namespace Database\Factories;

use App\Models\Book;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookFactory extends Factory
{
    protected $model = Book::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        static $bookIndex = 1;
        static $year = 1901;

        return [
            'title' => 'book_title_' . $bookIndex,
            'author' => 'book_author_' . $bookIndex,
            'year_of_publication' => $year++,
            'publisher' => 'Random Publisher ' . $bookIndex++,  
            'is_rented' => false,
            'rented_by' => null,
        ];
    }
}
