<?php

namespace App\Http\Controllers\Api;

use Gate;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Resources\BookResource;
use App\Repository\BookReposityInterface;
use Symfony\Component\HttpFoundation\Response;

class BookController extends Controller
{
    private $bookReposity;

    public function __construct(BookReposityInterface $bookReposity)
    {
        $this->bookReposity = $bookReposity;
    }

    public function index(Request $request)
    {
        abort_if(Gate::denies('book_access', auth()->user()), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $books = $this->bookReposity->all($request->all());

        return response()
            ->json([
                'data' => BookResource::collection($books),
                'status' => Response::HTTP_OK
            ], Response::HTTP_OK);
    }

    public function show(Book $book)
    {
        abort_if(Gate::denies('book_show', auth()->user()), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $book = $this->bookReposity->find($book->id);

        return response()
            ->json([
                'data' => new BookResource($book),
                'status' => Response::HTTP_OK
            ], Response::HTTP_OK);
    }

    public function store(Request $request)
    {
        abort_if(Gate::denies('book_create', auth()->user()), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $request->validate([
            'title' => 'required|string',
            'isbn_no' => 'required|string|unique:books',
            'status' => 'nullable|boolean',
            'copies_total' => 'nullable|numeric',
            'copies_available' => 'nullable|numeric',
            'edition' => 'nullable|string',
            'date_of_purchase' => 'nullable|date',
            'price' => 'nullable|numeric',
            'image' => 'nullable|file',
            'book_category_id' => 'nullable|integer',
            'author_id' => 'nullable|integer',
            'publisher_id' => 'nullable|integer',
            'location_id' => 'nullable|integer',
        ]);

        try {
            DB::beginTransaction();
            $book = $this->bookReposity->create($request->all());
            DB::commit();
            return response()
                ->json([
                    'data' => new BookResource($book),
                    'message' => 'Book created successfully',
                    'status' => Response::HTTP_OK
                ], Response::HTTP_OK);
        } catch (\Exception $e) {
            DB::rollBack();
            return $e;
            return response()
                ->json([
                    'message' => 'Fail to create',
                    'status' => Response::HTTP_INTERNAL_SERVER_ERROR
                ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function update(Request $request, Book $book)
    {
        abort_if(Gate::denies('book_edit', auth()->user()), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $request->validate([
            'title' => 'required|string',
            'isbn_no' => [
                'required',
                'string',
                Rule::unique('books')->ignore($book->id),
            ],
            'status' => 'nullable|boolean',
            'copies_total' => 'nullable|numeric',
            'copies_available' => 'nullable|numeric',
            'edition' => 'nullable|string',
            'date_of_purchase' => 'nullable|date',
            'price' => 'nullable|numeric',
            'image' => 'nullable|file',
            'book_category_id' => 'nullable|integer',
            'author_id' => 'nullable|integer',
            'publisher_id' => 'nullable|integer',
            'location_id' => 'nullable|integer',
        ]);

        try {
            DB::beginTransaction();
            $book = $this->bookReposity->update($request->all(), $book->id);
            DB::commit();

            return response()
                ->json([
                    'data' => new BookResource($book),
                    'message' => 'Book updated successfully',
                    'status' => Response::HTTP_OK
                ], Response::HTTP_OK);
        } catch (\Exception $e) {
            DB::rollBack();
            return $e;
            return response()
                ->json([
                    'message' => 'Fail to update',
                    'status' => Response::HTTP_INTERNAL_SERVER_ERROR
                ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function destroy(Book $book)
    {
        abort_if(Gate::denies('book_delete', auth()->user()), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $this->bookReposity->delete($book->id);

        return response()
            ->json([
                'message' => 'Book deleted successfully',
                'status' => Response::HTTP_OK
            ], Response::HTTP_OK);
    }
}
