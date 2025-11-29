<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Content;
use App\Models\Cast;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CastController extends Controller
{
    /**
     * Get cast members for a content
     */
    public function index(Content $content)
    {
        $cast = $content->casts()->withPivot('character', 'order')->orderByPivot('order', 'asc')->get();
        
        // Transform to format expected by frontend
        $castArray = $cast->map(function($castMember) {
            return [
                'id' => $castMember->id,
                'name' => $castMember->name,
                'character' => $castMember->pivot->character ?? '',
                'profile_path' => $castMember->profile_path,
                'order' => $castMember->pivot->order ?? 0,
            ];
        })->toArray();
        
        return response()->json(['cast' => $castArray]);
    }

    /**
     * Search for existing cast members
     */
    public function search(Request $request)
    {
        $query = $request->get('q', '');
        
        if (empty($query)) {
            return response()->json(['cast' => []]);
        }
        
        $casts = Cast::where('name', 'like', '%' . $query . '%')
            ->orderBy('name')
            ->limit(10)
            ->get();
        
        return response()->json(['cast' => $casts]);
    }

    /**
     * Store a new cast member or link existing one
     */
    public function store(Request $request, Content $content)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'character' => 'nullable|string|max:255',
            'profile_path' => 'nullable|string|max:500',
            'order' => 'nullable|integer|min:0',
            'cast_id' => 'nullable|integer|exists:casts,id', // If providing existing cast ID
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        // Check if cast_id is provided (existing cast)
        if ($request->cast_id) {
            $cast = Cast::find($request->cast_id);
            if (!$cast) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cast member not found.'
                ], 404);
            }
        } else {
            // Check if cast with same name already exists
            $cast = Cast::where('name', $request->name)->first();
            
            // If doesn't exist, create new cast member
            if (!$cast) {
                $cast = Cast::create([
                    'name' => $request->name,
                    'profile_path' => $request->profile_path ?? null,
                ]);
            } else {
                // Update profile_path if provided and current is empty
                if ($request->profile_path && empty($cast->profile_path)) {
                    $cast->update(['profile_path' => $request->profile_path]);
                }
            }
        }

        // Check if cast is already attached to this content
        $existingPivot = $content->casts()->where('casts.id', $cast->id)->first();
        
        if ($existingPivot) {
            return response()->json([
                'success' => false,
                'message' => 'Cast member is already added to this content.'
            ], 422);
        }

        // Attach cast to content with character and order
        $order = $request->order ?? ($content->casts()->count());
        $content->casts()->attach($cast->id, [
            'character' => $request->character ?? '',
            'order' => $order,
        ]);

        // Get updated cast list
        $castList = $content->casts()->withPivot('character', 'order')->orderByPivot('order', 'asc')->get();
        $castArray = $castList->map(function($castMember) {
            return [
                'id' => $castMember->id,
                'name' => $castMember->name,
                'character' => $castMember->pivot->character ?? '',
                'profile_path' => $castMember->profile_path,
                'order' => $castMember->pivot->order ?? 0,
            ];
        })->toArray();

        return response()->json([
            'success' => true,
            'message' => 'Cast member added successfully.',
            'cast' => $castArray
        ]);
    }

    /**
     * Update a cast member's role in content
     */
    public function update(Request $request, Content $content, $castId)
    {
        $validator = Validator::make($request->all(), [
            'character' => 'nullable|string|max:255',
            'order' => 'nullable|integer|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        // Check if cast is attached to this content
        $cast = $content->casts()->where('casts.id', $castId)->first();
        
        if (!$cast) {
            return response()->json([
                'success' => false,
                'message' => 'Cast member not found in this content.'
            ], 404);
        }

        // Update pivot data
        $content->casts()->updateExistingPivot($castId, [
            'character' => $request->character ?? '',
            'order' => $request->order ?? $cast->pivot->order ?? 0,
        ]);

        // Get updated cast list
        $castList = $content->casts()->withPivot('character', 'order')->orderByPivot('order', 'asc')->get();
        $castArray = $castList->map(function($castMember) {
            return [
                'id' => $castMember->id,
                'name' => $castMember->name,
                'character' => $castMember->pivot->character ?? '',
                'profile_path' => $castMember->profile_path,
                'order' => $castMember->pivot->order ?? 0,
            ];
        })->toArray();

        return response()->json([
            'success' => true,
            'message' => 'Cast member updated successfully.',
            'cast' => $castArray
        ]);
    }

    /**
     * Detach a cast member from content (doesn't delete the cast, just removes from this content)
     */
    public function destroy(Content $content, $castId)
    {
        // Check if cast is attached to this content
        $cast = $content->casts()->where('casts.id', $castId)->first();
        
        if (!$cast) {
            return response()->json([
                'success' => false,
                'message' => 'Cast member not found in this content.'
            ], 404);
        }

        // Detach cast from content (doesn't delete the cast member itself)
        $content->casts()->detach($castId);

        // Get updated cast list
        $castList = $content->casts()->withPivot('character', 'order')->orderByPivot('order', 'asc')->get();
        $castArray = $castList->map(function($castMember) {
            return [
                'id' => $castMember->id,
                'name' => $castMember->name,
                'character' => $castMember->pivot->character ?? '',
                'profile_path' => $castMember->profile_path,
                'order' => $castMember->pivot->order ?? 0,
            ];
        })->toArray();

        return response()->json([
            'success' => true,
            'message' => 'Cast member removed from content successfully.',
            'cast' => $castArray
        ]);
    }

    /**
     * Reorder cast members
     */
    public function reorder(Request $request, Content $content)
    {
        $validator = Validator::make($request->all(), [
            'cast_ids' => 'required|array',
            'cast_ids.*' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $castIds = $request->cast_ids;
        
        // Update order for each cast member
        foreach ($castIds as $index => $castId) {
            $content->casts()->updateExistingPivot($castId, [
                'order' => $index,
            ]);
        }

        // Get updated cast list
        $castList = $content->casts()->withPivot('character', 'order')->orderByPivot('order', 'asc')->get();
        $castArray = $castList->map(function($castMember) {
            return [
                'id' => $castMember->id,
                'name' => $castMember->name,
                'character' => $castMember->pivot->character ?? '',
                'profile_path' => $castMember->profile_path,
                'order' => $castMember->pivot->order ?? 0,
            ];
        })->toArray();

        return response()->json([
            'success' => true,
            'message' => 'Cast members reordered successfully.',
            'cast' => $castArray
        ]);
    }
}

