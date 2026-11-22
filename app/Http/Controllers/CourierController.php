<?php

namespace App\Http\Controllers;

use App\Models\Courier;
use App\Http\Requests\StoreCourierRequest;
use App\Http\Requests\UpdateCourierRequest;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class CourierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'search' => ['sometimes', 'string', 'max:255'],
            'level' => ['sometimes', 'string', 'regex:/^[1-5](,[1-5])*$/'],
            'sort' => ['sometimes', 'in:name,registered_at'],
            'direction' => ['sometimes', 'in:asc,desc'],
            'per_page' => ['sometimes', 'integer', 'between:1,100'],
        ]);

        $couriers = Courier::query()
            ->when($validated['search'] ?? null, function ($query, $search) {
                $terms = preg_split('/\s+/', trim(str_replace('+', ' ', $search)));
                foreach ($terms as $term) {
                    if ($term !== '') {
                        $query->where('name', 'like', '%' . $term . '%');
                    }
                }
            })
            ->when($validated['level'] ?? null, function ($query, $level) {
                $levels = array_map('intval', explode(',', $level));
                $query->whereIn('level', $levels);
            })
            ->orderBy(
                $validated['sort'] ?? 'name',
                $validated['direction'] ?? 'asc'
            )
            ->paginate($validated['per_page'] ?? 15)
            ->withQueryString();

        return response()->json($couriers);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCourierRequest $request): JsonResponse
    {
        $courier = Courier::create($request->validated());

        return response()->json($courier, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Courier $courier): JsonResponse
    {
        return response()->json($courier);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCourierRequest $request, Courier $courier): JsonResponse
    {
        $courier->update($request->validated());

        return response()->json($courier->fresh());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Courier $courier): Response
    {
        $courier->delete();

        return response()->noContent();
    }
}
