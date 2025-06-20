<?php

namespace App\Http\Controllers;

use App\Models\AuthorModel;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index()

    {
        //
        $authors = new AuthorModel();
        return response()->json([
            "message" => "get data successful.",
             "data" => $authors::all()
        ],200);
    }

    /**
     * Show the form for creating a new resource.
     */
   public function create(Request $request)
    {
        //
        $authors = new AuthorModel();


        $authors = AuthorModel::create(
            [
            'name' => $request->name,
            'dateofbirth' => $request->dateofbirth,
            'nationality' => $request->nationality,
            'numberOfWrittenBook' => $request->numberOfWrittenBook
            ]
            
        );

        if (!$authors){
            return response()->json([
                "message" => "Create data fail."
            ],500);
        } else{
            return response()->json([
            'message' => 'Author created successful.',
            'data' => $authors
           ], 201);
        }

                // Return response
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
        $author = AuthorModel::findOrFail($id);
        return response()->json([
            "message" => "Get author successful.",
            "data" => $author
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AuthorModel $authorModel)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //
        //
        $authors = AuthorModel::find($id);


        $authors->update(
            [
            'name' => $request->name,
            'dateofbirth' => $request->dateofbirth,
            'nationality' => $request->nationality,
            'numberOfWrittenBook' => $request->numberOfWrittenBook
            ]
            
        );

        if (!$authors){
            return response()->json([
                "message" => "Update data fail."
            ],500);
        } else{
            return response()->json([
            'message' => 'Book updated.',
            'data' => $authors
           ], 201);
        }

                // Return response
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

        $author->delete();

        return response()->json([
            'message' => 'Author deleted successfully.',
        ]);
    }
}
