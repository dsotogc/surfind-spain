<?php

namespace App\Http\Controllers;

use App\Models\Amenity;
use App\Models\Beach;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class BeachController extends Controller
{
    public function index(Request $request): View
    {
        $filters = $request->validate([
            'search' => ['nullable', 'string', 'max:255'],
            'location_id' => ['nullable', 'integer', 'exists:locations,id'],
            'difficulty' => ['nullable', Rule::in(['all', ...array_keys($this->difficulties())])],
            'amenities' => ['nullable', 'array'],
            'amenities.*' => ['integer', 'exists:amenities,id'],
            'sort' => ['nullable', Rule::in(['recent', 'comments', 'favorites', 'name'])],
        ]);

        $search = $filters['search'] ?? null;
        $locationId = $filters['location_id'] ?? null;
        $difficulty = $filters['difficulty'] ?? 'all';
        $selectedAmenities = collect($filters['amenities'] ?? [])->map(fn ($id) => (int) $id)->all();
        $sort = $filters['sort'] ?? 'recent';

        $beaches = Beach::query()
            ->where('status', 'published')
            ->with(['location', 'coverImage', 'amenities'])
            ->withCount([
                'comments as published_comments_count' => fn ($query) => $query->where('published', true),
                'favoritedByUsers',
            ])
            ->when($search, function ($query, string $search) {
                $query->where(function ($query) use ($search) {
                    $query
                        ->where('name', 'like', "%{$search}%")
                        ->orWhere('short_description', 'like', "%{$search}%")
                        ->orWhere('description', 'like', "%{$search}%");
                });
            })
            ->when($locationId, fn ($query) => $query->where('location_id', $locationId))
            ->when($difficulty !== 'all', fn ($query) => $query->where('difficulty', $difficulty))
            ->when($selectedAmenities !== [], function ($query) use ($selectedAmenities) {
                foreach ($selectedAmenities as $amenityId) {
                    $query->whereHas('amenities', fn ($query) => $query->where('amenities.id', $amenityId));
                }
            })
            ->when($sort === 'comments', fn ($query) => $query->orderByDesc('published_comments_count'))
            ->when($sort === 'favorites', fn ($query) => $query->orderByDesc('favorited_by_users_count'))
            ->when($sort === 'name', fn ($query) => $query->orderBy('name'))
            ->when($sort === 'recent', fn ($query) => $query->latest('published_at'))
            ->paginate(9)
            ->withQueryString();

        return view('beaches.index', [
            'beaches' => $beaches,
            'locations' => Location::orderBy('name')->get(),
            'amenities' => Amenity::orderBy('name')->get(),
            'difficulties' => $this->difficulties(),
            'search' => $search,
            'locationId' => $locationId,
            'difficulty' => $difficulty,
            'selectedAmenities' => $selectedAmenities,
            'sort' => $sort,
        ]);
    }

    public function show(Beach $beach): View
    {
        abort_unless($beach->status === 'published', 404);

        $beach->load(['location', 'coverImage', 'amenities', 'images'])
            ->loadCount([
                'comments as published_comments_count' => fn ($query) => $query->where('published', true),
                'favoritedByUsers',
                'images',
            ]);

        return view('beaches.show', [
            'beach' => $beach,
            'difficulties' => $this->difficulties(),
        ]);
    }

    private function difficulties(): array
    {
        return [
            'beginner' => 'Principiante',
            'intermediate' => 'Intermedia',
            'advanced' => 'Avanzada',
        ];
    }
}
