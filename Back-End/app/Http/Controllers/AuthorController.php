<?php

namespace App\Http\Controllers;

use App\Models\AuthorModel;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AuthorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $authors = AuthorModel::all()->map(function ($author) {
            $author->image_url = $author->image ? url($author->image) : null;
            return $author;
        });

        return response()->json([
            "message" => "Get data successful.",
            "data" => $authors
        ], 200);
    }

    /**
     * Create a new author and handle image upload.
     */

public function create(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:50',
        'dateofbirth' => 'required|date',
        'nationality' => 'required|string|max:100',
        'numberOfWrittenBook' => 'required|integer',
        'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    $filename = null;
    // if ($request->hasFile('image')) {
    //     $file = $request->file('image');
    //     $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
    //     $file->move(public_path('images/authors'), $filename);
    // }

    $author = AuthorModel::create([
        'name' => $request->name,
        'dateofbirth' => $request->dateofbirth,
        'nationality' => $request->nationality,
        'numberOfWrittenBook' => $request->numberOfWrittenBook,
        'image' => $filename, // store filename only
    ]);

    // Append image_url attribute dynamically
    $author->image_url = $author->image ? url('images/authors/' . $author->image) : null;

    return response()->json([
        'message' => 'Author created successfully.',
        'data' => $author,
    ], 201);
}


    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $author = AuthorModel::findOrFail($id);
        $author->image_url = $author->image ? url($author->image) : null;

        return response()->json([
            "message" => "Get author successful.",
            "data" => $author
        ]);
    }

    /**
     * Update an existing author and optionally update image.
     */
    public function update(Request $request, $id)
    {
        $author = AuthorModel::find($id);

        if (!$author) {
            return response()->json([
                "message" => "Author not found."
            ], 404);
        }

        $request->validate([
            'name' => 'required|string|max:50',
            'dateofbirth' => 'required|date',
            'nationality' => 'required|string|max:100',
            'numberOfWrittenBook' => 'required|integer',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        if ($request->hasFile('image')) {
            if ($author->image && file_exists(public_path($author->image))) {
                unlink(public_path($author->image));
            }

            $filename = Str::uuid() . '.' . $request->file('image')->getClientOriginalExtension();
            $request->file('image')->move(public_path('images/authors'), $filename);
            $author->image = 'images/authors/' . $filename;
        }

        $author->update([
            'name' => $request->name,
            'dateofbirth' => $request->dateofbirth,
            'nationality' => $request->nationality,
            'numberOfWrittenBook' => $request->numberOfWrittenBook,
            'image' => $author->image
        ]);

        $author->image_url = $author->image ? url($author->image) : null;

        return response()->json([
            'message' => 'Author updated successfully.',
            'data' => $author
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $author = AuthorModel::find($id);

        if (!$author) {
            return response()->json(['message' => 'Author not found.'], 404);
        }

        if ($author->image && file_exists(public_path($author->image))) {
            unlink(public_path($author->image));
        }

        $author->delete();

        return response()->json([
            'message' => 'Author deleted successfully.'
        ]);
    }
}
