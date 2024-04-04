<?php

namespace App\Http\Controllers\Api;

use Gate;
use App\Http\Controllers\Controller;
use App\Http\Resources\AuthorResource;
use App\Models\Author;
use App\Repository\AuthorRepositoryInterface;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthorController extends Controller
{
    private $authorReposity;

    public function __construct(AuthorRepositoryInterface $authorReposity)
    {
        $this->authorReposity = $authorReposity;
    }

    public function index()
    {
        abort_if(Gate::denies('author_access', auth()->user()), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $authors = $this->authorReposity->all();

        return response()
            ->json([
                'data' => AuthorResource::collection($authors),
                'status' => Response::HTTP_OK
            ], Response::HTTP_OK);
    }

    public function show(Author $author)
    {
        abort_if(Gate::denies('author_show', auth()->user()), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $author = $this->authorReposity->find($author->id);

        return response()
            ->json([
                'data' => new AuthorResource($author),
                'status' => Response::HTTP_OK
            ], Response::HTTP_OK);
    }

    public function store(Request $request)
    {
        abort_if(Gate::denies('author_create', auth()->user()), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $request->validate([
            'name' => 'required|string',
            'year_of_birth' => 'nullable',
            'year_of_death' => 'nullable',
        ]);

        $author = $this->authorReposity->create($request->all());

        return response()
            ->json([
                'data' => new AuthorResource($author),
                'message' => 'Author created successfully',
                'status' => Response::HTTP_OK
            ], Response::HTTP_OK);
    }

    public function update(Request $request, Author $author)
    {
        abort_if(Gate::denies('author_edit', auth()->user()), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $request->validate([
            'name' => 'required|string',
            'year_of_birth' => 'nullable',
            'year_of_death' => 'nullable',
        ]);

        $author = $this->authorReposity->update($request->all(), $author->id);

        return response()
            ->json([
                'data' => new AuthorResource($author),
                'message' => 'Author updated successfully',
                'status' => Response::HTTP_OK
            ], Response::HTTP_OK);
    }

    public function destroy(Author $author)
    {
        abort_if(Gate::denies('author_delete', auth()->user()), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $this->authorReposity->delete($author->id);

        return response()
            ->json([
                'message' => 'Author deleted successfully',
                'status' => Response::HTTP_OK
            ], Response::HTTP_OK);
    }
}
