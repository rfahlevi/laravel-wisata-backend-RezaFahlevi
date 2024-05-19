@extends('layouts.app')

@section('title', 'Kategori Tiket')

@push('style')
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Kategori Tiket</h1>
            </div>
            <div class="section-body">
                <h2 class="section-title">Kategori Tiket</h2>
                <p class="section-lead">Anda bisa mengelola semua kategori Tiket, seperti mengubah, menghapus dan yang
                    lainnya.</p>
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="section-header-button pl-4 pt-4">
                                <a href="{{ route('ticketCategories.create') }}" class="btn btn-primary">
                                    <i class="fas fa-plus"></i>
                                    Tambah Kategori Tiket
                                </a>
                            </div>
                            <div class="card-header">
                                <h4>Data Kategori Tiket</h4>
                                <div class="card-header-form">
                                    <form>
                                        {{-- Search Kategori Tiket --}}
                                        <div class="input-group d-flex align-items-center">
                                            <input type="text" name="category_search" class="form-control"
                                                placeholder="Cari Kategori Tiket"
                                                value="{{ Request::get('category_search') }}">
                                            <div class="input-group-btn">
                                                <button class="btn btn-icon btn-primary">
                                                    <i class="fas fa-magnifying-glass"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="card-body">
                                {{-- Kategori Tiket Table --}}
                                <div class="table-responsive">
                                    <table class="table-bordered table-sm table-hover table-striped table">
                                        <thead>
                                            <tr class="text-center">
                                                <th>#</th>
                                                <th>Nama</th>
                                                <th>Deskripsi</th>
                                                <th>Dibuat Pada</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($ticketCategories as $ticketCategory)
                                                <tr>
                                                    <td class="align-middle text-center">
                                                        {{ $ticketCategories->firstItem() + $loop->index }}</td>
                                                    <td class="align-middle">{{ $ticketCategory->name }}</td>
                                                    <td class="align-middle">{{ $ticketCategory->description }}</td>
                                                    <td class="align-middle">{{ $ticketCategory->created_at }}</td>
                                                    <td class="align-middle text-center">
                                                        <a href="{{ route('ticketCategories.edit', $ticketCategory->slug) }}"
                                                            class="btn btn-outline-dark btn-icon">
                                                            <i class="far fa-edit"></i>
                                                        </a>
                                                        <form
                                                            action="{{ route('ticketCategories.destroy', $ticketCategory->slug) }}"
                                                            method="POST" class="d-inline">
                                                            @csrf
                                                            <input type="hidden" name="_method" value="DELETE">
                                                            <button
                                                                class="btn btn-outline-danger btn-icon swal-confirm-delete"
                                                                data-name="{{ $ticketCategory->name }}">
                                                                <i class="fas fa-trash-alt"></i>
                                                            </button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="card-footer text-right float-right">
                                {{ $ticketCategories->withQueryString()->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
@endpush
