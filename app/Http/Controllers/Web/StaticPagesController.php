<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Page;
use App\Models\Banner;
use App\Models\TeamMember;

class StaticPagesController extends Controller
{
public function aboutUsPage()
{
    $aboutPage = Page::where('slug', 'about-us')->first();
    $teamMembers = TeamMember::all();

    // Only active banners for this page or global banners
    $banners = Banner::where(function($query) use ($aboutPage) {
        $query->where('slug', $aboutPage->slug)
              ->orWhereNull('slug');
    })->where('active', true)->orderBy('order')->get();

    return view('customer.about-us', compact('aboutPage', 'teamMembers', 'banners'));
}


    
    public function contactPage(){
    $contactPage = Page::where('slug', 'contact-us')->first();
    $sections = Page::where('slug', 'contact-us')->get()->keyBy('section');        
    return view('customer.contact', compact('sections', 'contactPage'));
    }


public function privacyPolicyPage()
{
    $privacyPage = Page::where('slug', 'privacy-policy')->first();
    $sections = Page::where('slug', 'privacy-policy')->get()->keyBy('section');
    return view('customer.privacy-policy', compact('privacyPage', 'sections'));
}


public function customerSupportPage()
{
    // Fetch all sections related to this page
    $sections = Page::where('slug', 'customer-support')
        ->orderBy('order')
        ->get()
        ->groupBy('section'); // Group by section name (e.g., shop, general, payment, etc.)

    return view('customer.customer-support', compact('sections'));
}


}
