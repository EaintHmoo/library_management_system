<?php

namespace App\Http\Controllers\Api;

use Gate;
use App\Http\Controllers\Controller;
use App\Http\Resources\CheckoutResource;
use App\Models\Checkout;
use App\Repository\CheckoutReposityInterface;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckoutController extends Controller
{
    private $checkoutReposity;

    public function __construct(CheckoutReposityInterface $checkoutReposity)
    {
        $this->checkoutReposity = $checkoutReposity;
    }

    public function index(Request $request)
    {
        abort_if(Gate::denies('checkout_access', auth()->user()), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $checkouts = $this->checkoutReposity->all($request->all());

        return response()
            ->json([
                'data' => CheckoutResource::collection($checkouts),
                'status' => Response::HTTP_OK
            ], Response::HTTP_OK);
    }

    public function show(Checkout $checkout)
    {
        abort_if(Gate::denies('checkout_show', auth()->user()), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $checkout = $this->checkoutReposity->find($checkout->id);

        return response()
            ->json([
                'data' => new CheckoutResource($checkout),
                'status' => Response::HTTP_OK
            ], Response::HTTP_OK);
    }

    public function store(Request $request)
    {
        abort_if(Gate::denies('checkout_create', auth()->user()), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $request->validate([
            'issue_date' => 'required|date',
            'return_date' => 'nullable|date',
            'book_id' => 'required|integer',
            'member_id' => 'required|integer',
            'issued_by_id' => 'required|integer',
            'is_returned' => 'nullable|boolean',
            'is_overdate' => 'nullable|boolean',
        ]);

        $checkout = $this->checkoutReposity->create($request->all());

        return response()
            ->json([
                'data' => new CheckoutResource($checkout),
                'message' => 'Checkout created successfully',
                'status' => Response::HTTP_OK
            ], Response::HTTP_OK);
    }

    public function update(Request $request, Checkout $checkout)
    {
        abort_if(Gate::denies('checkout_edit', auth()->user()), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $request->validate([
            'issue_date' => 'required|date',
            'return_date' => 'nullable|date',
            'book_id' => 'required|integer',
            'member_id' => 'required|integer',
            'issued_by_id' => 'required|integer',
            'is_returned' => 'nullable|boolean',
            'is_overdate' => 'nullable|boolean',
        ]);

        $checkout = $this->checkoutReposity->update($request->all(), $checkout->id);

        return response()
            ->json([
                'data' => new CheckoutResource($checkout),
                'message' => 'Checkout updated successfully',
                'status' => Response::HTTP_OK
            ], Response::HTTP_OK);
    }

    public function destroy(Checkout $checkout)
    {
        abort_if(Gate::denies('checkout_delete', auth()->user()), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $this->checkoutReposity->delete($checkout->id);

        return response()
            ->json([
                'message' => 'Checkout deleted successfully',
                'status' => Response::HTTP_OK
            ], Response::HTTP_OK);
    }
}
