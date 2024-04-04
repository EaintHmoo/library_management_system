<?php

namespace App\Http\Controllers\Api;

use Gate;
use App\Http\Controllers\Controller;
use App\Http\Resources\PublisherResource;
use App\Models\Publisher;
use App\Repository\PublisherReposityInterface;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PublisherController extends Controller
{
    private $publisherReposity;

    public function __construct(PublisherReposityInterface $publisherReposity)
    {
        $this->publisherReposity = $publisherReposity;
    }

    public function index()
    {
        abort_if(Gate::denies('publisher_access', auth()->user()), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $publishers = $this->publisherReposity->all();

        return response()
            ->json([
                'data' => PublisherResource::collection($publishers),
                'status' => Response::HTTP_OK
            ], Response::HTTP_OK);
    }

    public function show(Publisher $publisher)
    {
        abort_if(Gate::denies('publisher_show', auth()->user()), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $publisher = $this->publisherReposity->find($publisher->id);

        return response()
            ->json([
                'data' => new PublisherResource($publisher),
                'status' => Response::HTTP_OK
            ], Response::HTTP_OK);
    }

    public function store(Request $request)
    {
        abort_if(Gate::denies('publisher_create', auth()->user()), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $request->validate([
            'name' => 'required|string',
        ]);

        $publisher = $this->publisherReposity->create($request->all());

        return response()
            ->json([
                'data' => new PublisherResource($publisher),
                'message' => 'Publisher created successfully',
                'status' => Response::HTTP_OK
            ], Response::HTTP_OK);
    }

    public function update(Request $request, Publisher $publisher)
    {
        abort_if(Gate::denies('publisher_edit', auth()->user()), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $request->validate([
            'name' => 'required|string',
        ]);

        $publisher = $this->publisherReposity->update($request->all(), $publisher->id);

        return response()
            ->json([
                'data' => new PublisherResource($publisher),
                'message' => 'Publisher updated successfully',
                'status' => Response::HTTP_OK
            ], Response::HTTP_OK);
    }

    public function destroy(Publisher $publisher)
    {
        abort_if(Gate::denies('publisher_delete', auth()->user()), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $this->publisherReposity->delete($publisher->id);

        return response()
            ->json([
                'message' => 'Publisher deleted successfully',
                'status' => Response::HTTP_OK
            ], Response::HTTP_OK);
    }
}
