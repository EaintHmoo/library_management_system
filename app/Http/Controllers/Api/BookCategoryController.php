<?php

namespace App\Http\Controllers\Api;

use Gate;
use App\Http\Controllers\Controller;
use App\Http\Resources\BookCategoryResource;
use App\Models\BookCategory;
use App\Repository\BookCategoryReposityInterface;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class BookCategoryController extends Controller
{
    private $bookCategoryReposity;

    public function __construct(BookCategoryReposityInterface $bookCategoryReposity)
    {
        $this->bookCategoryReposity = $bookCategoryReposity;
    }

    public function index()
    {
        abort_if(Gate::denies('book_category_access', auth()->user()), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $book_categories = $this->bookCategoryReposity->all();

        return response()
            ->json([
                'data' => BookCategoryResource::collection($book_categories),
                'status' => Response::HTTP_OK
            ], Response::HTTP_OK);
    }

    public function show(BookCategory $book_category)
    {
        abort_if(Gate::denies('book_category_show', auth()->user()), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $book_category = $this->bookCategoryReposity->find($book_category->id);

        return response()
            ->json([
                'data' => new BookCategoryResource($book_category),
                'status' => Response::HTTP_OK
            ], Response::HTTP_OK);
    }

    public function store(Request $request)
    {
        abort_if(Gate::denies('book_category_create', auth()->user()), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $request->validate([
            'name' => 'required|string',
        ]);

        $book_category = $this->bookCategoryReposity->create($request->all());

        return response()
            ->json([
                'data' => new BookCategoryResource($book_category),
                'message' => 'Book category created successfully',
                'status' => Response::HTTP_OK
            ], Response::HTTP_OK);
    }

    public function update(Request $request, BookCategory $book_category)
    {
        abort_if(Gate::denies('book_category_edit', auth()->user()), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $request->validate([
            'name' => 'required|string',
        ]);

        $book_category = $this->bookCategoryReposity->update($request->all(), $book_category->id);

        return response()
            ->json([
                'data' => new BookCategoryResource($book_category),
                'message' => 'Book category updated successfully',
                'status' => Response::HTTP_OK
            ], Response::HTTP_OK);
    }

    public function destroy(BookCategory $book_category)
    {
        abort_if(Gate::denies('book_category_delete', auth()->user()), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $this->bookCategoryReposity->delete($book_category->id);

        return response()
            ->json([
                'message' => 'Book category deleted successfully',
                'status' => Response::HTTP_OK
            ], Response::HTTP_OK);
    }
}
