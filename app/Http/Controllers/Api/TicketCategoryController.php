<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\TicketCategory;
use App\Http\Controllers\Controller;
use App\Http\Requests\TicketCategoryRequest;
use App\Http\Resources\TicketCategoryResource;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class TicketCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $ticketCategories = TicketCategory::paginate(10);

            if ($request->has('search')) {
                $ticketCategories = TicketCategory::where('name', 'like', '%' . $request->search . '%')
                    ->orWhere('description', 'like', '%' . $request->search . '%')
                    ->paginate(10);
            }

            return response()->json(
                [
                    'success' => true,
                    'message' => 'Berhasil mendapatkan data kategori tiket',
                    'data' => TicketCategoryResource::collection($ticketCategories),
                    'total' => $ticketCategories->total(),
                    'offset' => $ticketCategories->perPage(),
                    'current_page' => $ticketCategories->currentPage(),
                    'last_page' => $ticketCategories->lastPage(),
                ],
                200,
            );
        } catch (\Throwable $th) {
            return response()->json(
                [
                    'success' => false,
                    'message' => $th->getMessage(),
                ],
                500,
            );
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TicketCategoryRequest $request)
    {
        try {
            $data = $request->validated();
            $data['slug'] = Str::slug($data['name']) . '-' . Str::lower(Str::random(10));

            $newCategory = new TicketCategory();
            $newCategory->name = $data['name'];
            $newCategory->slug = $data['slug'];
            $newCategory->description = $data['description'];
            $newCategory->save();

            return response()->json(
                [
                    'success' => true,
                    'message' => 'Berhasil menambahkan kategori tiket baru',
                    'data' => new TicketCategoryResource($newCategory),
                ],
                201,
            );
        } catch (\Throwable $th) {
            return response()->json(
                [
                    'success' => false,
                    'message' => $th->getMessage(),
                ],
                500,
            );
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TicketCategoryRequest $request, $id)
    {
        try {
            $data = $request->validated();

            $category = TicketCategory::where('id', $id)->firstOrFail();
            $category->name = $data['name'];
            $category->slug = Str::slug($data['name']) . '-' . Str::lower(Str::random(10));
            $category->description = $data['description'];
            $category->save();

            return response()->json(
                [
                    'success' => true,
                    'message' => 'Berhasil mengubah kategori tiket',
                    'data' => new TicketCategoryResource($category),
                ],
                200,
            );
        } catch (ModelNotFoundException $e) {
            return response()->json(
                [
                    'success' => false,
                    'message' => 'Kategori tiket tidak ditemukan',
                ],
                404,
            );
        } catch (\Throwable $th) {
            return response()->json(
                [
                    'success' => false,
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
            $category = TicketCategory::where('id', $id)->firstOrFail();
            $category->delete();

            return response()->json(
                [
                    'success' => true,
                    'message' => 'Berhasil menghapus kategori tiket',
                ],
                200,
            );
        } catch (ModelNotFoundException $e) {
            return response()->json(
                [
                    'success' => false,
                    'message' => 'Kategori tiket tidak ditemukan',
                ],
                404,
            );
        } catch (\Throwable $th) {
            return response()->json(
                [
                    'success' => false,
                    'message' => $th->getMessage(),
                ],
                500,
            );
        }
    }
}
