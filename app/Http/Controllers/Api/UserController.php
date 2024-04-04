<?php

namespace App\Http\Controllers\Api;

use Gate;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Repository\UserReposityInterface;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    private $userReposity;

    public function __construct(UserReposityInterface $userReposity)
    {
        $this->userReposity = $userReposity;
    }

    public function index()
    {
        abort_if(Gate::denies('user_access', auth()->user()), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = $this->userReposity->all();

        return response()
            ->json([
                'data' => UserResource::collection($users),
                'status' => Response::HTTP_OK
            ], Response::HTTP_OK);
    }

    public function show(User $user)
    {
        abort_if(Gate::denies('user_show', auth()->user()), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $user = $this->userReposity->find($user->id);

        return response()
            ->json([
                'data' => new UserResource($user),
                'status' => Response::HTTP_OK
            ], Response::HTTP_OK);
    }

    public function store(Request $request)
    {
        abort_if(Gate::denies('user_create', auth()->user()), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'roles.*' => 'integer',
            'roles' => 'required|array',
        ]);

        $user = $this->userReposity->create($request->all());

        return response()
            ->json([
                'data' => new UserResource($user),
                'message' => 'User created successfully',
                'status' => Response::HTTP_OK
            ], Response::HTTP_OK);
    }

    public function update(Request $request, User $user)
    {
        abort_if(Gate::denies('user_edit', auth()->user()), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $request->validate([
            'name' => 'required|string',
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore($user->id),
            ],
            'password' => 'min:6',
            'roles.*' => 'integer',
            'roles' => 'required|array',
        ]);

        $user = $this->userReposity->update($request->all(), $user->id);

        return response()
            ->json([
                'data' => new UserResource($user),
                'message' => 'User updated successfully',
                'status' => Response::HTTP_OK
            ], Response::HTTP_OK);
    }

    public function destroy(User $user)
    {
        abort_if(Gate::denies('user_delete', auth()->user()), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $this->userReposity->delete($user->id);

        return response()
            ->json([
                'message' => 'User deleted successfully',
                'status' => Response::HTTP_OK
            ], Response::HTTP_OK);
    }
}
