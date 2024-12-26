<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\ConnectionType;
use App\Http\Controllers\Controller;
use App\Http\Resources\ConnectionTypeResource;
use App\Http\Resources\ConnectionTypeCollection;
use App\Http\Requests\ConnectionTypeStoreRequest;
use App\Http\Requests\ConnectionTypeUpdateRequest;

class ConnectionTypeController extends Controller
{
    public function index(Request $request): ConnectionTypeCollection
    {
        $search = $request->get('search', '');

        $connectionTypes = $this->getSearchQuery($search)
            ->latest()
            ->paginate();

        return new ConnectionTypeCollection($connectionTypes);
    }

    public function store(
        ConnectionTypeStoreRequest $request
    ): ConnectionTypeResource {
        $validated = $request->validated();

        $connectionType = ConnectionType::create($validated);

        return new ConnectionTypeResource($connectionType);
    }

    public function show(
        Request $request,
        ConnectionType $connectionType
    ): ConnectionTypeResource {
        return new ConnectionTypeResource($connectionType);
    }

    public function update(
        ConnectionTypeUpdateRequest $request,
        ConnectionType $connectionType
    ): ConnectionTypeResource {
        $validated = $request->validated();

        $connectionType->update($validated);

        return new ConnectionTypeResource($connectionType);
    }

    public function destroy(
        Request $request,
        ConnectionType $connectionType
    ): Response {
        $connectionType->delete();

        return response()->noContent();
    }

    public function getSearchQuery(string $search)
    {
        return ConnectionType::query()->where('name', 'like', "%{$search}%");
    }
}
