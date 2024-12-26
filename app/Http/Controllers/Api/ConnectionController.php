<?php

namespace App\Http\Controllers\Api;

use App\Models\Connection;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\ConnectionResource;
use App\Http\Resources\ConnectionCollection;
use App\Http\Requests\ConnectionStoreRequest;
use App\Http\Requests\ConnectionUpdateRequest;

class ConnectionController extends Controller
{
    public function index(Request $request): ConnectionCollection
    {
        $search = $request->get('search', '');

        $connections = $this->getSearchQuery($search)
            ->latest()
            ->paginate();

        return new ConnectionCollection($connections);
    }

    public function store(ConnectionStoreRequest $request): ConnectionResource
    {
        $validated = $request->validated();

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        }

        $connection = Connection::create($validated);

        return new ConnectionResource($connection);
    }

    public function show(
        Request $request,
        Connection $connection
    ): ConnectionResource {
        return new ConnectionResource($connection);
    }

    public function update(
        ConnectionUpdateRequest $request,
        Connection $connection
    ): ConnectionResource {
        $validated = $request->validated();

        if (empty($validated['password'])) {
            unset($validated['password']);
        } else {
            $validated['password'] = Hash::make($validated['password']);
        }

        $connection->update($validated);

        return new ConnectionResource($connection);
    }

    public function destroy(Request $request, Connection $connection): Response
    {
        $connection->delete();

        return response()->noContent();
    }

    public function getSearchQuery(string $search)
    {
        return Connection::query()->where('name', 'like', "%{$search}%");
    }
}
