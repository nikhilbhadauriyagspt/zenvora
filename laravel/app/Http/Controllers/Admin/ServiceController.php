<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Service;
use App\Models\ServiceCategory;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $services = Service::with('category')->latest()->paginate(15);
        return view('admin.services.index', compact('services'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = ServiceCategory::orderBy('sort_order')->get();
        return view('admin.services.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:service_categories,id',
            'title' => 'required|string|max:150',
            'slug' => 'required|string|max:150|unique:services,slug',
            'tagline' => 'required|string|max:150',
            'description' => 'required|string',
            'starting_price' => 'required|string|max:50',
            'average_duration' => 'required|string|max:50',
            'hero_image' => 'required|string|max:255',
            'what_is_brief' => 'required|string',
            'docs_title' => 'nullable|string|max:255',
            'docs_subtitle' => 'nullable|string|max:255',
            'pillars_json' => 'required|array',
            'steps_json' => 'required|array',
            'deliverables_json' => 'required|array',
            'pricing_packages_json' => 'required|array',
            'faqs_json' => 'required|array',
            'docs_json' => 'nullable|array',
        ]);

        Service::create($validated);

        return redirect()->route('admin.services.index')->with('success', 'Service created successfully!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $service = Service::findOrFail($id);
        $categories = ServiceCategory::orderBy('sort_order')->get();
        return view('admin.services.edit', compact('service', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $service = Service::findOrFail($id);

        $validated = $request->validate([
            'category_id' => 'required|exists:service_categories,id',
            'title' => 'required|string|max:150',
            'slug' => 'required|string|max:150|unique:services,slug,' . $service->id,
            'tagline' => 'required|string|max:150',
            'description' => 'required|string',
            'starting_price' => 'required|string|max:50',
            'average_duration' => 'required|string|max:50',
            'hero_image' => 'required|string|max:255',
            'what_is_brief' => 'required|string',
            'docs_title' => 'nullable|string|max:255',
            'docs_subtitle' => 'nullable|string|max:255',
            'pillars_json' => 'required|array',
            'steps_json' => 'required|array',
            'deliverables_json' => 'required|array',
            'pricing_packages_json' => 'required|array',
            'faqs_json' => 'required|array',
            'docs_json' => 'nullable|array',
        ]);

        $service->update($validated);

        return redirect()->route('admin.services.index')->with('success', 'Service updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $service = Service::findOrFail($id);
        $service->delete();

        return redirect()->route('admin.services.index')->with('success', 'Service deleted successfully!');
    }
}
