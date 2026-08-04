<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ServiceCategory;
use App\Models\Service;
use App\Models\Blog;
use App\Models\Setting;
use App\Models\PricingPackage;

class FrontendController extends Controller
{
    /**
     * Homepage
     */
    public function index()
    {
        $settings = Setting::pluck('setting_value', 'setting_key')->toArray();
        $categories = ServiceCategory::with('services')->orderBy('sort_order')->get();
        $blogs = Blog::where('status', 'Published')->latest()->take(3)->get();
        $pricingPackages = PricingPackage::where('status', 'Active')->orderBy('sort_order')->get();

        return view('frontend.index', compact('settings', 'categories', 'blogs', 'pricingPackages'));
    }

    /**
     * About Us page
     */
    public function about()
    {
        $settings = Setting::pluck('setting_value', 'setting_key')->toArray();
        return view('frontend.about', compact('settings'));
    }

    /**
     * Services Catalog page
     */
    public function services()
    {
        $categories = ServiceCategory::with('services')->orderBy('sort_order')->get();
        return view('frontend.services', compact('categories'));
    }

    /**
     * Single Service detail page (e.g. private-limited-company)
     */
    public function serviceDetail($slug)
    {
        $service = Service::with('category')->where('slug', $slug)->firstOrFail();
        return view('frontend.service_detail', compact('service'));
    }

    /**
     * Platform details page
     */
    public function platformDetail($slug)
    {
        return view('frontend.platform_detail', compact('slug'));
    }

    /**
     * Blog index list
     */
    public function blog()
    {
        $blogs = Blog::where('status', 'Published')->latest()->paginate(9);
        return view('frontend.blog', compact('blogs'));
    }

    /**
     * Single Blog post details
     */
    public function blogDetail($slug)
    {
        $blog = Blog::where('slug', $slug)->firstOrFail();
        $recentBlogs = Blog::where('status', 'Published')
            ->where('id', '!=', $blog->id)
            ->latest()
            ->take(3)
            ->get();

        return view('frontend.blog_detail', compact('blog', 'recentBlogs'));
    }

    /**
     * Contact Us page
     */
    public function contact()
    {
        $settings = Setting::pluck('setting_value', 'setting_key')->toArray();
        return view('frontend.contact', compact('settings'));
    }

    /**
     * FAQ Directory page
     */
    public function faqs()
    {
        $settings = Setting::pluck('setting_value', 'setting_key')->toArray();
        return view('frontend.faqs', compact('settings'));
    }
}
