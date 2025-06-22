<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Member;
use App\Models\Members;

class MembersController extends Controller
{
    /**
     * Display a listing of the members.
     */
    public function index()
    {
        return response()->json([
            "message" => "Request successful",
            "members" => Members::all()
        ], 200);
    }

    /**
     * Store a newly created member.
     */
    public function create(Request $request)
{
    $validated = $request->validate([
        'FirstName' => 'required|string|max:255',
        'LastName' => 'required|string|max:255',
        'Email' => 'required|email|unique:members',
        'Phone' => 'required|string',
        'Address' => 'required|string',
        'Image' => 'nullable|image|max:2048',  // max 2MB
    ]);

    if ($request->hasFile('Image')) {
        $path = $request->file('Image')->store('members', 'public');
        $validated['Image'] = $path;
    }

    $member = Members::create($validated);

    return response()->json([
        'message' => 'Member created successfully',
        'member' => $member,
    ], 201);
}


    /**
     * Display the specified member.
     */
    public function show(string $id)
    {
        $member = Members::find($id);

        if ($member) {
            return response()->json([
                "message" => "Member retrieved successfully",
                "member" => $member
            ], 200);
        }

        return response()->json([
            "message" => "Member not found"
        ], 404);
    }

    /**
     * Update the specified member.
     */
    public function update(Request $request, int $id)
    {
        $request->validate([
            'FirstName' => 'required|string',
            'LastName' => 'required|string',
            'Email' => 'required|email',
            'Phone' => 'required|string',
            'Address' => 'required|string',
            'Image' => 'nullable|string',
        ]);

        $member = Members::find($id);

        if (!$member) {
            return response()->json(["message" => "Member not found"], 404);
        }

        $member->update($request->all());

        return response()->json([
            "message" => "Member updated successfully",
            "member" => $member
        ], 200);
    }

    /**
     * Remove the specified member.
     */
    public function destroy(int $id)
    {
        $member = Members::find($id);

        if (!$member) {
            return response()->json([
                'message' => 'Member not found or already deleted'
            ], 404);
        }

        $member->delete();

        return response()->json([
            'message' => 'Member deleted successfully'
        ], 200);
    }
}
