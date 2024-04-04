<?php

namespace App\Http\Controllers\Api;

use Gate;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\RoleResource;
use App\Models\Role;
use App\Repository\RoleReposityInterface;
use Symfony\Component\HttpFoundation\Response;

class RoleController extends Controller
{
    private $roleReposity;

    public function __construct(RoleReposityInterface $roleReposity)
    {
        $this->roleReposity = $roleReposity;
    }

    public function index()
    {
        abort_if(Gate::denies('role_access', auth()->user()), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $roles = $this->roleReposity->all();

        return response()
            ->json([
                'data' => RoleResource::collection($roles),
                'status' => Response::HTTP_OK
            ], Response::HTTP_OK);
    }

    public function show(Role $role)
    {
        abort_if(Gate::denies('role_show', auth()->user()), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $role = $this->roleReposity->find($role->id);

        return response()
            ->json([
                'data' => new RoleResource($role),
                'status' => Response::HTTP_OK
            ], Response::HTTP_OK);
    }

    public function store(Request $request)
    {
        abort_if(Gate::denies('role_create', auth()->user()), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $request->validate([
            'title' => 'required|string',
            'permissions.*' => 'integer',
            'permissions' => 'required|array',
        ]);

        $role = $this->roleReposity->create($request->all());

        return response()
            ->json([
                'data' => new RoleResource($role),
                'message' => 'Role created successfully',
                'status' => Response::HTTP_OK
            ], Response::HTTP_OK);
    }

    public function update(Request $request, Role $role)
    {
        abort_if(Gate::denies('role_edit', auth()->user()), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $request->validate([
            'title' => 'required|string',
            'permissions.*' => 'integer',
            'permissions' => 'required|array',
        ]);

        $role = $this->roleReposity->update($request->all(), $role->id);

        return response()
            ->json([
                'data' => new RoleResource($role),
                'message' => 'Role updated successfully',
                'status' => Response::HTTP_OK
            ], Response::HTTP_OK);
    }

    public function destroy(Role $role)
    {
        abort_if(Gate::denies('role_delete', auth()->user()), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $this->roleReposity->delete($role->id);

        return response()
            ->json([
                'message' => 'Role deleted successfully',
                'status' => Response::HTTP_OK
            ], Response::HTTP_OK);
    }
}
