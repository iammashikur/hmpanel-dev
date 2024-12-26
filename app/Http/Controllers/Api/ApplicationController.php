<?php

namespace App\Http\Controllers\Api;

use App\Models\Application;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\ApplicationResource;
use App\Http\Resources\ApplicationCollection;
use App\Http\Requests\ApplicationStoreRequest;
use App\Http\Requests\ApplicationUpdateRequest;

class ApplicationController extends Controller
{
    public function index(Request $request): ApplicationCollection
    {
        $search = $request->get('search', '');

        $applications = $this->getSearchQuery($search)
            ->latest()
            ->paginate();

        return new ApplicationCollection($applications);
    }

    public function store(ApplicationStoreRequest $request): ApplicationResource
    {
        $validated = $request->validated();

        $application = Application::create($validated);

        return new ApplicationResource($application);
    }

    public function show(
        Request $request,
        Application $application
    ): ApplicationResource {
        return new ApplicationResource($application);
    }

    public function update(
        ApplicationUpdateRequest $request,
        Application $application
    ): ApplicationResource {
        $validated = $request->validated();

        $application->update($validated);

        return new ApplicationResource($application);
    }

    public function destroy(
        Request $request,
        Application $application
    ): Response {
        $application->delete();

        return response()->noContent();
    }

    public function getSearchQuery(string $search)
    {
        return Application::query()->where('name', 'like', "%{$search}%");
    }
}
