<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\TechnologyVersion;
use App\Http\Controllers\Controller;
use App\Http\Resources\TechnologyVersionResource;
use App\Http\Resources\TechnologyVersionCollection;
use App\Http\Requests\TechnologyVersionStoreRequest;
use App\Http\Requests\TechnologyVersionUpdateRequest;

class TechnologyVersionController extends Controller
{
    public function index(Request $request): TechnologyVersionCollection
    {
        $search = $request->get('search', '');

        $technologyVersions = $this->getSearchQuery($search)
            ->latest()
            ->paginate();

        return new TechnologyVersionCollection($technologyVersions);
    }

    public function store(
        TechnologyVersionStoreRequest $request
    ): TechnologyVersionResource {
        $validated = $request->validated();

        $technologyVersion = TechnologyVersion::create($validated);

        return new TechnologyVersionResource($technologyVersion);
    }

    public function show(
        Request $request,
        TechnologyVersion $technologyVersion
    ): TechnologyVersionResource {
        return new TechnologyVersionResource($technologyVersion);
    }

    public function update(
        TechnologyVersionUpdateRequest $request,
        TechnologyVersion $technologyVersion
    ): TechnologyVersionResource {
        $validated = $request->validated();

        $technologyVersion->update($validated);

        return new TechnologyVersionResource($technologyVersion);
    }

    public function destroy(
        Request $request,
        TechnologyVersion $technologyVersion
    ): Response {
        $technologyVersion->delete();

        return response()->noContent();
    }

    public function getSearchQuery(string $search)
    {
        return TechnologyVersion::query()->where(
            'version',
            'like',
            "%{$search}%"
        );
    }
}
