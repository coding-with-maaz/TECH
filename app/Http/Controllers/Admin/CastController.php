<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Content;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CastController extends Controller
{
    /**
     * Get cast members for a content
     */
    public function index(Content $content)
    {
        $cast = $content->cast ?? [];
        return response()->json(['cast' => $cast]);
    }

    /**
     * Store a new cast member
     */
    public function store(Request $request, Content $content)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'character' => 'nullable|string|max:255',
            'profile_path' => 'nullable|string|max:500',
            'order' => 'nullable|integer|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $cast = $content->cast ?? [];
        
        $newCastMember = [
            'id' => uniqid('cast_', true),
            'name' => $request->name,
            'character' => $request->character ?? '',
            'profile_path' => $request->profile_path ?? null,
            'order' => $request->order ?? count($cast),
        ];

        $cast[] = $newCastMember;
        
        // Sort by order
        usort($cast, function($a, $b) {
            return ($a['order'] ?? 999) - ($b['order'] ?? 999);
        });

        $content->cast = $cast;
        $content->save();

        return response()->json([
            'success' => true,
            'message' => 'Cast member added successfully.',
            'cast' => $cast
        ]);
    }

    /**
     * Update a cast member
     */
    public function update(Request $request, Content $content, $castId)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'character' => 'nullable|string|max:255',
            'profile_path' => 'nullable|string|max:500',
            'order' => 'nullable|integer|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $cast = $content->cast ?? [];
        
        $found = false;
        foreach ($cast as $index => $member) {
            if (isset($member['id']) && $member['id'] === $castId) {
                $cast[$index]['name'] = $request->name;
                $cast[$index]['character'] = $request->character ?? '';
                $cast[$index]['profile_path'] = $request->profile_path ?? null;
                $cast[$index]['order'] = $request->order ?? $member['order'] ?? $index;
                $found = true;
                break;
            }
        }

        if (!$found) {
            return response()->json([
                'success' => false,
                'message' => 'Cast member not found.'
            ], 404);
        }

        // Sort by order
        usort($cast, function($a, $b) {
            return ($a['order'] ?? 999) - ($b['order'] ?? 999);
        });

        $content->cast = $cast;
        $content->save();

        return response()->json([
            'success' => true,
            'message' => 'Cast member updated successfully.',
            'cast' => $cast
        ]);
    }

    /**
     * Delete a cast member
     */
    public function destroy(Content $content, $castId)
    {
        $cast = $content->cast ?? [];
        
        $found = false;
        foreach ($cast as $index => $member) {
            if (isset($member['id']) && $member['id'] === $castId) {
                unset($cast[$index]);
                $cast = array_values($cast); // Re-index array
                $found = true;
                break;
            }
        }

        if (!$found) {
            return response()->json([
                'success' => false,
                'message' => 'Cast member not found.'
            ], 404);
        }

        $content->cast = $cast;
        $content->save();

        return response()->json([
            'success' => true,
            'message' => 'Cast member deleted successfully.',
            'cast' => $cast
        ]);
    }

    /**
     * Reorder cast members
     */
    public function reorder(Request $request, Content $content)
    {
        $validator = Validator::make($request->all(), [
            'cast_ids' => 'required|array',
            'cast_ids.*' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $cast = $content->cast ?? [];
        $castIds = $request->cast_ids;
        
        // Create a map of cast IDs to their data
        $castMap = [];
        foreach ($cast as $member) {
            if (isset($member['id'])) {
                $castMap[$member['id']] = $member;
            }
        }

        // Reorder based on provided order
        $reorderedCast = [];
        foreach ($castIds as $index => $castId) {
            if (isset($castMap[$castId])) {
                $castMap[$castId]['order'] = $index;
                $reorderedCast[] = $castMap[$castId];
            }
        }

        // Add any remaining cast members that weren't in the reorder list
        foreach ($castMap as $castId => $member) {
            if (!in_array($castId, $castIds)) {
                $reorderedCast[] = $member;
            }
        }

        $content->cast = $reorderedCast;
        $content->save();

        return response()->json([
            'success' => true,
            'message' => 'Cast members reordered successfully.',
            'cast' => $reorderedCast
        ]);
    }
}

