<?php

namespace App\Http\Controllers\Api;

use App\Models\Technology;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\TechnologyResource;
use App\Http\Resources\TechnologyCollection;
use App\Http\Requests\TechnologyStoreRequest;
use App\Http\Requests\TechnologyUpdateRequest;

class TechnologyController extends Controller
{
    public function index(Request $request): TechnologyCollection
    {
        $search = $request->get('search', '');

        $technologies = $this->getSearchQuery($search)
            ->latest()
            ->paginate();

        return new TechnologyCollection($technologies);
    }

    public function store(TechnologyStoreRequest $request): TechnologyResource
    {
        $validated = $request->validated();

        $technology = Technology::create($validated);

        return new TechnologyResource($technology);
    }

    public function show(
        Request $request,
        Technology $technology
    ): TechnologyResource {
        return new TechnologyResource($technology);
    }

    public function update(
        TechnologyUpdateRequest $request,
        Technology $technology
    ): TechnologyResource {
        $validated = $request->validated();

        $technology->update($validated);

        return new TechnologyResource($technology);
    }

    public function destroy(Request $request, Technology $technology): Response
    {
        $technology->delete();

        return response()->noContent();
    }

    public function getSearchQuery(string $search)
    {
        return Technology::query()->where('name', 'like', "%{$search}%");
    }
}
