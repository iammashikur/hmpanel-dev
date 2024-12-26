<?php

namespace App\Http\Controllers\Api;

use App\Models\Database;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\DatabaseResource;
use App\Http\Resources\DatabaseCollection;
use App\Http\Requests\DatabaseStoreRequest;
use App\Http\Requests\DatabaseUpdateRequest;

class DatabaseController extends Controller
{
    public function index(Request $request): DatabaseCollection
    {
        $search = $request->get('search', '');

        $databases = $this->getSearchQuery($search)
            ->latest()
            ->paginate();

        return new DatabaseCollection($databases);
    }

    public function store(DatabaseStoreRequest $request): DatabaseResource
    {
        $validated = $request->validated();

        $validated['password'] = Hash::make($validated['password']);

        $database = Database::create($validated);

        return new DatabaseResource($database);
    }

    public function show(Request $request, Database $database): DatabaseResource
    {
        return new DatabaseResource($database);
    }

    public function update(
        DatabaseUpdateRequest $request,
        Database $database
    ): DatabaseResource {
        $validated = $request->validated();

        if (empty($validated['password'])) {
            unset($validated['password']);
        } else {
            $validated['password'] = Hash::make($validated['password']);
        }

        $database->update($validated);

        return new DatabaseResource($database);
    }

    public function destroy(Request $request, Database $database): Response
    {
        $database->delete();

        return response()->noContent();
    }

    public function getSearchQuery(string $search)
    {
        return Database::query()->where('name', 'like', "%{$search}%");
    }
}
