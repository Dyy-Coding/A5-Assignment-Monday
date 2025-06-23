<?php

namespace App\Http\Controllers;

use App\Models\AuthorModel;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    /**
     * Display a listing of all authors.
     */
    public function index()
    {
        // Fetch all authors from the database using the model
        $authors = new AuthorModel();

        // Return JSON response with all authors and success message
        return response()->json([
            "message" => "Get data successful.",
            "data" => $authors::all()
        ], 200);
    }

    /**
     * Create a new author record.
     * This handles the creation logic (usually used with POST).
     */
    public function create(Request $request)
    {
        // Create a new author record using request data
        $authors = AuthorModel::create([
            'name' => $request->name,
            'dateofbirth' => $request->dateofbirth,
            'nationality' => $request->nationality,
            'numberOfWrittenBook' => $request->numberOfWrittenBook
        ]);

        // Check if creation failed, return error if yes
        if (!$authors) {
            return response()->json([
                "message" => "Create data fail."
            ], 500);
        } else {
            // Successfully created - return success message with author data
            return response()->json([
                'message' => 'Author created successfully.',
                'data' => $authors
            ], 201);
        }
    }

    /**
     * Store method is currently unused.
     * Usually used to store new resource after validation.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display a specific author by ID.
     */
    public function show($id)
    {
        // Find author by primary key or fail with 404
        $author = AuthorModel::findOrFail($id);

        // Return JSON with author data and success message
        return response()->json([
            "message" => "Get author successful.",
            "data" => $author
        ]);
    }

    /**
     * Edit method currently unused.
     * Usually to show form for editing resource.
     */
    public function edit(AuthorModel $authorModel)
    {
        //
    }

    /**
     * Update an existing author record by ID.
     */
    public function update(Request $request, $id)
    {
        // Find the author to update by ID
        $authors = AuthorModel::find($id);

        // Update author fields from request data
        $authors->update([
            'name' => $request->name,
            'dateofbirth' => $request->dateofbirth,
            'nationality' => $request->nationality,
            'numberOfWrittenBook' => $request->numberOfWrittenBook
        ]);

        // If update failed, return error response
        if (!$authors) {
            return response()->json([
                "message" => "Update data fail."
            ], 500);
        } else {
            // Return success message and updated author data
            return response()->json([
                'message' => 'Author updated successfully.',
                'data' => $authors
            ], 201);
        }
    }

    /**
     * Delete an author record by ID.
     */
    public function destroy($id)
    {
        // Find the author by ID
        $author = AuthorModel::find($id);

        // If author not found, return 404 response
        if (!$author) {
            return response()->json(['message' => 'Author not found.'], 404);
        }

        // Delete the author record
        $author->delete();

        // Return success message
        return response()->json([
            'message' => 'Author deleted successfully.',
        ]);
    }
}
