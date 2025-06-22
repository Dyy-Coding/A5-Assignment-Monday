<?php

namespace App\Http\Controllers;

use App\Models\Books;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class BookController extends Controller
{
    /**
     * Display a listing of all books.
     */
    public function index()
    {
        $books = Books::all();

        // Append full URL to images for each book
        $books->each(function ($book) {
            $book->image_url = $book->image ? asset($book->image) : null;
        });

        return response()->json([
            "message" => "Books fetched successfully",
            "books" => $books
        ], 200);
    }

    /**
     * Display the specified book by ID.
     */
    public function show($id)
    {
        $book = Books::find($id);

        if (!$book) {
            return response()->json(["message" => "Book not found"], 404);
        }

        // Append full URL to image
        $book->image_url = $book->image ? asset($book->image) : null;

        return response()->json([
            "data" => $book
        ], 200);
    }

    /**
     * Store a newly created book in storage.
     */
      // Create method
    public function create(Request $request)
    {
        try {
            $validated = $request->validate([
                'isbn' => 'required|string|unique:books,isbn',
                'title' => 'required|string|max:150',
                'author' => 'required|string|max:150',
                'publication_year' => 'required|integer',
                'number_of_copies' => 'required|integer',
                'category' => 'required|string|max:100',
                'priority' => 'required|in:Low,Medium,High',
                'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            ]);

            $imagePath = null;

            if ($request->hasFile('image')) {
                $filename = Str::uuid() . '.' . $request->file('image')->getClientOriginalExtension();
                $request->file('image')->move(public_path('images/books'), $filename);
                $imagePath = 'images/books/' . $filename;
            }

            $book = Books::create([
                'isbn' => $validated['isbn'],
                'title' => $validated['title'],
                'author' => $validated['author'],
                'publication_year' => $validated['publication_year'],
                'number_of_copies' => $validated['number_of_copies'],
                'category' => $validated['category'],
                'priority' => $validated['priority'],
                'image' => $imagePath,
            ]);

            return response()->json([
                "message" => "Book created successfully",
                "data" => $book
            ], 201);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            Log::error('Error creating book: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to create book', 'message' => $e->getMessage()], 500);
        }
    }
    

    /**
     * Update the specified book in storage.
     */
    public function update(Request $request, $id)
    {
        $book = Books::find($id);

        if (!$book) {
            return response()->json(["message" => "Book not found"], 404);
        }

        $request->validate([
            'isbn' => 'required|string|unique:books,isbn,' . $id,
            'title' => 'required|string|max:150',
            'author' => 'required|string|max:150',
            'publication_year' => 'required|integer',
            'number_of_copies' => 'required|integer',
            'category' => 'required|string|max:100',
            'priority' => 'required|in:Low,Medium,High',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($book->image && file_exists(public_path($book->image))) {
                unlink(public_path($book->image));
            }

            // Save new image manually
            $filename = Str::uuid() . '.' . $request->file('image')->getClientOriginalExtension();
            $request->file('image')->move(public_path('images/books'), $filename);
            $book->image = 'images/books/' . $filename;
        }

        $book->update($request->only([
            'isbn', 'title', 'author', 'publication_year', 'number_of_copies', 'category', 'priority'
        ]));

        // Refresh model to get latest data
        $book->refresh();

        return response()->json([
            "message" => "Book updated successfully",
            "data" => $book
        ], 200);
    }

    /**
     * Remove the specified book from storage.
     */
    public function destroy($id)
    {
        $book = Books::find($id);

        if (!$book) {
            return response()->json(["message" => "Book not found"], 404);
        }

        // Delete image if exists
        if ($book->image && file_exists(public_path($book->image))) {
            unlink(public_path($book->image));
        }

        $book->delete();

        return response()->json(["message" => "Book deleted successfully"], 200);
    }
}
