<?php

namespace App\Repository\Eloquent;

use Illuminate\Support\Str;
use App\Models\LibrarySetting;
use App\Repository\LibrarySettingReposityInterface;

class LibrarySettingReposity implements LibrarySettingReposityInterface
{
    protected $library;
    function __construct(LibrarySetting $library)
    {
        $this->library = $library;
    }

    public function all()
    {
        return $this->library->all();
    }

    public function find($id)
    {
        return $this->library->findOrFail($id);
    }

    public function create(array $attributes)
    {
        return $this->library->create($attributes);
    }

    public function update(array $attributes, $id)
    {
        $library = $this->library->findOrFail($id);
        $library->update($attributes);
        return $library;
    }

    public function delete($id)
    {
        $library = $this->library->findOrFail($id);
        $library->delete();
    }
}
