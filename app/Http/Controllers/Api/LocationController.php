<?php

namespace App\Http\Controllers\Api;

use Gate;
use App\Http\Controllers\Controller;
use App\Http\Resources\LocationResource;
use App\Models\Location;
use App\Repository\LocationReposityInterface;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LocationController extends Controller
{
    private $locationReposity;

    public function __construct(LocationReposityInterface $locationReposity)
    {
        $this->locationReposity = $locationReposity;
    }

    public function index()
    {
        abort_if(Gate::denies('location_access', auth()->user()), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $locations = $this->locationReposity->all();

        return response()
            ->json([
                'data' => LocationResource::collection($locations),
                'status' => Response::HTTP_OK
            ], Response::HTTP_OK);
    }

    public function show(Location $location)
    {
        abort_if(Gate::denies('location_show', auth()->user()), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $location = $this->locationReposity->find($location->id);

        return response()
            ->json([
                'data' => new LocationResource($location),
                'status' => Response::HTTP_OK
            ], Response::HTTP_OK);
    }

    public function store(Request $request)
    {
        abort_if(Gate::denies('location_create', auth()->user()), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $request->validate([
            'shelf_no' => 'required|string',
            'shelf_name' => 'required|string',
        ]);

        $location = $this->locationReposity->create($request->all());

        return response()
            ->json([
                'data' => new LocationResource($location),
                'message' => 'Location created successfully',
                'status' => Response::HTTP_OK
            ], Response::HTTP_OK);
    }

    public function update(Request $request, Location $location)
    {
        abort_if(Gate::denies('location_edit', auth()->user()), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $request->validate([
            'shelf_no' => 'required|string',
            'shelf_name' => 'required|string',
        ]);

        $location = $this->locationReposity->update($request->all(), $location->id);

        return response()
            ->json([
                'data' => new LocationResource($location),
                'message' => 'Location updated successfully',
                'status' => Response::HTTP_OK
            ], Response::HTTP_OK);
    }

    public function destroy(Location $location)
    {
        abort_if(Gate::denies('location_delete', auth()->user()), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $this->locationReposity->delete($location->id);

        return response()
            ->json([
                'message' => 'Location deleted successfully',
                'status' => Response::HTTP_OK
            ], Response::HTTP_OK);
    }
}
