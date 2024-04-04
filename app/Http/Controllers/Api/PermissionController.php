<?php

namespace App\Http\Controllers\Api;

use Gate;
use App\Models\Permission;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\PermissionResource;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\PermissionReposityInterface;

class PermissionController extends Controller
{
    private $permissionReposity;

    public function __construct(PermissionReposityInterface $permissionReposity)
    {
        $this->permissionReposity = $permissionReposity;
    }

    public function index()
    {
        abort_if(Gate::denies('permission_access', auth()->user()), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $permissions = $this->permissionReposity->all();

        return response()
            ->json([
                'data' => PermissionResource::collection($permissions),
                'status' => Response::HTTP_OK
            ], Response::HTTP_OK);
    }

    public function show(Permission $permission)
    {
        abort_if(Gate::denies('permission_show', auth()->user()), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $permission = $this->permissionReposity->find($permission->id);

        return response()
            ->json([
                'data' => new PermissionResource($permission),
                'status' => Response::HTTP_OK
            ], Response::HTTP_OK);
    }

    public function store(Request $request)
    {
        abort_if(Gate::denies('permission_create', auth()->user()), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $request->validate([
            'title' => 'required|string',
        ]);

        $permission = $this->permissionReposity->create($request->all());

        return response()
            ->json([
                'data' => new PermissionResource($permission),
                'message' => 'Permission created successfully',
                'status' => Response::HTTP_OK
            ], Response::HTTP_OK);
    }

    public function update(Request $request, Permission $permission)
    {
        abort_if(Gate::denies('permission_edit', auth()->user()), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $request->validate([
            'title' => 'required|string',
        ]);

        $permission = $this->permissionReposity->update($request->all(), $permission->id);

        return response()
            ->json([
                'data' => new PermissionResource($permission),
                'message' => 'Permission updated successfully',
                'status' => Response::HTTP_OK
            ], Response::HTTP_OK);
    }

    public function destroy(Permission $permission)
    {
        abort_if(Gate::denies('permission_delete', auth()->user()), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $this->permissionReposity->delete($permission->id);

        return response()
            ->json([
                'message' => 'Permission deleted successfully',
                'status' => Response::HTTP_OK
            ], Response::HTTP_OK);
    }
}
