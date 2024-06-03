<?php

namespace App\Http\Controllers\Api;

use App\Models\Ticket;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\TicketRequest;
use App\Http\Resources\TicketResource;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $tickets = Ticket::with('ticketCategory')->paginate(10);

            // Mencari tiket berdasarkan nama tiket atau kategorinya
            if ($request->has('search')) {
                $tickets = Ticket::with('ticketCategory')
                    ->where('name', 'like', '%' . $request->search . '%')
                    ->orWhereHas('ticketCategory', function ($query) use ($request) {
                        $query->where('name', 'like', '%' . $request->search . '%');
                    })
                    ->paginate(10);
            }

            return response()->json(
                [
                    'status' => true,
                    'message' => 'Berhasil mendapatkan data tiket',
                    'data' => TicketResource::collection($tickets),
                    'total' => $tickets->total(),
                    'offset' => $tickets->perPage(),
                    'current_page' => $tickets->currentPage(),
                    'last_page' => $tickets->lastPage(),
                ],
                200,
            );
        } catch (\Throwable $th) {
            return response()->json(
                [
                    'status' => false,
                    'message' => $th->getMessage(),
                ],
                500,
            );
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TicketRequest $request)
    {
        try {
            $data = $request->validated();
            $data['slug'] = Str::slug($data['name']) . '-' . Str::lower(Str::random(10));

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $image->storeAs('public/tickets', $image->hashName());
                $data['image'] = $image->hashName();
            }

            $newTicket = Ticket::create($data);

            return response()->json(
                [
                    'status' => true,
                    'message' => 'Berhasil menambahkan data tiket',
                    'data' => new TicketResource($newTicket),
                ],
                201,
            );
        } catch (\Throwable $th) {
            return response()->json(
                [
                    'status' => false,
                    'message' => $th->getMessage(),
                ],
                500,
            );
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TicketRequest $request, $id)
    {
        try {
            $data = $request->validated();
            $data['slug'] = Str::slug($data['name']) . '-' . Str::lower(Str::random(10));

            $ticket = Ticket::where('id', $id)->firstOrFail();

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                // Upload Foto Baru
                $image->storeAs('public/tickets', $image->hashName());
                $data['image'] = $image->hashName();

                // Hapus foto lama
                Storage::delete('public/tickets/' . basename($ticket->image));
            }

            // Update tiket
            $ticket->update($data);

            return response()->json(
                [
                    'status' => true,
                    'message' => 'Berhasil mengupdate data tiket',
                    'data' => new TicketResource($ticket),
                ],
                200,
            );
        } catch (ModelNotFoundException $e) {
            return response()->json(
                [
                    'status' => false,
                    'message' => 'Data tiket tidak ditemukan',
                ],
                404,
            );
        } catch (\Throwable $th) {
            return response()->json(
                [
                    'status' => false,
                    'message' => $th->getMessage(),
                ],
                500,
            );
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $ticket = Ticket::where('id', $id)->firstOrFail();
            Storage::delete('public/tickets/' . basename($ticket->image));
            $ticket->delete();

            return response()->json(
                [
                    'status' => true,
                    'message' => 'Berhasil menghapus data tiket',
                ],
                200,
            );
        } catch (ModelNotFoundException $e) {
            return response()->json(
                [
                    'status' => false,
                    'message' => 'Data tiket tidak ditemukan',
                ],
                404,
            );
        } catch (\Throwable $th) {
            return response()->json(
                [
                    'status' => false,
                    'message' => $th->getMessage(),
                ],
                500,
            );
        }
    }
}
