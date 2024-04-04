<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Author;
use App\Models\Publisher;
use Illuminate\Support\Str;
use App\Models\BookCategory;
use App\Models\LibrarySetting;
use App\Models\Location;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class GeneralTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $library_setting = [
            [
                'id'    => 1,
                'name' => 'Library',
                'address' => 'Yangon',
                'contact_no' => '09111222333',
                'book_return_day_limit' => '10',
                'late_return_one_day_fine' => '500',
                'book_issue_limit' => '3',
            ],
        ];

        LibrarySetting::insert($library_setting);

        $authors = [
            [
                'id'    => 1,
                'name' => 'Author One',
            ],
            [
                'id'    => 2,
                'name' => 'Author Two',
            ],
            [
                'id'    => 3,
                'name' => 'Author Three',
            ],
        ];

        Author::insert($authors);

        $book_categories = [
            [
                'id'    => 1,
                'name' => 'Category One',
                'slug'  => Str::slug('Category One', "-")
            ],
            [
                'id'    => 2,
                'name' => 'Category Two',
                'slug'  => Str::slug('Category Two', "-")
            ],
            [
                'id'    => 3,
                'name' => 'Category Three',
                'slug'  => Str::slug('Category Three', "-")
            ],
        ];

        BookCategory::insert($book_categories);

        $publishers = [
            [
                'id'    => 1,
                'name' => 'Publisher One',
            ],
            [
                'id'    => 2,
                'name' => 'Publisher Two',
            ],
            [
                'id'    => 3,
                'name' => 'Publisher Three',
            ],
        ];

        Publisher::insert($publishers);

        $loations = [
            [
                'id'    => 1,
                'shelf_no'  => 'SH_01',
                'shelf_name' => 'Shelf One',
                'floor_no' => '1',
            ],
            [
                'id'    => 2,
                'shelf_no'  => 'SH_02',
                'shelf_name' => 'Shelf Two',
                'floor_no' => '1',
            ],
            [
                'id'    => 3,
                'shelf_no'  => 'SH_03',
                'shelf_name' => 'Shelf Three',
                'floor_no' => '1',
            ],
        ];

        Location::insert($loations);

        $books = [
            [
                'id'    => 1,
                'title' => 'Book One',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce orci nisi, convallis et diam eu, aliquet porta urna. Donec vitae turpis scelerisque, efficitur lorem at, tincidunt urna. Pellentesque orci ligula, iaculis eleifend gravida quis, placerat eu ipsum. Fusce ligula enim, molestie eu ipsum sit amet, aliquet ornare libero. Nulla semper sed nibh sed venenatis. Quisque in nibh ut massa dapibus dignissim. Nunc ultricies interdum molestie.',
                'book_category_id' => 1,
                'author_id' => 1,
                'publisher_id' => 1,
                'location_id' => 1,
                'isbn_no' => 'ISBN_000001',
                'edition'  => 'first edition',
                'date_of_purchase' => date('Y-m-d'),
                'price' => '10000',
            ],
            [
                'id'    => 2,
                'title' => 'Book Two',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce orci nisi, convallis et diam eu, aliquet porta urna. Donec vitae turpis scelerisque, efficitur lorem at, tincidunt urna. Pellentesque orci ligula, iaculis eleifend gravida quis, placerat eu ipsum. Fusce ligula enim, molestie eu ipsum sit amet, aliquet ornare libero. Nulla semper sed nibh sed venenatis. Quisque in nibh ut massa dapibus dignissim. Nunc ultricies interdum molestie.',
                'book_category_id' => 2,
                'author_id' => 2,
                'publisher_id' => 2,
                'location_id' => 2,
                'isbn_no' => 'ISBN_000002',
                'edition'  => 'first edition',
                'date_of_purchase' => date('Y-m-d'),
                'price' => '10000',
            ],
            [
                'id'    => 3,
                'title' => 'Book Three',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce orci nisi, convallis et diam eu, aliquet porta urna. Donec vitae turpis scelerisque, efficitur lorem at, tincidunt urna. Pellentesque orci ligula, iaculis eleifend gravida quis, placerat eu ipsum. Fusce ligula enim, molestie eu ipsum sit amet, aliquet ornare libero. Nulla semper sed nibh sed venenatis. Quisque in nibh ut massa dapibus dignissim. Nunc ultricies interdum molestie.',
                'book_category_id' => 3,
                'author_id' => 3,
                'publisher_id' => 3,
                'location_id' => 3,
                'isbn_no' => 'ISBN_000003',
                'edition'  => 'first edition',
                'date_of_purchase' => date('Y-m-d'),
                'price' => '10000',
            ],
        ];

        Book::insert($books);
    }
}
