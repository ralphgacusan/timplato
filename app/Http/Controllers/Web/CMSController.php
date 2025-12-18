<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Page;
use App\Models\TeamMember;
use App\Models\Banner;

class CMSController extends Controller
{
    // Display CMS page
    public function index()
    {
        $pages = Page::all();
        $teamMembers = TeamMember::all();
        $banners = Banner::all();

        return view('admin.content-management', compact('pages', 'teamMembers', 'banners'));
    }

    // ===== PAGES =====
 public function storePage(Request $request)
{
    $request->validate([
        'title' => 'required|string|max:255',
        'slug' => 'required|string|max:255',
        'content' => 'required|string',
        'section' => 'nullable|string|max:255',
        'order' => 'nullable|integer',
    ]);

    Page::create([
        'title' => $request->title,
        'slug' => $request->slug,
        'content' => $request->content,
        'section' => $request->section ?? 'main',
        'order' => $request->order ?? 0,
    ]);

    return redirect()->route('admin.cms')->with('success', 'Page created successfully.');
}

public function updatePage(Request $request, Page $page)
{
    $request->validate([
        'title' => 'required|string|max:255',
        'slug' => 'required|string|max:255',
        'content' => 'required|string',
        'section' => 'nullable|string|max:255',
        'order' => 'nullable|integer',
    ]);

    $page->update([
        'title' => $request->title,
        'slug' => $request->slug,
        'content' => $request->content,
        'section' => $request->section ?? 'main',
        'order' => $request->order ?? 0,
    ]);

    return redirect()->route('admin.cms')->with('success', 'Page updated successfully.');
}

    public function destroyPage(Page $page)
    {
        $page->delete();
        return redirect()->route('admin.cms')->with('success', 'Page deleted successfully.');
    }

    // ===== TEAM MEMBERS =====
    public function storeTeam(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'image' => 'required|image|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('team_members'), $fileName);
            $imagePath = 'team_members/' . $fileName;
        }

        TeamMember::create([
            'name' => $request->name,
            'title' => $request->title,
            'image' => $imagePath,
        ]);

        return redirect()->route('admin.cms')->with('success', 'Team member added.');
    }

    public function updateTeam(Request $request, TeamMember $teamMember)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'image' => 'nullable|image|max:2048',
        ]);

        $data = $request->only(['name', 'title']);

        if ($request->hasFile('image')) {
            if ($teamMember->image && file_exists(public_path($teamMember->image))) {
                unlink(public_path($teamMember->image));
            }
            $file = $request->file('image');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('team_members'), $fileName);
            $data['image'] = 'team_members/' . $fileName;
        }

        $teamMember->update($data);

        return redirect()->route('admin.cms')->with('success', 'Team member updated.');
    }

    public function destroyTeam(TeamMember $teamMember)
    {
        if ($teamMember->image && file_exists(public_path($teamMember->image))) {
            unlink(public_path($teamMember->image));
        }

        $teamMember->delete();
        return redirect()->route('admin.cms')->with('success', 'Team member deleted.');
    }

// ===== BANNERS =====
public function storeBanner(Request $request)
{
    $request->validate([
        'title' => 'required|string|max:255',
        'image' => 'required|image|max:2048',
        'link' => 'nullable|url',
        'slug' => 'nullable|string|max:255', // NEW
        'section' => 'nullable|string|max:255',
        'order' => 'nullable|integer',
    ]);

    $imagePath = null;
    if ($request->hasFile('image')) {
        $file = $request->file('image');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('banners'), $fileName);
        $imagePath = 'banners/' . $fileName;
    }

    Banner::create([
       'title' => $request->title,
        'image' => $imagePath,
        'link' => $request->link,
        'slug' => $request->slug, // NEW
        'section' => $request->section ?? 'main',
        'order' => $request->order ?? 0,
        'active' => $request->has('active'),
    ]);

    return redirect()->route('admin.cms')->with('success', 'Banner added.');
}

public function updateBanner(Request $request, Banner $banner)
{
    $request->validate([
        'title' => 'required|string|max:255',
        'image' => 'nullable|image|max:2048', // make image optional
        'link' => 'nullable|url',
        'slug' => 'nullable|string|max:255',
        'section' => 'nullable|string|max:255',
        'order' => 'nullable|integer',
    ]);

    $data = $request->only(['title', 'link', 'slug', 'section', 'order']);

    // Fix active: checkbox may not be sent if unchecked
    $data['active'] = $request->has('active');

    // Only update image if a new file was uploaded
    if ($request->hasFile('image')) {
        if ($banner->image && file_exists(public_path($banner->image))) {
            unlink(public_path($banner->image));
        }
        $file = $request->file('image');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('banners'), $fileName);
        $data['image'] = 'banners/' . $fileName;
    }

    $banner->update($data);

    return redirect()->route('admin.cms')->with('success', 'Banner updated.');
}


public function destroyBanner(Banner $banner)
{
    if ($banner->image && file_exists(public_path($banner->image))) {
        unlink(public_path($banner->image));
    }

    $banner->delete();
    return redirect()->route('admin.cms')->with('success', 'Banner deleted.');
}

}
