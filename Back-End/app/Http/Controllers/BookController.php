<?php

namespace App\Http\Controllers;

use App\Models\Books;
use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $book = new Books();
        return response()->json([
            "message"=>"Show all Book successfully",
            "Book"=>$book::all()
        ],200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $NewBook = Books::create([
            'image' => $request->image,
            'title' => $request->title,
            'Isnb' => $request->Isnb,
            'author' => $request->author,
            'Publication_years' => $request->Publication_years,
            'Number_of_Copies' => $request->Number_of_Copies,
            'Categories' => $request->Categories
        ]);
        if ($NewBook) {
            return response()->json([
                "message" => "Book created successfully",
                "book" => $NewBook
            ], 201);
        }
        return response()->json([
            "message" => "Failed to create book"
        ], 500);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $Updatebook = Books::where('id', $id)->update([
            'image' => $request->image,
            'title' => $request->title,
            'Isnb' => $request->Isnb,
            'author' => $request->author,
            'Publication_years' => $request->Publication_years,
            'Number_of_Copies' => $request->Number_of_Copies,
            'Categories' => $request->Categories
        ]);


        if($Updatebook){
            return response()->json([
                "message" => "Book updated successfully",
                "book" => $Updatebook
            ], 201);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $DeleteBook = Books::where('id', $id)->delete();
        if ($DeleteBook) {
            return response()->json([
            "message" => "Book deleted successfully"
        ], 200);
            
        }
        return response()->json([
            "message" => "Book not found"
        ], 404);
    }
}
