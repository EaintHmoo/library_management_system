<?php

namespace App\Http\Controllers\Api;

use Gate;
use App\Models\Fine;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\FineResource;
use App\Repository\FineReposityInterface;
use Symfony\Component\HttpFoundation\Response;

class FineController extends Controller
{
    private $fineReposity;

    public function __construct(FineReposityInterface $fineReposity)
    {
        $this->fineReposity = $fineReposity;
    }

    public function index(Request $request)
    {
        abort_if(Gate::denies('fine_access', auth()->user()), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $fines = $this->fineReposity->all($request->all());

        return response()
            ->json([
                'data' => FineResource::collection($fines),
                'status' => Response::HTTP_OK
            ], Response::HTTP_OK);
    }

    public function show(Fine $fine)
    {
        abort_if(Gate::denies('fine_show', auth()->user()), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $fine = $this->fineReposity->find($fine->id);

        return response()
            ->json([
                'data' => new FineResource($fine),
                'status' => Response::HTTP_OK
            ], Response::HTTP_OK);
    }

    public function store(Request $request)
    {
        abort_if(Gate::denies('fine_create', auth()->user()), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $request->validate([
            'fine_date' => 'required|date',
            'payment_date' => 'nullable|date',
            'fine_amount' => 'required|numeric',
            'is_checked' => 'nullable|boolean',
            'member_id' => 'required|integer',
            'checkout_id' => 'required|integer',
        ]);

        $fine = $this->fineReposity->create($request->all());

        return response()
            ->json([
                'data' => new FineResource($fine),
                'message' => 'Fine created successfully',
                'status' => Response::HTTP_OK
            ], Response::HTTP_OK);
    }

    public function update(Request $request, Fine $fine)
    {
        abort_if(Gate::denies('fine_edit', auth()->user()), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $request->validate([
            'fine_date' => 'required|date',
            'payment_date' => 'nullable|date',
            'fine_amount' => 'required|numeric',
            'is_checked' => 'nullable|boolean',
            'member_id' => 'required|integer',
            'checkout_id' => 'required|integer',
        ]);

        $fine = $this->fineReposity->update($request->all(), $fine->id);

        return response()
            ->json([
                'data' => new FineResource($fine),
                'message' => 'Fine updated successfully',
                'status' => Response::HTTP_OK
            ], Response::HTTP_OK);
    }

    public function destroy(Fine $fine)
    {
        abort_if(Gate::denies('fine_delete', auth()->user()), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $this->fineReposity->delete($fine->id);

        return response()
            ->json([
                'message' => 'Fine deleted successfully',
                'status' => Response::HTTP_OK
            ], Response::HTTP_OK);
    }
}
