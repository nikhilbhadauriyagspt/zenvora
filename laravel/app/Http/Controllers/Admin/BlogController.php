<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Blog;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $blogs = Blog::latest()->paginate(15);
        return view('admin.blogs.index', compact('blogs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.blogs.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:blogs,slug',
            'category' => 'required|string|max:100',
            'category_slug' => 'required|string|max:100',
            'date' => 'required|string|max:50',
            'author' => 'required|string|max:100',
            'author_role' => 'required|string|max:100',
            'author_avatar' => 'required|string|max:255',
            'read_time' => 'required|string|max:50',
            'image' => 'required|string|max:255',
            'excerpt' => 'required|string',
            'content' => 'required|string',
            'status' => 'required|string|in:Published,Draft',
        ]);

        Blog::create($validated);

        return redirect()->route('admin.blogs.index')->with('success', 'Blog created successfully!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $blog = Blog::findOrFail($id);
        return view('admin.blogs.edit', compact('blog'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $blog = Blog::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:blogs,slug,' . $blog->id,
            'category' => 'required|string|max:100',
            'category_slug' => 'required|string|max:100',
            'date' => 'required|string|max:50',
            'author' => 'required|string|max:100',
            'author_role' => 'required|string|max:100',
            'author_avatar' => 'required|string|max:255',
            'read_time' => 'required|string|max:50',
            'image' => 'required|string|max:255',
            'excerpt' => 'required|string',
            'content' => 'required|string',
            'status' => 'required|string|in:Published,Draft',
        ]);

        $blog->update($validated);

        return redirect()->route('admin.blogs.index')->with('success', 'Blog updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $blog = Blog::findOrFail($id);
        $blog->delete();

        return redirect()->route('admin.blogs.index')->with('success', 'Blog deleted successfully!');
    }
}
