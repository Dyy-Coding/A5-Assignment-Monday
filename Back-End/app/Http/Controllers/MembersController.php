<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Members;

class MembersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $members = new Members();
        return response()->json([
            "message" => "request successfully",
            "members" => $members::all()
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)

    {
        $Newmember = Members::create([
        "FirstName" => $request->FirstName,
        "LastName" => $request->LastName,
        "Email" => $request->Email,
        "Phone" => $request->Phone,
        "Address" => $request->Address,
    ]);

    if ($Newmember) {
        return response()->json([
            "message" => "Member created successfully",
            "member" => $Newmember
        ], 201);
    }

    return response()->json([
        "message" => "Failed to create member"
    ], 500);
    
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
