<?php

namespace App\Http\Controllers\Api;

use Gate;
use Illuminate\Http\Request;
use App\Models\LibrarySetting;
use App\Http\Controllers\Controller;
use App\Http\Resources\LibrarySettingResource;
use App\Repository\LibrarySettingReposityInterface;
use Symfony\Component\HttpFoundation\Response;

class LibrarySettingController extends Controller
{
    private $librarySettingReposity;

    public function __construct(LibrarySettingReposityInterface $librarySettingReposity)
    {
        $this->librarySettingReposity = $librarySettingReposity;
    }

    public function index()
    {
        abort_if(Gate::denies('library_setting_access', auth()->user()), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $libraries = $this->librarySettingReposity->all();

        return response()
            ->json([
                'data' => LibrarySettingResource::collection($libraries),
                'status' => Response::HTTP_OK
            ], Response::HTTP_OK);
    }

    public function show(LibrarySetting $library_setting)
    {
        abort_if(Gate::denies('library_setting_access', auth()->user()), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $library_setting = $this->librarySettingReposity->find($library_setting->id);

        return response()
            ->json([
                'data' => new LibrarySettingResource($library_setting),
                'status' => Response::HTTP_OK
            ], Response::HTTP_OK);
    }

    public function store(Request $request)
    {
        abort_if(Gate::denies('library_setting_access', auth()->user()), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $request->validate([
            'name' => 'required|string',
            'book_return_day_limit' => 'nullable|numeric',
            'late_return_one_day_fine' => 'nullable|numeric',
            'book_issue_limit' => 'nullable|numeric',
        ]);

        $library_setting = $this->librarySettingReposity->create($request->all());

        return response()
            ->json([
                'data' => new LibrarySettingResource($library_setting),
                'message' => 'Library setting created successfully',
                'status' => Response::HTTP_OK
            ], Response::HTTP_OK);
    }

    public function update(Request $request, librarySetting $library_setting)
    {
        abort_if(Gate::denies('library_setting_access', auth()->user()), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $request->validate([
            'name' => 'required|string',
            'book_return_day_limit' => 'nullable|numeric',
            'late_return_one_day_fine' => 'nullable|numeric',
            'book_issue_limit' => 'nullable|numeric',
        ]);

        $library_setting = $this->librarySettingReposity->update($request->all(), $library_setting->id);

        return response()
            ->json([
                'data' => new LibrarySettingResource($library_setting),
                'message' => 'Library setting updated successfully',
                'status' => Response::HTTP_OK
            ], Response::HTTP_OK);
    }

    public function destroy(LibrarySetting $library_setting)
    {
        abort_if(Gate::denies('library_setting_access', auth()->user()), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $this->librarySettingReposity->delete($library_setting->id);

        return response()
            ->json([
                'message' => 'Library setting deleted successfully',
                'status' => Response::HTTP_OK
            ], Response::HTTP_OK);
    }
}
