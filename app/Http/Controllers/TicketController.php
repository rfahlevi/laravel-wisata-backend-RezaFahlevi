<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Akaunting\Money\Money;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\TicketCategory;
use App\Http\Requests\TicketRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Builder;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $tickets = Ticket::with('ticketCategory')->paginate(10);

        // Convert price to IDR
        foreach ($tickets as $ticket) {
            $ticket->price = Money::IDR($ticket->price, true);
        }

        // Mencari tiket berdasarkan nama tiket atau kategorinya
        if ($request->has('ticket_search')) {
            $tickets = Ticket::with('ticketCategory')
                ->where('name', 'like', '%' . $request->ticket_search . '%')
                ->orWhereHas('ticketCategory', function ($query) use ($request) {
                    $query->where('name', 'like', '%' . $request->ticket_search . '%');
                })
                ->paginate(10);
        }

        $data = [];
        $data['type_menu'] = 'ticket';
        $data['tickets'] = $tickets;

        return view('pages.ticket.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $ticketCategories = TicketCategory::all();

        $data = [];
        $data['ticketCategories'] = $ticketCategories;
        $data['type_menu'] = 'ticket';

        return view('pages.ticket.add', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TicketRequest $request)
    {
        $data = $request->validated();
        $data['slug'] = Str::slug($data['name']) . '-' . Str::lower(Str::random(10));

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $image->storeAs('public/tickets', $image->hashName());
            $data['image'] = $image->hashName();
        }

        Ticket::create($data);

        return redirect()
            ->route('tickets.index')
            ->with('success', 'Berhasil menambahkan tiket : ' . $data['name']);
    }

    /**
     * Display the specified resource.
     */
    public function show($slug)
    {
        $ticket = Ticket::where('slug', $slug)->firstOrFail();
        $ticket->price = Money::IDR($ticket->price, true);

        $data = [];
        $data['ticket'] = $ticket;
        $data['type_menu'] = 'ticket';

        return view('pages.ticket.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($slug)
    {
        $ticketCategories = TicketCategory::all();
        $ticket = Ticket::where('slug', $slug)->firstOrFail();

        $data = [];
        $data['ticket'] = $ticket;
        $data['ticketCategories'] = $ticketCategories;
        $data['type_menu'] = 'ticket';

        return view('pages.ticket.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TicketRequest $request, $slug)
    {
        $data = $request->validated();
        $data['slug'] = Str::slug($data['name']) . '-' . Str::lower(Str::random(10));

        $ticket = Ticket::where('slug', $slug)->firstOrFail();

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            // Upload Foto Baru
            $image->storeAs('public/tickets', $image->hashName());
            $data['image'] = $image->hashName();

            // Hapus foto lama
            Storage::delete('public/tickets/' . basename($ticket->image));
        }

        $ticket->update($data);

        return redirect()
            ->route('tickets.index')
            ->with('success', 'Berhasil mengupdate tiket : ' . $data['name']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($slug)
    {
        $ticket = Ticket::where('slug', $slug)->firstOrFail();
        Storage::delete('public/tickets/' . basename($ticket->image));
        $ticket->delete();

        return redirect()
            ->route('tickets.index')
            ->with('success', 'Berhasil menghapus tiket : ' . $ticket->name);
    }
}
