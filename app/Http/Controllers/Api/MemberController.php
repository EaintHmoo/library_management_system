<?php

namespace App\Http\Controllers\Api;

use Gate;
use App\Models\Member;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\MemberResource;
use Illuminate\Validation\Rule;
use App\Repository\MemberReposityInterface;
use Symfony\Component\HttpFoundation\Response;

class MemberController extends Controller
{
    private $memberReposity;

    public function __construct(MemberReposityInterface $memberReposity)
    {
        $this->memberReposity = $memberReposity;
    }

    public function index()
    {
        abort_if(Gate::denies('member_access', auth()->user()), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $members = $this->memberReposity->all();

        return response()
            ->json([
                'data' => MemberResource::collection($members),
                'status' => Response::HTTP_OK
            ], Response::HTTP_OK);
    }

    public function show(Member $member)
    {
        abort_if(Gate::denies('member_show', auth()->user()), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $member = $this->memberReposity->find($member->id);

        return response()
            ->json([
                'data' => new MemberResource($member),
                'status' => Response::HTTP_OK
            ], Response::HTTP_OK);
    }

    public function store(Request $request)
    {
        abort_if(Gate::denies('member_create', auth()->user()), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $request->validate([
            'date_of_membership' => 'nullable|date',
            'date_of_birth' => 'nullable|date',
            'user_id' => 'required|integer',
        ]);

        $member = $this->memberReposity->create($request->all());

        return response()
            ->json([
                'data' => new MemberResource($member),
                'message' => 'Member created successfully',
                'status' => Response::HTTP_OK
            ], Response::HTTP_OK);
    }

    public function update(Request $request, Member $member)
    {
        abort_if(Gate::denies('member_edit', auth()->user()), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $request->validate([
            'date_of_membership' => 'nullable|date',
            'date_of_birth' => 'nullable|date',
            'user_id' => 'required|integer',
            'member_no' => [
                'required',
                'string',
                Rule::unique('members')->ignore($member->id),
            ],
        ]);

        $member = $this->memberReposity->update($request->all(), $member->id);

        return response()
            ->json([
                'data' => new MemberResource($member),
                'message' => 'Member updated successfully',
                'status' => Response::HTTP_OK
            ], Response::HTTP_OK);
    }

    public function destroy(Member $member)
    {
        abort_if(Gate::denies('member_delete', auth()->user()), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $this->memberReposity->delete($member->id);

        return response()
            ->json([
                'message' => 'Member deleted successfully',
                'status' => Response::HTTP_OK
            ], Response::HTTP_OK);
    }
}
