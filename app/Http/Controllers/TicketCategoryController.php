<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\TicketCategory;
use App\Http\Requests\TicketCategoryRequest;

class TicketCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $ticketCategories = TicketCategory::paginate(10);

        if($request->has('category_search'))
        {
            $ticketCategories = TicketCategory::where('name', 'like', '%' . $request->category_search . '%')
                                ->orWhere('description', 'like', '%' . $request->category_search . '%')
                                ->paginate(10);
        }

        $data = [];
        $data['type_menu'] = 'ticket_category';
        $data['ticketCategories'] = $ticketCategories;

        return view('pages.ticket-category.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.ticket-category.add', ['type_menu' => 'ticket_category']);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TicketCategoryRequest $request)
    {
        $data = $request->validated();
        $data['slug'] = Str::slug($data['name']) . '-' . Str::lower(Str::random(10));

        $newCategory = new TicketCategory();
        $newCategory->name = $data['name'];
        $newCategory->slug = $data['slug'];
        $newCategory->description = $data['description'];
        $newCategory->save();

        return redirect()->route('ticketCategories.index')->with('success', 'Berhasil menambahkan kategori baru : ' . $newCategory->name);
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit($slug)
    {
        $ticketCategory = TicketCategory::where('slug', $slug)->firstOrFail();
        $data = [];
        $data['type_menu'] = 'ticket_category';
        $data['ticketCategory'] = $ticketCategory;

        return view('pages.ticket-category.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TicketCategoryRequest $request, $slug)
    {
        $data = $request->validated();

        $category = TicketCategory::where('slug', $slug)->firstOrFail();
        $category->name = $data['name'];
        $category->slug = Str::slug($data['name']) . '-' . Str::lower(Str::random(10));
        $category->description = $data['description'];
        $category->save();

        return redirect()->route('ticketCategories.index')->with('success', 'Berhasil mengupdate kategori : ' . $category->name);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($slug)
    {
        $category = TicketCategory::where('slug', $slug)->firstOrFail();
        $category->delete();

        return redirect()->route('ticketCategories.index')->with('success', 'Berhasil menghapus kategori : ' . $category->name);
    }
}
